@extends('layouts.admin')

@section('title', 'Trace #' . $log->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-24">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ $log->tenant ? route('admin.activity.show', $log->tenant) : route('admin.activity.index') }}"
                   class="text-[10px] uppercase tracking-widest text-primary-lime font-bold hover:underline">← Return to Stream</a>
            </div>
            <h1 class="text-3xl font-headline font-bold text-white mb-2 uppercase tracking-tighter italic">Event Diagnostic <span class="text-on-variant/40 hover:text-primary-lime transition-colors">#{{ $log->id }}</span></h1>
            <p class="text-on-variant font-label">Deep packet inspection of platform operation recorded via core telemetry.</p>
        </div>
        <div class="flex flex-col items-end">
            @php
                $severityClass = match($log->severity) {
                    'critical', 'error' => 'bg-red-500/10 text-red-500 border-red-500/20',
                    'warning' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                    default => 'bg-primary-lime/10 text-primary-lime border-primary-lime/20'
                };
            @endphp
            <div class="px-6 py-2 rounded-full border {{ $severityClass }} font-headline font-bold text-sm uppercase tracking-widest shadow-lg">
                {{ $log->severity }}
            </div>
            <div class="mt-2 text-[10px] text-on-variant font-bold uppercase tracking-widest text-right">Severity Level</div>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Core Metadata -->
        <div class="md:col-span-2 space-y-8">
            <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-primary-border bg-black/20">
                    <h3 class="font-headline font-bold text-white text-xs uppercase tracking-widest">Event Context</h3>
                </div>
                <div class="p-8 grid grid-cols-2 gap-y-10 gap-x-8 font-label">
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold opacity-60">Operation Method</div>
                        <div class="text-primary-lime font-mono font-bold">{{ $log->action }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold opacity-60">Originating Node</div>
                        @if($log->tenant)
                        <a href="{{ route('admin.activity.show', $log->tenant) }}" class="text-white hover:text-primary-lime transition-colors font-bold">{{ $log->tenant->name }}</a>
                        @else
                        <div class="text-white font-bold italic">Global System</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold opacity-60">Authorized Agent</div>
                        <div class="text-white font-bold">{{ $log->user?->name ?? 'AUTOMATED CORE' }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold opacity-60">System Timestamp</div>
                        <div class="text-white font-bold">{{ $log->created_at->format('M d, Y · H:i:s') }} (UTC)</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold opacity-60">IP Address</div>
                        <div class="text-on-variant font-mono">{{ $log->ip_address ?? '::1 (Loopback)' }}</div>
                    </div>
                    @if($log->resource_type)
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold opacity-60">Resource Binding</div>
                        <div class="text-white font-bold">{{ $log->resource_type }} <span class="text-on-variant opacity-40">#{{ $log->resource_id }}</span></div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payload / Message -->
            @if($log->message)
            <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-primary-border bg-black/20 text-xs font-bold uppercase tracking-widest">Primary Message</div>
                <div class="p-8 font-label text-on-variant leading-relaxed italic bg-black/10">
                    "{{ $log->message }}"
                </div>
            </div>
            @endif

            <!-- Raw Metadata -->
            @if($log->metadata)
            <div class="bg-black border border-primary-border rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-primary-border bg-black/40 flex justify-between items-center">
                    <h3 class="font-headline font-bold text-white text-xs uppercase tracking-widest">Raw Metadata Payload</h3>
                    <span class="text-[10px] font-mono text-primary-lime">application/json</span>
                </div>
                <div class="p-8">
                    <pre class="bg-black text-[#8BC34A] font-mono text-xs overflow-x-auto custom-scrollbar leading-relaxed">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl space-y-6">
                <div>
                    <div class="text-[10px] uppercase tracking-widest text-on-variant mb-2 font-bold">Node Status</div>
                    <div class="flex items-center gap-2">
                         <div class="w-2 h-2 rounded-full bg-primary-lime animate-pulse"></div>
                         <span class="text-xs font-bold text-white uppercase tracking-widest">Operational</span>
                    </div>
                </div>
                
                @if($log->user_agent)
                <div class="pt-6 border-t border-white/5">
                    <div class="text-[10px] uppercase tracking-widest text-on-variant mb-3 font-bold">Agent Fingerprint</div>
                    <div class="text-[10px] text-on-variant/60 break-all leading-loose bg-black/20 p-4 rounded-xl font-mono">
                        {{ $log->user_agent }}
                    </div>
                </div>
                @endif
                
                <div class="pt-6 border-t border-white/5">
                    <button class="w-full bg-white/5 border border-primary-border text-white px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        Share Trace
                    </button>
                    <p class="mt-4 text-[9px] text-on-variant/40 text-center uppercase tracking-widest italic">Encrypted trace link valid for 30m</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
