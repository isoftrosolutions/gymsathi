@extends('layouts.gym')

@section('title', 'Attendance')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-headline font-bold text-white">Attendance</h1>
        <p class="text-on-variant mt-1">Track member check-ins</p>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('gym.attendance.report') }}" class="px-6 py-3 border border-primary-border rounded-xl text-white font-headline font-bold hover:bg-white/5 transition-all">
            View Report
        </a>
        <a href="{{ route('gym.attendance.create') }}" class="kinetic-gradient text-black font-headline font-bold px-6 py-3 rounded-xl hover:scale-105 transition-all">
            + Check In/Out
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center mb-8">
    <div class="lg:col-span-8 relative">
        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-on-variant">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </span>
        <input type="text" class="w-full bg-primary-surface border border-primary-border text-white pl-14 pr-6 py-4 rounded-2xl focus:outline-none focus:border-primary-lime transition-all text-base" placeholder="Search members by name, phone, or membership ID...">
    </div>
    <div class="lg:col-span-4">
        <a href="{{ route('gym.attendance.create') }}" class="w-full h-full kinetic-gradient text-black font-headline font-bold text-xl py-4 rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-95 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 16v1m9-9h-1M4 12h-1m12.364-5.636l-.707-.707M6.343 17.657l-.707.707m0-12.02l.707.707m12.02 0l-.707.707M6.343 6.343l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
            Quick Check-In
        </a>
    </div>
</div>

