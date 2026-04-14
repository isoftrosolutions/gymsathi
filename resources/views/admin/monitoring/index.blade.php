@extends('layouts.admin')

@section('title', 'System Monitoring')

@section('content')
<div class="space-y-12 pb-24">
    <!-- Header Section -->
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-headline font-bold text-white mb-2">SYSTEM MONITORING</h1>
            <p class="text-on-variant font-label">Real-time infrastructure and sync health across the ecosystem.</p>
        </div>
        <div class="flex gap-4">
            <button class="bg-primary-surface border border-primary-border text-white px-6 py-3 rounded-xl font-headline font-bold flex items-center gap-2 hover:bg-primary-border transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                REFRESH DATA
            </button>
        </div>
    </div>

    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-on-variant mb-4 font-bold">Server Health</div>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-headline font-bold text-primary-lime">99.9%</span>
                <span class="text-xs text-green-500 mb-1">UPTIME</span>
            </div>
            <div class="mt-4 w-full bg-black/40 h-1 rounded-full overflow-hidden">
                <div class="bg-primary-lime h-full w-[99%]"></div>
            </div>
        </div>

        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-on-variant mb-4 font-bold">Sync Health</div>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-headline font-bold {{ $pendingCount > 0 ? 'text-yellow-400' : 'text-primary-lime' }}">{{ $pendingCount }} Gyms</span>
                <span class="text-xs text-on-variant mb-1">PENDING SYNC</span>
            </div>
            <a href="{{ route('admin.monitoring.sync') }}" class="mt-4 block text-xs text-primary-lime hover:underline">View Sync Dashboard →</a>
        </div>

        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-on-variant mb-4 font-bold">WhatsApp API</div>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-headline font-bold text-primary-lime">Healthy</span>
                <span class="text-xs text-green-500 mb-1">STABLE</span>
            </div>
            <div class="mt-4 flex gap-1">
                @for($i=0; $i<12; $i++)
                    <div class="h-4 w-1 bg-primary-lime/40 rounded-full"></div>
                @endfor
            </div>
        </div>

        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl text-red-400">
            <div class="text-[10px] uppercase tracking-widest text-red-400/60 mb-4 font-bold">Open Errors</div>
            <div class="flex items-end gap-2 text-red-500">
                <span class="text-3xl font-headline font-bold">0</span>
                <span class="text-xs text-red-500/60 mb-1">CRITICAL</span>
            </div>
            <div class="mt-4 text-xs font-bold uppercase tracking-wider">No active incidents</div>
        </div>
    </div>

    <!-- Main Monitoring Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- API Usage Stats -->
        <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
            <div class="p-8 border-b border-primary-border flex justify-between items-center">
                <h3 class="font-headline font-bold text-white uppercase tracking-wider text-sm">Real-time API Load</h3>
                <span class="text-[10px] text-on-variant">LAST 24 HOURS</span>
            </div>
            <div class="p-8 bg-black/20">
                <div class="h-64 w-full flex items-end gap-1">
                    @php $heights = [45, 30, 60, 80, 40, 55, 90, 75, 60, 40, 30, 50, 65, 85, 95, 70, 50, 40, 30, 45, 60, 75, 55, 40]; @endphp
                    @foreach($heights as $height)
                        <div class="flex-1 bg-primary-lime/20 hover:bg-primary-lime transition-all relative group cursor-pointer" style="height: {{ $height }}%">
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white text-black px-2 py-1 rounded text-[10px] font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">{{ $height*10 }} req/s</div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-4 text-[10px] text-on-variant uppercase tracking-widest">
                    <span>00:00</span>
                    <span>Peak Hour: 18:00</span>
                    <span>23:59</span>
                </div>
            </div>
        </div>

        <!-- Sync Health Preview -->
        <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
            <div class="p-8 border-b border-primary-border flex justify-between items-center">
                <h3 class="font-headline font-bold text-white uppercase tracking-wider text-sm">Offline Sync Snapshot</h3>
                <a href="{{ route('admin.monitoring.sync') }}" class="text-xs text-primary-lime hover:underline uppercase tracking-widest font-bold">Full View</a>
            </div>
            <div class="divide-y divide-white/5">
                @foreach($tenants->take(4) as $tenant)
                    <div class="p-6 flex justify-between items-center hover:bg-white/5 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-black/40 flex items-center justify-center font-headline text-primary-lime">
                                {{ substr($tenant->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">{{ $tenant->name }}</div>
                                <div class="text-[10px] text-on-variant uppercase">{{ $tenant->last_sync_at ? $tenant->last_sync_at->diffForHumans() : 'Never Synced' }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-headline font-bold {{ $tenant->pending_sync_count > 0 ? 'text-yellow-400' : 'text-primary-lime' }}">
                                {{ $tenant->pending_sync_count }} Pending
                            </div>
                            <div class="text-[10px] uppercase font-bold {{ $tenant->pending_sync_count > 20 ? 'text-red-500' : ($tenant->pending_sync_count > 0 ? 'text-yellow-400' : 'text-green-500') }}">
                                {{ $tenant->pending_sync_count > 20 ? 'CRITICAL' : ($tenant->pending_sync_count > 0 ? 'NEEDS ATTENTION' : 'HEALTHY') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
