@extends('layouts.admin')

@section('title', 'Activity Node — ' . $tenant->name)

@section('content')
<div class="space-y-12 pb-24">
    <!-- Header Section -->
    <div class="flex justify-between items-end">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('admin.activity.index') }}" class="text-[10px] uppercase tracking-widest text-primary-lime font-bold hover:underline">← Global Stream</a>
            </div>
            <h1 class="text-4xl font-headline font-bold text-white mb-2 uppercase tracking-tighter">{{ $tenant->name }} ANALYTICS</h1>
            <p class="text-on-variant font-label">Granular telemetry for {{ $tenant->city }} infrastructure node.</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.activity.export', $tenant) }}" class="bg-primary-surface border border-primary-border text-white px-6 py-3 rounded-xl font-headline font-bold flex items-center gap-2 hover:bg-primary-border transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                EXPORT RAW DATA
            </a>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-on-variant mb-4 font-bold text-center">Event Count</div>
            <div class="text-4xl font-headline font-bold text-white text-center">{{ number_format($stats['total_logs']) }}</div>
            <div class="mt-4 w-full bg-black/40 h-1 rounded-full overflow-hidden">
                <div class="bg-primary-lime h-full w-[100%]"></div>
            </div>
        </div>

        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-red-400 mb-4 font-bold text-center">Anomalies</div>
            <div class="text-4xl font-headline font-bold text-red-500 text-center">{{ number_format($stats['error_logs']) }}</div>
            <div class="mt-4 flex justify-center gap-1">
                @for($i=0; $i<8; $i++)
                    <div class="h-4 w-1 {{ $stats['error_logs'] > 0 ? 'bg-red-500' : 'bg-primary-lime/20' }} rounded-full"></div>
                @endfor
            </div>
        </div>

        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-on-variant mb-4 font-bold text-center">Sync Operations</div>
            <div class="text-4xl font-headline font-bold text-primary-lime text-center">{{ number_format($stats['sync_logs']) }}</div>
            <div class="mt-4 text-[10px] text-center text-on-variant font-bold">HEALTHY THROTTLING</div>
        </div>

        <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl">
            <div class="text-[10px] uppercase tracking-widest text-on-variant mb-4 font-bold text-center">Session Starts</div>
            <div class="text-4xl font-headline font-bold text-white text-center">{{ number_format($stats['login_logs']) }}</div>
             <div class="mt-4 text-[10px] text-center text-on-variant font-bold uppercase tracking-widest">User Auth Actions</div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl shadow-2xl">
        <form action="{{ route('admin.activity.show', $tenant) }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-8">
            <div class="space-y-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Operation Type</label>
                <select name="action" class="w-full bg-black/40 border-primary-border text-white rounded-xl px-4 py-3 focus:border-primary-lime transition-all outline-none text-sm font-label">
                    <option value="" class="bg-primary-surface">Full Protocol</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }} class="bg-primary-surface">{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Severity</label>
                <select name="severity" class="w-full bg-black/40 border-primary-border text-white rounded-xl px-4 py-3 focus:border-primary-lime transition-all outline-none text-sm font-label">
                    <option value="" class="bg-primary-surface">All Levels</option>
                    @foreach($severities as $s)
                    <option value="{{ $s }}" {{ request('severity') === $s ? 'selected' : '' }} class="bg-primary-surface">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Start Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-black/40 border-primary-border text-white rounded-xl px-4 py-3 focus:border-primary-lime transition-all outline-none text-sm font-label">
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">End Date</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-black/40 border-primary-border text-white rounded-xl px-4 py-3 focus:border-primary-lime transition-all outline-none text-sm font-label">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 kinetic-gradient text-black font-headline font-bold py-3 px-6 rounded-xl hover:opacity-90 transition-all uppercase text-sm tracking-wider">
                    RUN QUERY
                </button>
                <a href="{{ route('admin.activity.show', $tenant) }}" class="p-3 bg-white/5 border border-primary-border rounded-xl text-white hover:bg-white/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Log Grid -->
    <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-primary-border bg-black/20">
                        <th class="px-8 py-6 text-[10px] font-bold text-on-variant uppercase tracking-widest">Time (UTC)</th>
                        <th class="px-8 py-6 text-[10px] font-bold text-on-variant uppercase tracking-widest">Method</th>
                        <th class="px-8 py-6 text-[10px] font-bold text-on-variant uppercase tracking-widest">Agent</th>
                        <th class="px-8 py-6 text-[10px] font-bold text-on-variant uppercase tracking-widest">Severity</th>
                        <th class="px-8 py-6 text-[10px] font-bold text-on-variant uppercase tracking-widest">Payload Message</th>
                        <th class="px-8 py-6 text-[10px] font-bold text-on-variant uppercase tracking-widest">Origin</th>
                        <th class="px-8 py-6"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 font-label">
                    @forelse($logs as $log)
                    <tr class="hover:bg-white/5 transition-all group {{ $log->severity === 'critical' ? 'bg-red-500/5' : '' }}">
                        <td class="px-8 py-6 whitespace-nowrap text-xs text-on-variant">{{ $log->created_at->format('M d, H:i:s') }}</td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <code class="text-[10px] font-mono font-bold bg-white/5 px-3 py-1.5 rounded-lg border border-white/5 uppercase text-primary-lime">{{ $log->action }}</code>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-sm text-white font-bold">{{ $log->user?->name ?? 'CORE SYSTEM' }}</td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @php
                                $severityClass = match($log->severity) {
                                    'critical', 'error' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                    'warning' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                    default => 'bg-primary-lime/10 text-primary-lime border-primary-lime/20'
                                };
                            @endphp
                            <span class="px-3 py-1.5 text-[9px] font-bold rounded-full border {{ $severityClass }} uppercase uppercase tracking-[0.1em]">
                                {{ $log->severity }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-sm text-on-variant max-w-sm">
                            <div class="truncate opacity-80 group-hover:opacity-100 transition-opacity">{{ $log->getFormattedMessage() }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-[10px] font-mono text-on-variant/40 group-hover:text-on-variant transition-colors">{{ $log->ip_address ?? '::1' }}</td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <a href="{{ route('admin.activity.log', $log) }}" class="opacity-0 group-hover:opacity-100 transition-opacity bg-white text-black px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                Trace
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <span class="material-symbols-outlined text-5xl text-on-variant/20 italic">No node activity</span>
                                <p class="text-on-variant opacity-60 font-headline uppercase tracking-widest text-xs">Awaiting node telemetry...</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-8 py-8 border-t border-primary-border bg-black/20">
            <div class="dark-pagination">
                {{ $logs->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .dark-pagination nav div span, 
    .dark-pagination nav div a {
        background: #1A1D24 !important;
        border-color: #2A2E37 !important;
        color: #C5C9AE !important;
        border-radius: 8px !important;
        margin: 0 4px;
        padding: 8px 16px !important;
    }
    .dark-pagination nav div a:hover {
        background: #C8F135 !important;
        color: #000 !important;
    }
    .dark-pagination nav div span[aria-current="page"] {
        background: #C8F135 !important;
        color: #000 !important;
    }
</style>
@endsection
