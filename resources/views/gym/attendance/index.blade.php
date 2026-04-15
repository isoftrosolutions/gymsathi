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

<div class="bg-primary-surface border border-primary-border rounded-3xl p-6 mb-6">
    <form method="GET" class="flex items-center gap-4">
        <div class="flex items-center gap-2">
            <label class="text-sm text-on-variant">Date:</label>
            <input type="date" name="date" value="{{ $date }}" class="bg-black/20 border border-primary-border rounded-xl py-2 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        <button type="submit" class="px-4 py-2 bg-primary-lime/10 border border-primary-lime text-primary-lime rounded-xl hover:bg-primary-lime/20 transition-all">
            Filter
        </button>
    </form>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="text-[10px] uppercase tracking-widest text-on-variant font-label border-b border-primary-border/50 bg-black/5">
                <th class="px-8 py-6">Member</th>
                <th class="px-8 py-6">Check In</th>
                <th class="px-8 py-6">Check Out</th>
                <th class="px-8 py-6">Duration</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-primary-border/30">
            @forelse($attendances as $attendance)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-lime/10 flex items-center justify-center text-primary-lime font-bold">
                            {{ strtoupper(substr($attendance->user->name, 0, 1)) }}
                        </div>
                        <div class="text-sm font-bold text-white">{{ $attendance->user->name }}</div>
                    </div>
                </td>
                <td class="px-8 py-6 text-sm text-white">
                    {{ $attendance->checked_in_at->format('H:i:s') }}
                </td>
                <td class="px-8 py-6 text-sm text-on-variant">
                    {{ $attendance->checked_out_at?->format('H:i:s') ?? '-' }}
                </td>
                <td class="px-8 py-6 text-sm text-on-variant">
                    @if($attendance->checked_out_at)
                        {{ $attendance->checked_in_at->diffForHumans($attendance->checked_out_at, true) }}
                    @else
                        <span class="text-primary-lime">Active</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-8 py-12 text-center text-on-variant">
                    No attendance records for this date.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-6 border-t border-primary-border">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
