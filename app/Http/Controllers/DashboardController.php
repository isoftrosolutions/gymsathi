<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\MemberPackage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        // Platform admins don't have tenants
        if ($user->platform_role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role?->slug === 'member') {
            $package = $user->activeMemberPackage;
            $payments = MemberPackage::where('user_id', $user->id)
                ->with('gymPackage')
                ->latest()
                ->take(5)
                ->get();

            $attendanceLast30 = Attendance::where('user_id', $user->id)
                ->where('checked_in_at', '>=', now()->subDays(30))
                ->orderBy('checked_in_at')
                ->get();

            $totalSessions = Attendance::where('user_id', $user->id)->count();

            // Streak: consecutive days with at least one check-in ending today
            $streak = 0;
            $checkDay = now()->startOfDay();
            while (true) {
                $hasCheckin = Attendance::where('user_id', $user->id)
                    ->whereDate('checked_in_at', $checkDay)
                    ->exists();
                if (! $hasCheckin) {
                    break;
                }
                $streak++;
                $checkDay = $checkDay->subDay();
            }

            $notices = Announcement::where('status', 'sent')
                ->latest('sent_at')
                ->take(3)
                ->get();

            return view('dashboard.member', compact(
                'package', 'payments', 'attendanceLast30',
                'totalSessions', 'streak', 'notices'
            ));
        }

        $tenant = $user->tenant;

        if (! $tenant) {
            abort(403, 'No tenant associated with this user.');
        }

        $tenantId = $tenant->id;
        $today = now()->toDateString();

        // KPI stats
        $activeMembers = User::where('tenant_id', $tenantId)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->count();

        $todayCollection = MemberPackage::where('tenant_id', $tenantId)
            ->whereDate('created_at', $today)
            ->sum('amount_paid');

        $todayPaymentCount = MemberPackage::where('tenant_id', $tenantId)
            ->whereDate('created_at', $today)
            ->count();

        // Overdue dues = sum of (package price − amount paid) where there's an outstanding balance
        $unpaidPackages = MemberPackage::where('tenant_id', $tenantId)
            ->with('gymPackage')
            ->get()
            ->filter(fn ($p) => $p->gymPackage && $p->gymPackage->price > $p->amount_paid);

        $expiredDues = $unpaidPackages->sum(fn ($p) => $p->gymPackage->price - $p->amount_paid);
        $unpaidCount = $unpaidPackages->count();

        $expiringSoon = MemberPackage::where('tenant_id', $tenantId)
            ->where('status', 'active')
            ->whereBetween('end_date', [$today, now()->addDays(7)->toDateString()])
            ->count();

        // Today's check-ins
        $todayCheckins = Attendance::where('tenant_id', $tenantId)
            ->whereDate('checked_in_at', $today)
            ->count();

        $yesterdayCheckins = Attendance::where('tenant_id', $tenantId)
            ->whereDate('checked_in_at', now()->subDay()->toDateString())
            ->count();

        $checkinChange = $yesterdayCheckins > 0
            ? round((($todayCheckins - $yesterdayCheckins) / $yesterdayCheckins) * 100)
            : null;

        // Monthly revenue for last 6 months
        $revenueData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $amount = MemberPackage::where('tenant_id', $tenantId)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount_paid');
            $revenueData->push([
                'label' => $month->format('M'),
                'amount' => $amount,
            ]);
        }
        $maxRevenue = $revenueData->max('amount') ?: 1;

        // Renewal alerts — members whose package expires in 7 days or already expired
        $renewalAlerts = MemberPackage::where('tenant_id', $tenantId)
            ->where('status', 'active')
            ->where('end_date', '<=', now()->addDays(7)->toDateString())
            ->with('user')
            ->orderBy('end_date')
            ->take(5)
            ->get();

        // Recent members
        $recentMembers = User::where('tenant_id', $tenantId)
            ->whereHas('role', fn ($q) => $q->where('slug', 'member'))
            ->with('memberPackages')
            ->latest()
            ->take(5)
            ->get();

        // Notice board — active platform announcements
        $notices = Announcement::where('status', 'sent')
            ->latest('sent_at')
            ->take(3)
            ->get();

        return view('dashboard.gym', compact(
            'tenant',
            'activeMembers',
            'todayCollection',
            'todayPaymentCount',
            'expiredDues',
            'unpaidCount',
            'expiringSoon',
            'todayCheckins',
            'checkinChange',
            'revenueData',
            'maxRevenue',
            'renewalAlerts',
            'recentMembers',
            'notices',
        ));
    }
}
