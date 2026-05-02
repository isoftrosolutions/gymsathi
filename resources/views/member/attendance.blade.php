@extends('layouts.member')

@section('title', 'Attendance')
@section('topbar-title', 'Attendance')

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-primary-container mb-2">Pulse Status</p>
        <h1 class="font-syne font-black text-5xl md:text-6xl text-on-surface tracking-tighter leading-none uppercase">
            Check-In <span class="text-primary-container">History</span>
        </h1>
        <p class="text-on-surface-variant mt-3 text-base">Your consistency over the last 30 days and beyond.</p>
    </div>

    @php
        $todayCheckin = \App\Models\Attendance::where('user_id', auth()->id())
            ->whereDate('checked_in_at', now()->toDateString())
            ->exists();
    @endphp
    <div>
        @if($todayCheckin)
            <button disabled class="px-8 py-4 rounded-2xl bg-secondary/20 text-secondary font-black text-sm flex items-center gap-2 cursor-default">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                Checked In Today
            </button>
        @else
            <form id="checkin-form" method="POST" action="{{ route('member.attendance.checkin') }}">
                @csrf
                <button type="submit"
                    onclick="return confirm('Confirm check-in for today?')"
                    class="px-8 py-4 rounded-2xl bg-primary-container text-on-primary font-black text-sm flex items-center gap-2 hover:opacity-90 transition-opacity cursor-pointer">
                    <span class="material-symbols-outlined text-lg">bolt</span>
                    Check In Now
                </button>
            </form>
        @endif
    </div>
</div>

{{-- ── STATS ROW ── --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
        $monthDiff = $lastMonth > 0
            ? round((($thisMonth - $lastMonth) / $lastMonth) * 100)
            : ($thisMonth > 0 ? 100 : 0);
    @endphp

    <div class="bg-surface-container-low rounded-[2rem] p-6">
        <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">Streak</p>
        <p class="font-syne font-black text-5xl text-secondary leading-none">{{ $streak }}</p>
        <p class="text-on-surface-variant text-xs mt-2">days in a row</p>
    </div>

    <div class="bg-surface-container-low rounded-[2rem] p-6">
        <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">This Month</p>
        <p class="font-syne font-black text-5xl text-primary-container leading-none">{{ $thisMonth }}</p>
        <p class="text-xs mt-2 font-bold
            {{ $monthDiff >= 0 ? 'text-secondary' : 'text-error' }}">
            {{ $monthDiff >= 0 ? '+' : '' }}{{ $monthDiff }}% vs last month
        </p>
    </div>

    <div class="bg-surface-container-low rounded-[2rem] p-6">
        <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">Last Month</p>
        <p class="font-syne font-black text-5xl text-on-surface leading-none">{{ $lastMonth }}</p>
        <p class="text-on-surface-variant text-xs mt-2">sessions</p>
    </div>

    <div class="bg-surface-container-low rounded-[2rem] p-6">
        <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">All Time</p>
        <p class="font-syne font-black text-5xl text-on-surface leading-none">{{ $totalSessions }}</p>
        <p class="text-on-surface-variant text-xs mt-2">total sessions</p>
    </div>
</div>

{{-- ── BENTO ROW 2 ── --}}
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">

    {{-- ── MONTHLY BAR CHART (col 8) ── --}}
    <div class="md:col-span-8 bg-surface-container-low rounded-[2rem] p-8">
        <div class="flex justify-between items-start mb-10">
            <div>
                <h3 class="font-syne font-black text-2xl text-on-surface tracking-tight">CONSISTENCY</h3>
                <p class="text-on-surface-variant text-sm mt-1">Sessions per month — last 12 months</p>
            </div>
            <div class="text-right">
                <span class="font-syne font-black text-5xl text-secondary leading-none">{{ $streak }}</span>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mt-1">Day Streak</p>
            </div>
        </div>

        @if($monthlyData->sum('count') > 0)
            <div class="flex items-end gap-2 md:gap-3 h-40">
                @foreach($monthlyData as $m)
                @php
                    $h = $maxMonthly > 0 ? max(4, round(($m['count'] / $maxMonthly) * 100)) : 4;
                    $isLatest = $loop->last;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-2 group">
                    <span class="text-[9px] text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity font-bold">
                        {{ $m['count'] }}
                    </span>
                    <div class="w-full rounded-t-xl transition-all duration-500
                        {{ $m['count'] > 0
                            ? ($isLatest ? 'bg-secondary shadow-[0_0_15px_rgba(68,250,164,0.3)]' : 'bg-primary-container shadow-[0_0_10px_rgba(200,241,53,0.2)]')
                            : 'bg-surface-container-highest' }}"
                         style="height: {{ $h }}%"></div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-between mt-3">
                @foreach($monthlyData as $m)
                    <div class="flex-1 text-center text-[9px] text-on-surface-variant font-bold uppercase">{{ $m['label'] }}</div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-40 flex-col gap-3">
                <span class="material-symbols-outlined text-5xl text-on-surface-variant/20">bar_chart</span>
                <p class="text-on-surface-variant text-sm">No attendance data yet. Start checking in!</p>
            </div>
        @endif
    </div>

    {{-- ── 30-DAY DOT GRID (col 4) ── --}}
    <div class="md:col-span-4 bg-surface-container-low rounded-[2rem] p-8">
        <h3 class="font-syne font-black text-lg text-on-surface mb-6 tracking-tight">LAST 30 DAYS</h3>

        @php
            $dotDays     = collect();
            for ($i = 29; $i >= 0; $i--) {
                $dotDays->push(now()->subDays($i)->toDateString());
            }
            $attendedDays = $last30->map(fn($a) => $a->checked_in_at->toDateString())->unique()->flip();
        @endphp

        <div class="grid gap-1.5" style="grid-template-columns: repeat(6, minmax(0, 1fr));">
            @foreach($dotDays as $day)
                @php
                    $attended = isset($attendedDays[$day]);
                    $isToday  = $day === now()->toDateString();
                @endphp
                <div class="aspect-square rounded-lg flex items-center justify-center cursor-default group relative
                    {{ $attended ? 'bg-primary-container' : 'bg-surface-container-highest' }}
                    {{ $isToday ? 'ring-2 ring-white/40 scale-110' : '' }}"
                     title="{{ \Carbon\Carbon::parse($day)->format('M d') }}">
                    <span class="text-[8px] font-bold {{ $attended ? 'text-on-primary' : 'text-on-surface-variant/30' }}">
                        {{ \Carbon\Carbon::parse($day)->format('d') }}
                    </span>
                </div>
            @endforeach
        </div>

        <div class="flex items-center gap-4 mt-5 text-[9px] text-on-surface-variant">
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded bg-primary-container inline-block"></span>
                Attended
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded bg-surface-container-highest inline-block"></span>
                Missed
            </span>
        </div>

        {{-- Streak alert --}}
        @if($streak > 0)
        <div class="mt-6 p-4 bg-secondary/10 border border-secondary/20 rounded-2xl flex items-start gap-3">
            <span class="material-symbols-outlined ms-fill text-secondary text-xl shrink-0">local_fire_department</span>
            <div>
                <p class="font-bold text-on-surface text-sm">{{ $streak }}-day streak!</p>
                <p class="text-on-surface-variant text-xs mt-0.5">Keep the kinetic flow going.</p>
            </div>
        </div>
        @else
        <div class="mt-6 p-4 bg-surface-container-high rounded-2xl flex items-start gap-3">
            <span class="material-symbols-outlined text-on-surface-variant text-xl shrink-0">bolt</span>
            <div>
                <p class="font-bold text-on-surface text-sm">Start your streak today</p>
                <p class="text-on-surface-variant text-xs mt-0.5">Check in to begin building momentum.</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ── SESSION HISTORY LIST ── --}}
