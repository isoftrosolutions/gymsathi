@extends('layouts.admin')

@section('title', 'Kinetic Overview')

@section('content')
<div class="mb-12 flex justify-between items-end">
    <div>
        <h1 class="text-4xl font-headline font-bold text-white mb-2">Kinetic Overview</h1>
        <p class="text-on-variant text-lg">Real-time platform engine status and growth trajectory.</p>
    </div>
    <div class="flex gap-4">
        <button class="px-6 py-3 border border-primary-border rounded-xl text-white font-headline font-bold hover:bg-white/5 transition-all">Generate Global Report</button>
        <button class="px-6 py-3 bg-white/5 border border-primary-border rounded-xl text-white font-headline font-bold hover:bg-white/10 transition-all">System Settings</button>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Stat Card -->
    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="text-on-variant text-xs uppercase tracking-[0.2em] font-label mb-4">Total Gyms</div>
            <div class="text-5xl font-headline font-bold text-white mb-4">{{ number_format($stats['total_gyms']) }}</div>
            <div class="flex items-center gap-2 text-primary-lime text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+12% this month</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        </div>
    </div>

    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10 border-l-4 border-primary-lime pl-6">
            <div class="text-on-variant text-xs uppercase tracking-[0.2em] font-label mb-4">Active Members</div>
            <div class="text-5xl font-headline font-bold text-white mb-4">{{ $stats['active_members'] }}</div>
            <div class="flex items-center gap-2 text-primary-lime text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+5.4k new seats</span>
            </div>
        </div>
    </div>

    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="text-on-variant text-xs uppercase tracking-[0.2em] font-label mb-4">Monthly Revenue</div>
            <div class="text-5xl font-headline font-bold text-white mb-4">{{ $stats['monthly_revenue'] }}</div>
            <div class="flex items-center gap-2 text-primary-lime text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>MRR up 8.2%</span>
            </div>
        </div>
    </div>

    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="text-on-variant text-xs uppercase tracking-[0.2em] font-label mb-4">Growth Rate</div>
            <div class="text-5xl font-headline font-bold text-white mb-4">{{ $stats['growth_rate'] }}</div>
            <div class="flex items-center gap-2 text-primary-lime text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Peak Performance</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <!-- Performance Chart Placeholder -->
    <div class="lg:col-span-2 bg-primary-surface border border-primary-border rounded-3xl p-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h3 class="text-xl font-headline font-bold text-white">System Health & Performance</h3>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 bg-primary-lime rounded-full"></span>
                    <span class="text-primary-lime text-[10px] uppercase font-bold tracking-widest">Uptime 99.98%</span>
                </div>
            </div>
            <button class="p-2 text-on-variant hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
            </button>
        </div>
        
        <div class="h-64 flex items-end justify-between gap-4 mb-8">
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-32"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-48"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-40"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-24"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-56"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-52"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-44"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-36"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-60"></div>
            <div class="flex-1 bg-white/5 rounded-t-lg transition-all hover:bg-primary-lime/20 h-48"></div>
            <div class="flex-1 bg-white/10 border-t-4 border-white rounded-t-lg h-64"></div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-black/20 p-6 rounded-2xl border border-primary-border/30">
                <div class="text-[10px] text-on-variant uppercase tracking-widest mb-1">Server Load</div>
                <div class="text-2xl font-headline font-bold text-white">24%</div>
            </div>
            <div class="bg-black/20 p-6 rounded-2xl border border-primary-border/30">
                <div class="text-[10px] text-on-variant uppercase tracking-widest mb-1">Latency</div>
                <div class="text-2xl font-headline font-bold text-white">42ms</div>
            </div>
            <div class="bg-black/20 p-6 rounded-2xl border border-primary-border/30">
                <div class="text-[10px] text-on-variant uppercase tracking-widest mb-1">Active API Calls</div>
                <div class="text-2xl font-headline font-bold text-white">1.2k/s</div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 flex flex-col">
        <h3 class="text-xl font-headline font-bold text-white mb-8">Recent Activity</h3>
        
        <div class="flex-1 space-y-6 overflow-y-auto pr-2 custom-scrollbar">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-primary-lime flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-white">New Registration</div>
                    <div class="text-xs text-on-variant">Muscle Bank Birgunj onboarded.</div>
                    <div class="text-[10px] text-on-variant/50 uppercase tracking-tighter mt-1">2 mins ago</div>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-xl bg-primary-lime/10 flex items-center justify-center text-primary-lime flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-white">Plan Upgrade</div>
                    <div class="text-xs text-on-variant">Elite Fitness moved to Premium.</div>
                    <div class="text-[10px] text-on-variant/50 uppercase tracking-tighter mt-1">45 mins ago</div>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-white">System Alert</div>
                    <div class="text-xs text-on-variant">Database cluster A node sync delay.</div>
                    <div class="text-[10px] text-on-variant/50 uppercase tracking-tighter mt-1">1 hour ago</div>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-on-variant flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-white">Security Audit</div>
                    <div class="text-xs text-on-variant">Monthly compliance check passed.</div>
                    <div class="text-[10px] text-on-variant/50 uppercase tracking-tighter mt-1">3 hours ago</div>
                </div>
            </div>
        </div>

        <button class="w-full mt-6 py-4 border border-primary-border rounded-xl text-xs uppercase tracking-widest text-on-variant hover:text-white transition-all">View All Logs</button>
    </div>
