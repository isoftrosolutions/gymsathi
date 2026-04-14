@extends('layouts.admin')

@section('title', 'Gym Health Scores')

@section('content')
<div class="space-y-12 pb-24">
    <!-- Header Section -->
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-headline font-bold text-white mb-2 uppercase italic tracking-tighter">GYM HEALTH VECTOR</h1>
            <p class="text-on-variant font-label max-w-xl">Algorithmic scoring based on active members (40%), attendance rate (30%), and payment collection (30%).</p>
        </div>
        <div class="flex gap-4">
            <button class="bg-primary-surface border border-primary-border text-white px-6 py-3 rounded-xl font-headline font-bold flex items-center gap-2 hover:bg-primary-border transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                EXPORT PDF
            </button>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 gap-6">
        @foreach($tenants as $tenant)
        <div class="bg-primary-surface border border-primary-border rounded-[2rem] overflow-hidden group hover:border-primary-lime/50 transition-all duration-500">
            <div class="p-8 flex flex-wrap lg:flex-nowrap items-center gap-12">
                <!-- Gym Identity -->
                <div class="flex items-center gap-6 min-w-[300px]">
                    <div class="w-20 h-20 rounded-3xl bg-black/40 border border-primary-border flex items-center justify-center font-headline text-3xl group-hover:scale-110 transition-transform">
                        {{ substr($tenant->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-headline font-bold text-white">{{ $tenant->name }}</h3>
                        <p class="text-on-variant text-sm font-label uppercase tracking-widest">{{ $tenant->city ?? 'Nepal' }}</p>
                    </div>
                </div>

                <!-- Health Score Circle -->
                <div class="relative w-32 h-32 flex-shrink-0">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path class="text-white/5" stroke-dasharray="100, 100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="{{ $tenant->health_score > 70 ? 'text-primary-lime' : ($tenant->health_score > 40 ? 'text-yellow-400' : 'text-red-500') }}" 
                              stroke-dasharray="{{ $tenant->health_score }}, 100" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-headline font-bold text-white">{{ $tenant->health_score }}</span>
                        <span class="text-[8px] text-on-variant uppercase font-bold tracking-widest">SCORE</span>
                    </div>
                </div>

                <!-- Metrics Breakdown -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Members -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] text-on-variant uppercase font-bold tracking-widest">
                            <span>Active Members</span>
                            <span class="text-white">{{ $tenant->users_count }}</span>
                        </div>
                        <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full" style="width: {{ min(($tenant->users_count / 100) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Attendance -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] text-on-variant uppercase font-bold tracking-widest">
                            <span>Attendance Rate</span>
                            <span class="text-white">{{ $tenant->attendance_rate }}%</span>
                        </div>
                        <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden">
                            <div class="bg-primary-lime h-full" style="width: {{ $tenant->attendance_rate }}%"></div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] text-on-variant uppercase font-bold tracking-widest">
                            <span>Billing collection</span>
                            <span class="text-white">{{ $tenant->payment_rate }}%</span>
                        </div>
                        <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden">
                            <div class="bg-purple-500 h-full" style="width: {{ $tenant->payment_rate }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Action / Diagnosis -->
                <div class="w-full lg:w-48 text-right">
                    <div class="inline-block px-4 py-2 rounded-xl text-xs font-bold font-headline uppercase tracking-tighter {{ $tenant->health_score > 70 ? 'bg-primary-lime/10 text-primary-lime' : ($tenant->health_score > 40 ? 'bg-yellow-400/10 text-yellow-400' : 'bg-red-500/10 text-red-500') }}">
                        {{ $tenant->health_score > 70 ? 'High Growth' : ($tenant->health_score > 40 ? 'Stable' : 'Churn Risk') }}
                    </div>
                    <button class="mt-4 w-full border border-primary-border py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest text-on-variant hover:border-white hover:text-white transition-all">
                        Deep Analysis
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Health Key -->
    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl grid grid-cols-1 md:grid-cols-3 gap-12 border-dashed">
        <div>
            <h4 class="font-headline font-bold text-primary-lime uppercase text-sm mb-2">High Growth (>70)</h4>
            <p class="text-on-variant text-xs font-label">Gym is expanding its member base and maintains >80% session attendance.</p>
        </div>
        <div>
            <h4 class="font-headline font-bold text-yellow-400 uppercase text-sm mb-2">Stable (40-70)</h4>
            <p class="text-on-variant text-xs font-label">Healthy core operations but may have flat month-over-month growth.</p>
        </div>
        <div>
            <h4 class="font-headline font-bold text-red-500 uppercase text-sm mb-2">Churn Risk (<40)</h4>
            <p class="text-on-variant text-xs font-label">Low engagement detected. Recommended automated intervention via WhatsApp.</p>
        </div>
    </div>
</div>
@endsection