<div class="bg-surface-container-low rounded-[2rem] p-8">
    <h3 class="font-syne font-black text-xl text-on-surface tracking-tight mb-8 uppercase">Session History</h3>

    @if($recentSessions->isNotEmpty())
        <div class="space-y-3">
            @foreach($recentSessions as $session)
            @php
                $duration = $session->checked_out_at
                    ? $session->checked_in_at->diffInMinutes($session->checked_out_at)
                    : null;
            @endphp
            <div class="flex items-center justify-between px-6 py-4 bg-surface-container rounded-2xl hover:bg-surface-container-high transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl
                        {{ $loop->index < 2 ? 'bg-secondary-container/20' : 'bg-surface-container-highest' }}
                        flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl {{ $loop->index < 2 ? 'text-secondary' : 'text-on-surface-variant' }}">
                            fitness_center
                        </span>
                    </div>
                    <div>
                        <p class="text-on-surface font-bold text-sm">
                            Check-In
                            @if($session->method)
                                <span class="text-on-surface-variant font-normal">· {{ ucfirst($session->method) }}</span>
                            @endif
                        </p>
                        <p class="text-on-surface-variant text-xs mt-0.5">
                            {{ $session->checked_in_at->format('M d, Y · g:i A') }}
                        </p>
                    </div>
                </div>
                <div class="text-right flex items-center gap-4">
                    @if($duration)
                        <div>
                            <p class="font-grotesk font-bold text-on-surface text-sm">{{ $duration }}m</p>
                            <p class="text-on-surface-variant text-[10px]">duration</p>
                        </div>
                    @endif
                    @if($session->checked_out_at)
                        <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase bg-secondary/10 text-secondary border border-secondary/20">
                            Complete
                        </span>
                    @else
                        <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase bg-primary-container/10 text-primary-container border border-primary-container/20">
                            Checked In
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <span class="material-symbols-outlined text-7xl text-on-surface-variant/10 mb-5">how_to_reg</span>
            <h4 class="font-syne font-black text-2xl text-on-surface mb-2">No Sessions Yet</h4>
            <p class="text-on-surface-variant text-sm max-w-xs mx-auto">
                Your attendance history will appear here once you start checking in at the gym.
            </p>
        </div>
    @endif
</div>

@endsection
