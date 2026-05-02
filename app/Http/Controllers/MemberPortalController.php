<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\GymPackage;
use App\Models\MemberPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberPortalController extends Controller
{
    /** ─── Profile ──────────────────────────────────────────────────── */
    public function profile(): View
    {
        $user = auth()->user()->load(['memberPackages.gymPackage', 'activeMemberPackage.gymPackage']);
        $package = $user->activeMemberPackage;
        $payments = $user->memberPackages()->with('gymPackage')->latest()->take(5)->get();

        return view('member.profile', compact('user', 'package', 'payments'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'emergency_contact' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        } else {
            unset($data['profile_picture']);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    /** ─── Membership ────────────────────────────────────────────────── */
    public function membership(): View
    {
        $user = auth()->user()->load(['activeMemberPackage.gymPackage']);
        $package = $user->activeMemberPackage;
        $history = MemberPackage::where('user_id', $user->id)
            ->with('gymPackage')
            ->latest('end_date')
            ->get();

        // Available packages from tenant
        $availablePackages = GymPackage::where('tenant_id', $user->tenant_id)
            ->active()
            ->orderBy('price')
            ->get();

        return view('member.membership', compact('user', 'package', 'history', 'availablePackages'));
    }

    /** ─── Attendance ────────────────────────────────────────────────── */
    public function attendance(): View
    {
        $user = auth()->user();

        // Today check-in status
        $todayCheckin = Attendance::where('user_id', $user->id)
            ->whereDate('checked_in_at', now()->toDateString())
            ->exists();

        // Last 30 days for heatmap
        $last30 = Attendance::where('user_id', $user->id)
            ->where('checked_in_at', '>=', now()->subDays(29)->startOfDay())
            ->orderBy('checked_in_at')
            ->get();

        // Last 12 months bar chart data
        $monthlyData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $count = Attendance::where('user_id', $user->id)
                ->whereYear('checked_in_at', $m->year)
                ->whereMonth('checked_in_at', $m->month)
                ->count();
            $monthlyData->push(['label' => $m->format('M'), 'count' => $count]);
        }
        $maxMonthly = $monthlyData->max('count') ?: 1;

        // Current streak
        $streak = 0;
        $day = now()->startOfDay();
        while (Attendance::where('user_id', $user->id)->whereDate('checked_in_at', $day)->exists()) {
            $streak++;
            $day = $day->copy()->subDay();
        }

        // Recent history (last 10 sessions)
        $recentSessions = Attendance::where('user_id', $user->id)
            ->orderByDesc('checked_in_at')
            ->take(10)
            ->get();

        $totalSessions = Attendance::where('user_id', $user->id)->count();

        // This month vs last month
        $thisMonth = Attendance::where('user_id', $user->id)
            ->whereMonth('checked_in_at', now()->month)
            ->whereYear('checked_in_at', now()->year)
            ->count();

        $lastMonth = Attendance::where('user_id', $user->id)
            ->whereMonth('checked_in_at', now()->subMonth()->month)
            ->whereYear('checked_in_at', now()->subMonth()->year)
            ->count();

        return view('member.attendance', compact(
            'last30', 'monthlyData', 'maxMonthly',
            'streak', 'recentSessions', 'totalSessions',
            'thisMonth', 'lastMonth', 'todayCheckin'
        ));
    }

    public function checkin(): RedirectResponse
    {
        $user = auth()->user();

        $todayCheckin = Attendance::where('user_id', $user->id)
            ->whereDate('checked_in_at', now()->toDateString())
            ->exists();

        if ($todayCheckin) {
            return back()->with('error', 'You have already checked in today.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Check-in successful! Keep up the great work.');
    }

    public function checkout(): RedirectResponse
    {
        $user = auth()->user();

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('checked_in_at', now()->toDateString())
            ->whereNull('checked_out_at')
            ->first();

        if (! $todayAttendance) {
            return back()->with('error', 'No active check-in found for today.');
        }

        $todayAttendance->update([
            'checked_out_at' => now(),
        ]);

        return back()->with('success', 'Check-out recorded. See you next time!');
    }
}