<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-primary-surface p-8 rounded-2xl relative overflow-hidden group hover:bg-black/20 transition-colors border-l-4 border-primary-lime">
        <div class="relative z-10">
            <p class="text-on-variant text-sm font-medium uppercase tracking-widest mb-1">Total Checked-In Today</p>
            <h3 class="text-5xl font-black text-primary-lime font-headline tracking-tighter">{{ $totalCheckedIn }}</h3>
            <p class="text-green-400 text-xs mt-2 flex items-center gap-1 font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                {{ $changePercent > 0 ? '+' : '' }}{{ $changePercent }}% from yesterday
            </p>
        </div>
    </div>
    <div class="bg-primary-surface p-8 rounded-2xl relative overflow-hidden group hover:bg-black/20 transition-colors border-l-4 border-green-400">
        <div class="relative z-10">
            <p class="text-on-variant text-sm font-medium uppercase tracking-widest mb-1">Currently in Gym</p>
            <h3 class="text-5xl font-black text-green-400 font-headline tracking-tighter">{{ $currentlyInGym }}</h3>
            <p class="text-on-variant text-xs mt-2 font-medium">Capacity: {{ $totalMembers > 0 ? round(($currentlyInGym / $totalMembers) * 100) : 0 }}% full</p>
        </div>
    </div>
    <div class="bg-primary-surface p-8 rounded-2xl relative overflow-hidden group hover:bg-black/20 transition-colors border-l-4 border-blue-400">
        <div class="relative z-10">
            <p class="text-on-variant text-sm font-medium uppercase tracking-widest mb-1">Attendance Rate</p>
            <h3 class="text-5xl font-black text-blue-400 font-headline tracking-tighter">{{ $attendanceRate }}%</h3>
            <p class="text-on-variant text-xs mt-2 font-medium">Avg. visits: {{ $totalMembers > 0 ? round($totalCheckedIn / $totalMembers, 1) : 0 }} / week</p>
        </div>
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <section class="lg:col-span-7 bg-primary-surface rounded-3xl overflow-hidden">
        <div class="p-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-white font-headline tracking-tight">Live Attendance Feed</h2>
                <p class="text-on-variant text-sm">Real-time updates from floor access points</p>
            </div>
            <span class="px-4 py-2 bg-green-900/30 text-green-400 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Live Updates
            </span>
        </div>
        <div class="px-8 pb-8 space-y-4">
            @forelse($attendances as $attendance)
            <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-white/[0.02] transition-all cursor-pointer">
                <div class="w-12 h-12 rounded-xl bg-primary-lime/10 flex items-center justify-center text-primary-lime font-bold text-lg">
                    {{ strtoupper(substr($attendance->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h4 class="font-headline font-bold text-white">{{ $attendance->user->name }}</h4>
                    <p class="text-xs text-on-variant">ID: {{ $attendance->user->id }}</p>
                </div>
                <div class="text-right">
                    <span class="block font-headline font-bold text-white text-sm">{{ $attendance->checked_in_at->format('H:i') }}</span>
                    @if($attendance->user->memberPackage && $attendance->user->memberPackage->gymPackage)
                    <span class="text-[10px] px-2 py-0.5 bg-primary-lime/20 text-primary-lime rounded-md font-bold">{{ $attendance->user->memberPackage->gymPackage->name }}</span>
                    @else
                    <span class="text-[10px] px-2 py-0.5 bg-green-900/30 text-green-400 rounded-md font-bold">ACTIVE</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-on-variant">
                No attendance records for this date.
            </div>
            @endforelse
        </div>

        @if($attendances->hasMorePages())
        <a href="#" class="w-full py-6 text-primary-lime font-headline font-bold border-t border-primary-border/20 hover:bg-primary-lime/5 transition-colors block text-center">
            View Complete Log
        </a>
        @endif
    </section>

    <div class="lg:col-span-5 space-y-8">
        <section class="bg-primary-surface p-8 rounded-3xl">
            <div class="flex justify-between items-start mb-10">
                <div>
                    <h2 class="text-xl font-black text-white font-headline tracking-tight">Peak Attendance</h2>
                    <p class="text-on-variant text-xs">Hourly trends (24h period)</p>
                </div>
                <div class="flex gap-2">
                    <div class="w-3 h-3 rounded-full bg-primary-lime"></div>
                    <div class="w-3 h-3 rounded-full bg-primary-border"></div>
                </div>
            </div>
            <div class="h-48 flex items-end justify-between gap-1">
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[20%]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[45%]"></div>
                <div class="flex-1 bg-primary-lime rounded-t-lg h-[90%] shadow-[0_0_20px_rgba(200,241,53,0.2)]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[75%]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[35%]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[15%]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[55%]"></div>
                <div class="flex-1 bg-primary-lime rounded-t-lg h-[85%] shadow-[0_0_20px_rgba(200,241,53,0.2)]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[60%]"></div>
                <div class="flex-1 bg-primary-border/30 rounded-t-lg h-[30%]"></div>
            </div>
            <div class="flex justify-between mt-4 text-[10px] text-on-variant uppercase font-bold tracking-widest px-1">
                <span>5am</span>
                <span>10am</span>
                <span>2pm</span>
                <span>6pm</span>
                <span>10pm</span>
            </div>
        </section>

        <section class="bg-primary-surface p-8 rounded-3xl relative overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-black text-white font-headline tracking-tight">At-Risk Members</h2>
                <span class="text-red-400 text-[10px] font-bold uppercase border border-red-400/30 px-2 py-1 rounded-md">7+ Days Absent</span>
            </div>
            <div class="space-y-6">
                @forelse($atRiskMembers as $member)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-border flex items-center justify-center font-headline font-bold text-on-variant">
                            {{ strtoupper(substr($member->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ $member->name }}</p>
                            <p class="text-[10px] text-on-variant">Last seen: 7+ days ago</p>
                        </div>
                    </div>
                    <button class="w-10 h-10 rounded-xl bg-green-500/10 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </button>
                </div>
                @empty
                <p class="text-on-variant text-sm">No at-risk members.</p>
                @endforelse
            </div>
            @if($atRiskMembers->count() > 0)
            <button class="w-full mt-8 py-3 bg-primary-border/40 rounded-xl text-xs font-bold text-white flex items-center justify-center gap-2 hover:bg-primary-lime hover:text-black transition-all">
                Bulk Reminder ({{ $atRiskMembers->count() }} Members)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
            @endif
        </section>
    </div>
</div>

<div class="fixed bottom-10 right-10 z-50">
    <a href="{{ route('gym.attendance.create') }}" class="w-16 h-16 bg-primary-lime text-black rounded-2xl shadow-[0_20px_40px_rgba(200,241,53,0.3)] flex items-center justify-center hover:scale-110 active:scale-95 transition-all">
        <svg class="w-8 h-8 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
    </a>
</div>
@endsection