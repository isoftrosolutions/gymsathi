<?php

namespace App\Http\Controllers;

use App\Models\ImpersonationLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImpersonationController extends Controller
{
    /**
     * Start impersonating a gym user.
     */
    public function start(Request $request, Tenant $tenant): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // Check if already impersonating
        if (session()->has('impersonate')) {
            return back()->with('error', 'You are already impersonating a user. Please stop the current session first.');
        }

        // Find the user to impersonate — must belong to this tenant
        $userToImpersonate = $request->user_id
            ? $tenant->users()->findOrFail($request->user_id)
            : $tenant->users()->whereHas('role', function ($q) {
                $q->where('slug', 'admin');
            })->first();

        if (! $userToImpersonate) {
            return back()->with('error', 'No user found to impersonate in this gym.');
        }

        // Create impersonation log
        $log = ImpersonationLog::startImpersonation(
            auth()->user(),
            $tenant,
            $userToImpersonate,
            $request->reason
        );

        // Store impersonation session data
        session([
            'impersonate' => [
                'original_admin_id' => auth()->id(),
                'original_admin_name' => auth()->user()->name,
                'impersonated_tenant_id' => $tenant->id,
                'impersonated_user_id' => $userToImpersonate->id,
                'log_id' => $log->id,
                'started_at' => now(),
            ],
        ]);

        // Log the impersonation start
        $tenant->logActivity('impersonation_started', auth()->user(), [
            'impersonated_user_id' => $userToImpersonate->id,
            'reason' => $request->reason,
            'log_id' => $log->id,
        ]);

        // Login as the impersonated user
        auth()->login($userToImpersonate);
        session()->regenerate();

        return redirect('/dashboard')->with('success', "You are now impersonating {$userToImpersonate->name} from {$tenant->name}.");
    }

    /**
     * Stop impersonation and return to admin account.
     */
    public function stop(): RedirectResponse
    {
        if (! session()->has('impersonate')) {
            return redirect()->route('admin.tenants.index')->with('error', 'You are not currently impersonating anyone.');
        }

        $impersonateData = session('impersonate');

        // Find and update the impersonation log
        $log = ImpersonationLog::find($impersonateData['log_id']);
        if ($log) {
            $log->endSession();
        }

        // Log the impersonation end
        $tenant = Tenant::find($impersonateData['impersonated_tenant_id']);
        if ($tenant) {
            $tenant->logActivity('impersonation_ended', User::find($impersonateData['original_admin_id']), [
                'duration_minutes' => now()->diffInMinutes($impersonateData['started_at']),
                'log_id' => $log->id ?? null,
            ]);
        }

        // Restore original admin session
        $originalAdmin = User::find($impersonateData['original_admin_id']);
        auth()->login($originalAdmin);
        session()->regenerate();

        // Clear impersonation session
        session()->forget('impersonate');

        return redirect()->route('admin.tenants.index')->with('success', 'Impersonation session ended. You are back to your admin account.');
    }

    /**
     * Show impersonation history/logs.
     */
    public function logs(Request $request): View
    {
        $query = ImpersonationLog::with(['admin', 'tenant', 'impersonatedUser']);

        // Filter by admin
        if ($request->filled('admin_id')) {
            $query->where('admin_user_id', $request->admin_id);
        }

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('impersonated_tenant_id', $request->tenant_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('started_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('started_at', '<=', $request->date_to);
        }

        $logs = $query->latest('started_at')->paginate(50);

        // Get data for filter dropdowns
        $admins = User::where('platform_role', 'admin')->select('id', 'name')->get();
        $tenants = Tenant::select('id', 'name')->get();

        // Get stats
        $stats = [
            'total_sessions' => ImpersonationLog::count(),
            'active_sessions' => ImpersonationLog::whereNull('ended_at')->count(),
            'avg_duration' => ImpersonationLog::whereNotNull('ended_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, started_at, ended_at)) as avg_minutes')
                ->first()->avg_minutes ?? 0,
            'most_impersonated_gym' => ImpersonationLog::selectRaw('impersonated_tenant_id, COUNT(*) as count')
                ->groupBy('impersonated_tenant_id')
                ->orderByDesc('count')
                ->with('tenant')
                ->first(),
        ];

        return view('impersonation.logs', compact('logs', 'stats', 'admins', 'tenants'));
    }

    /**
     * Show form to start impersonation for a gym.
     */
    public function create(Tenant $tenant): View
    {
        $users = $tenant->users()->with('role')->get();

        return view('impersonation.create', compact('tenant', 'users'));
    }

    /**
     * Check if current user is being impersonated.
     */
    public static function isImpersonating(): bool
    {
        return session()->has('impersonate');
    }

    /**
     * Get current impersonation data.
     */
    public static function getImpersonationData(): ?array
    {
        return session('impersonate');
    }

    /**
     * Get impersonation banner data for views.
     */
    public static function getBannerData(): ?array
    {
        if (! self::isImpersonating()) {
            return null;
        }

        $data = self::getImpersonationData();
        $tenant = Tenant::find($data['impersonated_tenant_id']);
        $user = User::find($data['impersonated_user_id']);

        return [
            'admin_name' => $data['original_admin_name'],
            'gym_name' => $tenant?->name,
            'user_name' => $user?->name,
            'started_at' => $data['started_at'],
        ];
    }
}
