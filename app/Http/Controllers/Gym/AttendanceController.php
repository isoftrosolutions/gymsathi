<?php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $date = $request->get('date', now()->toDateString());

        $attendances = Attendance::where('tenant_id', $tenant->id)
            ->whereDate('checked_in_at', $date)
            ->with('user', 'user.memberPackage.gymPackage')
            ->latest()
            ->paginate(50);

        $totalCheckedIn = Attendance::where('tenant_id', $tenant->id)
            ->whereDate('checked_in_at', $date)
            ->count();

        $currentlyInGym = Attendance::where('tenant_id', $tenant->id)
            ->whereDate('checked_in_at', $date)
            ->whereNull('checked_out_at')
            ->count();

        $yesterdayCount = Attendance::where('tenant_id', $tenant->id)
            ->whereDate('checked_in_at', now()->subDay()->toDateString())
            ->count();

        $changePercent = $yesterdayCount > 0 ? round((($totalCheckedIn - $yesterdayCount) / $yesterdayCount) * 100) : 0;

        $totalMembers = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->count();

        $attendanceRate = $totalMembers > 0 ? round(($totalCheckedIn / $totalMembers) * 100, 1) : 0;

        $atRiskMembers = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->whereDoesntHave('attendances', function ($q) {
                $q->where('checked_in_at', '>=', now()->subDays(7)->toDateString());
            })
            ->limit(10)
            ->get();

        return view('gym.attendance.index', compact(
            'attendances',
            'date',
            'totalCheckedIn',
            'currentlyInGym',
            'changePercent',
            'attendanceRate',
            'atRiskMembers',
            'totalMembers'
        ));
    }

    public function create(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $members = User::where('tenant_id', $tenant->id)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->get();

        return view('gym.attendance.create', compact('members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = $request->user()->tenant;

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:check_in,check_out',
        ]);

        $user = User::where('tenant_id', $tenant->id)->findOrFail($validated['user_id']);

        if ($validated['action'] === 'check_in') {
            Attendance::create([
                'tenant_id' => $tenant->id,
                'user_id' => $validated['user_id'],
                'checked_in_at' => now(),
                'method' => 'manual',
            ]);

            return back()->with('success', $user->name.' checked in!');
        } else {
            $lastAttendance = Attendance::where('user_id', $validated['user_id'])
                ->whereNull('checked_out_at')
                ->latest()
                ->first();

            if ($lastAttendance) {
                $lastAttendance->update(['checked_out_at' => now()]);

                return back()->with('success', $user->name.' checked out!');
            }

            return back()->with('error', 'No active check-in found for this member.');
        }
    }

    public function report(Request $request): View
    {
        $tenant = $request->user()->tenant;

        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $report = Attendance::where('tenant_id', $tenant->id)
            ->whereBetween('checked_in_at', [$startDate, $endDate])
            ->selectRaw('DATE(checked_in_at) as date, COUNT(*) as total, COUNT(DISTINCT user_id) as unique_members')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('gym.attendance.report', compact('report', 'startDate', 'endDate'));
    }
}
