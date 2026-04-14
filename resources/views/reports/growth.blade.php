@extends('layouts.admin')

@section('title', 'Growth Reports')

@section('content')
<div class="space-y-12 pb-24">
    <!-- Header Section -->
    <div>
        <h1 class="text-4xl font-headline font-bold text-white mb-2 uppercase italic tracking-tighter">GROWTH ANALYTICS</h1>
        <p class="text-on-variant font-label">Tracking platform expansion and user acquisition velocity.</p>
    </div>

    <!-- Charts / Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- New Gyms Per Week -->
        <div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden shadow-2xl">
            <div class="p-8 border-b border-primary-border flex justify-between items-center">
                <h3 class="font-headline font-bold text-white uppercase tracking-wider text-sm">Onboarding Velocity</h3>
                <span class="text-[10px] text-on-variant">NEW GYMS / WEEK</span>
            </div>
            <div class="p-12">
                <div class="h-64 flex items-end gap-3">
                    @foreach($weeks as $week)
                    <div class="flex-1 bg-primary-lime/20 hover:bg-primary-lime transition-all relative group cursor-pointer" style="height: {{ max($week['count'] * 20, 5) }}%">
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white text-black px-3 py-1 rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            {{ $week['count'] }} New
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-6 text-[10px] text-on-variant uppercase tracking-widest font-bold">
                    @foreach($weeks as $index => $week)
                        @if($index % 2 == 0)
                            <span>{{ $week['week'] }}</span>
                        @else
                            <span></span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Growth Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl flex flex-col justify-between">
                <div class="text-[10px] uppercase tracking-widest text-on-variant font-bold mb-4">Total Network Size</div>
                <div class="text-5xl font-headline font-bold text-white tracking-tighter">
                    {{ \App\Models\Tenant::count() }}
                </div>
                <div class="mt-4 text-xs text-primary-lime font-bold">↑ 12% vs last month</div>
            </div>

            <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl flex flex-col justify-between">
                <div class="text-[10px] uppercase tracking-widest text-on-variant font-bold mb-4">Trial Conversion</div>
                <div class="text-5xl font-headline font-bold text-primary-lime tracking-tighter">
                    84%
                </div>
                <div class="mt-4 text-xs text-on-variant font-bold">Target: 75% for Q2</div>
            </div>

            <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl flex flex-col justify-between md:col-span-2">
                <div class="text-[10px] uppercase tracking-widest text-on-variant font-bold mb-4">Geographic Density</div>
                <div class="flex items-center gap-12 mt-2">
                    <div class="flex-1">
                        <div class="flex justify-between text-xs mb-2">
                            <span>Bagmati (Kathmandu/Bharatpur)</span>
                            <span class="text-white">65%</span>
                        </div>
                        <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden">
                            <div class="bg-primary-lime h-full w-[65%]"></div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between text-xs mb-2">
                            <span>Gandaki (Pokhara)</span>
                            <span class="text-white">20%</span>
                        </div>
                        <div class="h-1.5 w-full bg-black/40 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full w-[20%]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
