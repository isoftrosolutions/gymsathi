@extends('layouts.gym')

@section('title', 'Dashboard')

@section('content')
{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Active Members --}}
    <div class="bg-primary-surface border border-primary-border p-6 rounded-2xl">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-primary-lime/10 flex items-center justify-center text-primary-lime">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <a href="{{ route('gym.members.index') }}" class="text-[10px] text-primary-lime font-bold hover:underline">View &rarr;</a>
        </div>
        <div class="text-on-variant text-[10px] uppercase tracking-widest font-bold mb-1">Active Members</div>
        <div class="text-3xl font-headline font-bold text-white">{{ number_format($activeMembers) }}</div>
    </div>

    {{-- Today's Collection --}}
    <div class="bg-primary-surface border border-primary-border p-6 rounded-2xl">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-[10px] text-on-variant">{{ $todayPaymentCount }} payment{{ $todayPaymentCount != 1 ? 's' : '' }}</span>
        </div>
        <div class="text-on-variant text-[10px] uppercase tracking-widest font-bold mb-1">Today's Collection</div>
        <div class="text-3xl font-headline font-bold text-white">Rs {{ number_format($todayCollection) }}</div>
    </div>

    {{-- Pending Dues --}}
    <div class="bg-primary-surface border-l-4 border-l-red-500/50 border border-primary-border p-6 rounded-2xl">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <span class="text-[10px] text-red-400 font-bold">{{ $unpaidCount }} member{{ $unpaidCount != 1 ? 's' : '' }}</span>
        </div>
        <div class="text-on-variant text-[10px] uppercase tracking-widest font-bold mb-1">Dues Remaining</div>
        <div class="text-3xl font-headline font-bold text-white">Rs {{ number_format($expiredDues) }}</div>
    </div>

    {{-- Expiring Soon --}}
    <div class="bg-primary-surface border border-primary-border p-6 rounded-2xl">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-500/10 flex items-center justify-center text-yellow-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-[10px] text-on-variant">Next 7 days</span>
        </div>
        <div class="text-on-variant text-[10px] uppercase tracking-widest font-bold mb-1">Expiring Soon</div>
        <div class="text-3xl font-headline font-bold text-white">{{ $expiringSoon }}</div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 space-y-6">

        {{-- Revenue Chart --}}
        <div class="bg-primary-surface border border-primary-border rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-headline font-bold text-white">Revenue — Last 6 Months</h3>
                    <p class="text-xs text-on-variant">Monthly collection from member packages</p>
                </div>
            </div>
            <div class="h-48 flex items-end justify-between gap-3">
                @foreach($revenueData as $month)
                @php $pct = $maxRevenue > 0 ? round(($month['amount'] / $maxRevenue) * 100) : 0; @endphp
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[9px] text-on-variant font-bold">
                        @if($month['amount'] > 0)
                            @if($month['amount'] >= 1000)
                                Rs {{ number_format($month['amount'] / 1000, 1) }}k
                            @else
                                Rs {{ number_format($month['amount'], 0) }}
                            @endif
                        @endif
                    </span>
                    <div class="w-full relative h-36 flex flex-col justify-end">
                        <div class="bg-primary-lime/60 w-full rounded-t-lg transition-all hover:bg-primary-lime"
                             style="height: {{ max($pct, 2) }}%"
                             title="Rs {{ number_format($month['amount']) }}"></div>
                    </div>
                    <span class="text-[10px] uppercase font-bold text-on-variant">{{ $month['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Today's Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Today's Pulse --}}
            <div class="bg-primary-surface border border-primary-border rounded-2xl p-6">
                <h3 class="text-base font-headline font-bold text-white mb-4">Today's Pulse</h3>
                <div class="flex items-center gap-5">
                    @php
                        $pctCheckin = $activeMembers > 0 ? min(round(($todayCheckins / $activeMembers) * 100), 100) : 0;
                        $dasharray = 264;
                        $dashoffset = $dasharray - ($dasharray * $pctCheckin / 100);
                    @endphp
                    <div class="relative w-20 h-20 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="40" cy="40" r="34" stroke="currentColor" stroke-width="7" fill="transparent" class="text-white/5"/>
                            <circle cx="40" cy="40" r="34" stroke="currentColor" stroke-width="7" fill="transparent"
                                stroke-dasharray="{{ $dasharray }}" stroke-dashoffset="{{ $dashoffset }}" class="text-primary-lime transition-all"/>
                        </svg>
                        <span class="absolute text-xl font-headline font-bold text-white">{{ $todayCheckins }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">Check-ins Today</div>
                        @if($checkinChange !== null)
                            <div class="text-xs {{ $checkinChange >= 0 ? 'text-primary-lime' : 'text-red-400' }}">
                                {{ $checkinChange >= 0 ? '+' : '' }}{{ $checkinChange }}% vs yesterday
                            </div>
                        @else
                            <div class="text-xs text-on-variant">No data yesterday</div>
                        @endif
                        <a href="{{ route('gym.attendance.index') }}" class="text-[10px] text-on-variant hover:text-primary-lime transition-colors mt-1 inline-block">View attendance &rarr;</a>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-primary-surface border border-primary-border rounded-2xl p-6">
                <h3 class="text-base font-headline font-bold text-white mb-4">Quick Actions</h3>
                <div class="space-y-2.5">
                    <a href="{{ route('gym.members.create') }}" class="w-full kinetic-gradient text-black font-headline font-bold py-3 rounded-xl flex items-center justify-center gap-2 hover:opacity-90 transition-all text-xs uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Add Member
                    </a>
                    <a href="{{ route('gym.attendance.create') }}" class="w-full bg-white/5 border border-primary-border rounded-xl py-2.5 flex items-center justify-center gap-2 text-white font-headline font-bold transition-all hover:bg-white/10 text-xs uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Mark Attendance
                    </a>
                    <a href="{{ route('gym.payments.create') }}" class="w-full bg-white/5 border border-primary-border rounded-xl py-2.5 flex items-center justify-center gap-2 text-white font-headline font-bold transition-all hover:bg-white/10 text-xs uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Record Payment
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Right Column --}}
    <div class="space-y-6">

        {{-- Renewal Alerts --}}
        <div class="bg-primary-surface border border-primary-border rounded-2xl p-6">
            <div class="flex items-center gap-2 mb-5">
                @if($renewalAlerts->isNotEmpty())
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                </span>
                @endif
                <h3 class="text-base font-headline font-bold text-white">Renewal Alerts</h3>
            </div>

            @forelse($renewalAlerts as $alert)
            @php
                $daysLeft = now()->diffInDays($alert->end_date, false);
                $isExpired = $daysLeft < 0;
                $borderColor = $isExpired ? 'border-l-red-500' : 'border-l-yellow-500';
                $badgeColor  = $isExpired ? 'text-red-400'    : 'text-yellow-400';
                $label = $isExpired
                    ? 'Expired ' . abs($daysLeft) . 'd ago'
                    : ($daysLeft === 0 ? 'Expires today' : 'In ' . $daysLeft . 'd');
            @endphp
            <div class="p-3 bg-white/5 border-l-4 {{ $borderColor }} rounded-lg flex justify-between items-center mb-2 hover:bg-white/8 transition-all">
                <div>
                    <div class="text-sm font-bold text-white">{{ $alert->user->name }}</div>
                    <div class="text-[10px] font-bold {{ $badgeColor }} uppercase tracking-tight">{{ $label }}</div>
                </div>
                <a href="{{ route('gym.payments.create') }}?member={{ $alert->user_id }}"
                   class="w-8 h-8 rounded-full bg-primary-lime/10 flex items-center justify-center text-primary-lime hover:bg-primary-lime hover:text-black transition-all" title="Record renewal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </a>
            </div>
            @empty
            <p class="text-xs text-on-variant text-center py-4">No renewals due in the next 7 days.</p>
            @endforelse
        </div>

        {{-- Notice Board --}}
        <div class="bg-primary-surface border border-primary-border rounded-2xl p-6 flex flex-col">
            <h3 class="text-base font-headline font-bold text-white mb-5">Notice Board</h3>
            <div class="flex-1 space-y-5 custom-scrollbar">
                @forelse($notices as $notice)
                <div class="relative pl-4 border-l-2 {{ $loop->first ? 'border-primary-lime' : 'border-white/20' }}">
                    <div class="text-[10px] uppercase font-bold text-on-variant mb-1">
                        {{ ($notice->sent_at ?? $notice->created_at)->format('M d, Y') }}
                    </div>
                    <div class="text-sm font-bold text-white mb-1">{{ $notice->title }}</div>
                    <p class="text-[10px] text-on-variant leading-relaxed line-clamp-2">{{ $notice->message }}</p>
                </div>
                @empty
                <p class="text-xs text-on-variant text-center py-4">No announcements yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- Recent Members --}}
<div class="bg-primary-surface border border-primary-border rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-primary-border flex justify-between items-center">
        <h3 class="text-lg font-headline font-bold text-white">Recent Members</h3>
        <a href="{{ route('gym.members.index') }}" class="text-xs font-bold text-primary-lime hover:underline">View All &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-on-variant font-bold border-b border-primary-border/30 bg-black/10">
                    <th class="px-6 py-3">Member</th>
                    <th class="px-6 py-3">Joined</th>
                    <th class="px-6 py-3">Package</th>
                    <th class="px-6 py-3 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-border/20">
                @forelse($recentMembers as $member)
                @php
                    $latestPkg = $member->memberPackages->sortByDesc('created_at')->first();
                    $pkgStatus = $latestPkg ? $latestPkg->status : null;
                @endphp
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary-lime/10 flex items-center justify-center text-xs font-bold text-primary-lime shrink-0">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </div>
                            <div>
                                <a href="{{ route('gym.members.show', $member->id) }}" class="text-sm font-bold text-white hover:text-primary-lime transition-colors">
                                    {{ $member->name }}
                                </a>
                                <div class="text-[10px] text-on-variant">{{ $member->phone ?? $member->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs text-on-variant">{{ $member->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-xs text-on-variant">
                        {{ $latestPkg?->gymPackage?->name ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($pkgStatus === 'active')
                            <span class="px-2.5 py-1 bg-primary-lime/10 text-primary-lime text-[10px] font-bold rounded-full">Active</span>
                        @elseif($pkgStatus === 'expired')
                            <span class="px-2.5 py-1 bg-red-500/10 text-red-400 text-[10px] font-bold rounded-full">Expired</span>
                        @else
                            <span class="px-2.5 py-1 bg-white/5 text-on-variant text-[10px] font-bold rounded-full">No Package</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-xs text-on-variant">
                        No members yet. <a href="{{ route('gym.members.create') }}" class="text-primary-lime hover:underline">Add your first member</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
