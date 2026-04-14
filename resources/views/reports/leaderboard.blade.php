@extends('layouts.admin')

@section('title', 'Leaderboard')

@section('content')
<div class="space-y-12 pb-24">
    <!-- Header Section -->
    <div>
        <h1 class="text-4xl font-headline font-bold text-white mb-2 uppercase italic tracking-tighter">LEADERBOARD</h1>
        <p class="text-on-variant font-label">Top performing gyms across the Nepal fitness network.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Revenue Leaders -->
        <div class="space-y-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-purple-500/10 rounded-2xl">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                </div>
                <h2 class="text-2xl font-headline font-bold text-white">REVENUE GIANTS</h2>
            </div>
            
            <div class="bg-primary-surface border border-primary-border rounded-[2rem] overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-black/40 border-b border-primary-border text-[10px] uppercase font-bold tracking-[0.2em] text-on-variant">
                        <tr>
                            <th class="px-8 py-6">Rank</th>
                            <th class="px-8 py-6">Gym</th>
                            <th class="px-8 py-6 text-right">Lifetime Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($topRevenue as $index => $tenant)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6">
                                <span class="text-xl font-headline font-bold {{ $index < 3 ? 'text-primary-lime' : 'text-on-variant' }}">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-bold text-white">{{ $tenant->name }}</div>
                                <div class="text-[10px] text-on-variant uppercase">{{ $tenant->city }}</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="text-lg font-headline font-bold text-white">₨ {{ number_format($tenant->total_revenue) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Member Leaders -->
        <div class="space-y-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-blue-500/10 rounded-2xl">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="text-2xl font-headline font-bold text-white">MEMBER CHAMPIONS</h2>
            </div>
            
            <div class="bg-primary-surface border border-primary-border rounded-[2rem] overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-black/40 border-b border-primary-border text-[10px] uppercase font-bold tracking-[0.2em] text-on-variant">
                        <tr>
                            <th class="px-8 py-6">Rank</th>
                            <th class="px-8 py-6">Gym</th>
                            <th class="px-8 py-6 text-right">Active Members</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($topMembers as $index => $tenant)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6">
                                <span class="text-xl font-headline font-bold {{ $index < 3 ? 'text-primary-lime' : 'text-on-variant' }}">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-bold text-white">{{ $tenant->name }}</div>
                                <div class="text-[10px] text-on-variant uppercase">{{ $tenant->city }}</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="text-lg font-headline font-bold text-white">{{ number_format($tenant->users_count) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
