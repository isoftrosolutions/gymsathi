@extends('layouts.admin')

@section('title', 'Offline Sync Health')

@section('content')
<div class="space-y-8 pb-24">
    <!-- Breadcrumb -->
    <nav class="flex text-on-variant text-xs uppercase font-bold tracking-widest gap-2">
        <a href="{{ route('admin.monitoring.index') }}" class="hover:text-primary-lime">Monitoring</a>
        <span>/</span>
        <span class="text-white">Offline Sync Health</span>
    </nav>

    <!-- Header Section -->
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-headline font-bold text-white mb-2 uppercase italic tracking-tighter">OFFLINE SYNC HEALTH</h1>
            <p class="text-on-variant font-label max-w-xl">Comprehensive tracking of local gym database state vs cloud center. Yellow and Red indicators require intervention.</p>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <div class="text-[10px] text-on-variant uppercase font-bold tracking-widest">Total Pending Across Ecosystem</div>
                <div class="text-3xl font-headline font-bold text-yellow-400">{{ $totalPending }} Records</div>
            </div>
            <button class="bg-primary-lime text-black p-4 rounded-xl hover:rotate-180 transition-all duration-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </button>
        </div>
    </div>

    @if($criticalCount > 0)
    <!-- Critical Alert Banner -->
    <div class="bg-red-500/10 border border-red-500/20 p-6 rounded-3xl flex items-center gap-6 animate-pulse">
        <div class="w-12 h-12 rounded-full bg-red-500 text-white flex items-center justify-center animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <h3 class="font-headline font-bold text-red-500 uppercase tracking-wider">CRITICAL INCIDENT</h3>
            <p class="text-on-variant text-sm">{{ $criticalCount }} gyms have a sync backlog exceeding 20 records. Check local internet connectivity or possible database conflicts.</p>
        </div>
    </div>
    @endif

    <!-- Health Table -->
    <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden shadow-2xl">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-black/40 border-b border-primary-border text-[10px] uppercase font-bold tracking-[0.2em] text-on-variant">
                    <th class="px-8 py-6">Gym Entity</th>
                    <th class="px-8 py-6">Pending Operations</th>
                    <th class="px-8 py-6">Last Active Sync</th>
                    <th class="px-8 py-6">Status Vector</th>
                    <th class="px-8 py-6">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($tenants as $tenant)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-black/40 border border-primary-border flex items-center justify-center font-headline text-lg group-hover:border-primary-lime transition-all">
                                {{ substr($tenant->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-white">{{ $tenant->name }}</div>
                                <div class="text-[10px] text-on-variant uppercase">{{ $tenant->slug }}.gymsathi.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 font-headline">
                        <span class="text-xl font-bold {{ $tenant->pending_sync_count > 0 ? ($tenant->pending_sync_count > 20 ? 'text-red-500' : 'text-yellow-400') : 'text-primary-lime' }}">
                            {{ number_format($tenant->pending_sync_count) }}
                        </span>
                        <span class="text-[10px] text-on-variant ml-1">OPREATIONS</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-sm text-white">{{ $tenant->last_sync_at ? $tenant->last_sync_at->diffForHumans() : 'No Sync Data' }}</div>
                        <div class="text-[10px] text-on-variant uppercase tracking-widest">{{ $tenant->last_sync_at ? $tenant->last_sync_at->format('M d, H:i') : '--' }}</div>
                    </td>
                    <td class="px-8 py-6">
                        @if($tenant->pending_sync_count == 0)
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-500/10 text-green-500 text-[10px] font-bold tracking-widest">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                HEALTHY
                            </div>
                        @elseif($tenant->pending_sync_count <= 20)
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-400/10 text-yellow-400 text-[10px] font-bold tracking-widest">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                                CHECK REQ
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500/10 text-red-500 text-[10px] font-bold tracking-widest">
                                <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                                CRITICAL
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <button class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 12l-4-4m4 4l4-4m6 0v12m0-12l-4 4m4-4l4 4"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer Help -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm font-label text-on-variant">
        <div class="flex gap-4">
            <div class="w-2 h-2 bg-green-500 mt-2 rounded-full"></div>
            <p><strong>Healthy</strong> means the gym is successfully syncing with the cloud within a 30-minute window.</p>
        </div>
        <div class="flex gap-4">
            <div class="w-2 h-2 bg-yellow-400 mt-2 rounded-full"></div>
            <p><strong>Check Req</strong> triggers when local records vary by more than 5 or sync has been silent for > 1 hour.</p>
        </div>
        <div class="flex gap-4">
            <div class="w-2 h-2 bg-red-500 mt-2 rounded-full"></div>
            <p><strong>Critical</strong> means sync is likely broken or local database is heavily outdated.</p>
        </div>
    </div>
</div>
@endsection
