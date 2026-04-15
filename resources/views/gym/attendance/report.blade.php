@extends('layouts.gym')

@section('title', 'Attendance Report')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.attendance.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Attendance
    </a>
</div>

<div class="mb-8">
    <h1 class="text-3xl font-headline font-bold text-white">Attendance Report</h1>
    <p class="text-on-variant mt-1">View attendance statistics and trends</p>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-6 mb-8">
    <form method="GET" class="flex items-end gap-4">
        <div class="flex-1">
            <label class="block text-sm text-on-variant mb-2">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        <div class="flex-1">
            <label class="block text-sm text-on-variant mb-2">End Date</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        <button type="submit" class="kinetic-gradient text-black font-headline font-bold px-8 py-3 rounded-xl hover:scale-105 transition-all">
            Generate Report
        </button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
        <div class="flex items-center justify-between mb-4">
            <span class="text-on-variant text-sm">Total Check-ins</span>
            <svg class="w-8 h-8 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
        </div>
        <p class="text-4xl font-headline font-bold text-white">{{ $report->sum('total') }}</p>
    </div>
    
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
        <div class="flex items-center justify-between mb-4">
            <span class="text-on-variant text-sm">Unique Members</span>
            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <p class="text-4xl font-headline font-bold text-white">{{ $report->sum('unique_members') }}</p>
    </div>
    
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
        <div class="flex items-center justify-between mb-4">
            <span class="text-on-variant text-sm">Days Tracked</span>
            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <p class="text-4xl font-headline font-bold text-white">{{ $report->count() }}</p>
    </div>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
    <div class="p-6 border-b border-primary-border">
        <h3 class="text-lg font-headline font-bold text-white">Daily Breakdown</h3>
    </div>
    
    <table class="w-full text-left">
        <thead>
            <tr class="text-[10px] uppercase tracking-widest text-on-variant font-label border-b border-primary-border/50 bg-black/5">
                <th class="px-8 py-6">Date</th>
                <th class="px-8 py-6">Total Check-ins</th>
                <th class="px-8 py-6">Unique Members</th>
                <th class="px-8 py-6 text-right">Avg per Member</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-primary-border/30">
            @forelse($report as $day)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-8 py-6 text-sm text-white">
                    {{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}
                </td>
                <td class="px-8 py-6 text-sm text-white">
                    {{ $day->total }}
                </td>
                <td class="px-8 py-6 text-sm text-white">
                    {{ $day->unique_members }}
                </td>
                <td class="px-8 py-6 text-sm text-on-variant text-right">
                    {{ $day->unique_members > 0 ? number_format($day->total / $day->unique_members, 1) : '0' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-8 py-12 text-center text-on-variant">
                    No attendance records found for this date range.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
