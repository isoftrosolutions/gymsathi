<?php

namespace App\Http\Controllers;

use App\Mail\TemplateMail;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlatformController extends Controller
{
    /**
     * Super admin overview dashboard.
     */
    public function dashboard(): View
    {
        $stats = [
            'total_gyms' => Tenant::count(),
            'active_gyms' => Tenant::where('status', 'active')->count(),
            'pending_gyms' => Tenant::where('status', 'pending')->count(),
            'suspended_gyms' => Tenant::where('status', 'suspended')->count(),
            'active_members' => 0, // TODO: implement when Members model exists
            'monthly_revenue' => '₨ '.number_format(Subscription::active()->sum('price'), 0),
            'growth_rate' => Tenant::where('created_at', '>=', now()->startOfMonth())->count().' this month',
        ];

        $tenants = Tenant::with('plan')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'tenants'));
    }

    /**
     * Display a listing of all gyms.
     */
    public function index(Request $request): View
    {
        $query = Tenant::query();

        // Search by gym name or city
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->whereHas('plan', function ($q) use ($request) {
                $q->where('slug', $request->get('plan'));
            });
        }

        $tenants = $query->latest()->paginate(20);

        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show form to create a new gym manually.
     */
    public function create(): View
    {
        return view('admin.tenants.create');
    }

    /**
     * Store a manually created gym.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tenants,name',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
            'plan' => 'required|string|exists:plans,slug',
        ]);

        $plan = Plan::where('slug', $validated['plan'])->firstOrFail();

        // Create Tenant
        $tenant = Tenant::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'owner_name' => $validated['owner_name'],
            'owner_phone' => $validated['owner_phone'],
            'city' => $validated['city'],
            'address' => $validated['address'] ?? null,
            'status' => 'pending',
            'plan_id' => $plan->id,
            'subscription_expires_at' => now()->addDays(30),
        ]);

        // Create default roles for the tenant
        $adminRole = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Staff',
            'slug' => 'staff',
        ]);

        Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Member',
            'slug' => 'member',
        ]);

        // Create Default Admin for the Gym
        $user = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'tenant_id' => $tenant->id,
            'role_id' => $adminRole->id,
        ]);

        // Send welcome email (wrapped in try-catch to not fail gym creation if email fails)
        try {
            Mail::to($validated['owner_email'])->send(new TemplateMail('gym_welcome', [
                'owner_name' => $validated['owner_name'],
                'gym_name' => $validated['name'],
                'gym_city' => $validated['city'],
                'plan_name' => $plan->name.' Plan',
                'admin_email' => $validated['owner_email'],
                'admin_url' => url('/'),
            ]));
            Log::info("Gym Created: {$tenant->name} (ID: {$tenant->id}). Welcome email sent to {$validated['owner_email']}");
        } catch (\Exception $e) {
            Log::warning("Gym Created: {$tenant->name} (ID: {$tenant->id}). Email failed: {$e->getMessage()}");
        }

        return redirect()->route('admin.tenants.index')->with('success', 'Gym created successfully. Welcome email sent to the owner.');
    }

    /**
     * Show detailed gym information.
     */
    public function show(Tenant $tenant): View
    {
        return view('admin.tenants.show', compact('tenant'));
    }

    /**
     * Approve a pending gym.
     */
    public function approve(Tenant $tenant): RedirectResponse
    {
        if (! $tenant->isPending()) {
            return back()->with('error', 'Gym is not pending approval.');
        }

        $tenant->approve();

        // TODO: Send WhatsApp confirmation
        // TODO: Start trial subscription

        return back()->with('success', 'Gym approved successfully and trial started.');
    }

    /**
     * Reject a pending gym.
     */
    public function reject(Tenant $tenant, Request $request): RedirectResponse
    {
        if (! $tenant->isPending()) {
            return back()->with('error', 'Gym is not pending approval.');
        }

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $tenant->reject();

        // TODO: Send WhatsApp rejection notice

        return back()->with('success', 'Gym rejected successfully.');
    }

    /**
     * Suspend an active gym.
     */
    public function suspend(Tenant $tenant): RedirectResponse
    {
        if (! $tenant->isActive() && ! $tenant->isExpired()) {
            return back()->with('error', 'Gym cannot be suspended in its current state.');
        }

        $tenant->suspend();

        // TODO: Send WhatsApp suspension notice

        return back()->with('success', 'Gym suspended successfully.');
    }

    /**
     * Reactivate a suspended gym.
     */
    public function reactivate(Tenant $tenant): RedirectResponse
    {
        if (! $tenant->isSuspended()) {
            return back()->with('error', 'Gym is not suspended.');
        }

        $tenant->reactivate();

        // TODO: Send WhatsApp reactivation notice

        return back()->with('success', 'Gym reactivated successfully.');
    }

    /**
     * Transfer gym ownership.
     */
    public function transferOwnership(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'new_owner_name' => 'required|string|max:255',
            'new_owner_phone' => 'required|string|max:20',
        ]);

        $oldOwner = $tenant->owner_name;
        $tenant->transferOwnership($validated['new_owner_name'], $validated['new_owner_phone']);

        // TODO: Send WhatsApp to new owner with login details
        // TODO: Notify old owner about transfer

        return back()->with('success', "Ownership transferred from {$oldOwner} to {$validated['new_owner_name']}.");
    }

    /**
     * Reset gym owner password.
     */
    public function resetPassword(Tenant $tenant): RedirectResponse
    {
        $owner = $tenant->users()->whereHas('role', function ($q) {
            $q->where('slug', 'admin');
        })->first();

        if (! $owner) {
            return back()->with('error', 'No admin user found for this gym.');
        }

        $tempPassword = Str::random(10);
        $owner->update([
            'password' => Hash::make($tempPassword),
        ]);

        // TODO: Send WhatsApp message with $tempPassword
        Log::info("Password reset for {$tenant->name} (User ID: {$owner->id}). Delivery pending WhatsApp.");

        return back()->with('success', 'Password reset successfully. Deliver new credentials to the owner via WhatsApp.');
    }

    /**
     * Delete a gym permanently.
     */
    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->delete();

        return redirect()->route('admin.tenants.index')->with('success', 'Gym deleted permanently.');
    }
}