</div>

<!-- Gym Directory -->
<div class="bg-primary-surface border border-primary-border rounded-3xl relative overflow-hidden">
    <div class="p-8 border-b border-primary-border flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h3 class="text-2xl font-headline font-bold text-white">Gym Directory</h3>
            <p class="text-on-variant text-sm mt-1">Managing {{ number_format($stats['total_gyms']) }} active nodes across the platform.</p>
        </div>
        <div class="relative w-full md:w-96">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-on-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Search by name, owner or location..." class="w-full bg-black/20 border border-primary-border rounded-2xl py-4 pl-12 pr-6 text-sm text-on-surface focus:outline-none focus:border-primary-lime transition-all">
            <button class="absolute -right-2 -top-2 w-10 h-10 kinetic-gradient rounded-full flex items-center justify-center text-black shadow-lg shadow-primary-lime/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-on-variant font-label border-b border-primary-border/50 bg-black/5">
                    <th class="px-8 py-6">Gym Name</th>
                    <th class="px-8 py-6">Owner</th>
                    <th class="px-8 py-6">Plan Type</th>
                    <th class="px-8 py-6">Sync Status</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-border/30">
                @foreach($tenants as $tenant)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-primary-lime">
                                @if($tenant->plan === 'premium')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">{{ $tenant->name }}</div>
                                <div class="text-xs text-on-variant">{{ $tenant->slug }}.gymsathi.test</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-sm text-white">iSoftro Manager</div>
                        <div class="text-[10px] text-on-variant uppercase tracking-tight">ID: #GS-{{ 1000 + $tenant->id }}</div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest rounded-full border
                            {{ $tenant->plan === 'premium' ? 'bg-primary-lime/10 border-primary-lime text-primary-lime' : '' }}
                            {{ $tenant->plan === 'standard' ? 'bg-blue-500/10 border-blue-500 text-blue-500' : '' }}
                            {{ $tenant->plan === 'basic' ? 'bg-white/10 border-white/20 text-on-variant' : '' }}">
                            {{ $tenant->plan }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $tenant->status === 'active' ? 'bg-primary-lime' : 'bg-red-500' }}"></span>
                            <span class="text-xs text-on-variant capitalize">{{ $tenant->status === 'active' ? 'Active & Synced' : 'Syncing Issue' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <button class="p-2 text-on-variant hover:text-primary-lime transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-8 border-t border-primary-border flex justify-between items-center text-xs text-on-variant font-label">
        <div>Showing 1-10 of {{ number_format($stats['total_gyms']) }} gyms</div>
        <div class="flex gap-2">
            <button class="w-10 h-10 border border-primary-border rounded-lg flex items-center justify-center hover:bg-white/5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="w-10 h-10 border border-primary-border rounded-lg flex items-center justify-center hover:bg-white/5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>
@endsection
