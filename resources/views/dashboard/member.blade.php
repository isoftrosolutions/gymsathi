@extends('layouts.member')

@section('content')
<div class="mb-16">
    <div class="text-[10px] uppercase font-bold tracking-[0.3em] text-primary-lime mb-2">Welcome Back, {{ explode(' ', auth()->user()->name)[0] }}</div>
    <div class="flex flex-col md:flex-row justify-between items-end gap-8">
        <div>
            <h1 class="text-7xl font-headline font-bold text-white uppercase leading-none">
                Leave it all on<br>
                the <span class="text-primary-lime italic">Floor.</span>
            </h1>
            <p class="text-on-variant mt-6 max-w-md">Your consistency is paying off. You've hit 85% of your monthly goals so far. Keep pushing.</p>
        </div>
        <div class="bg-white/5 border border-white/10 p-8 rounded-3xl flex items-center gap-10">
            <div class="text-right">
                <div class="text-[10px] uppercase font-bold text-on-variant tracking-widest mb-1">Workout Streak</div>
                <div class="flex items-center justify-end gap-2">
                    <span class="text-5xl font-headline font-bold text-white">14</span>
                    <svg class="w-8 h-8 text-primary-lime" fill="currentColor" viewBox="0 0 24 24"><path d="M17.5 12a5.5 5.5 0 11-11 0 5.5 5.5 0 0111 0zm-5.5-8C7.5 4 4 7.5 4 12c0 1.2.3 2.3.8 3.3L3 21l5.7-1.8c1 .5 2.1.8 3.3.8 4.5 0 8-3.5 8-8s-3.5-8-8-8z" class="opacity-20"/><path d="M12 2C7.03 2 3 6.03 3 11c0 1.74.5 3.36 1.35 4.73l-1.35 4.1 4.1-1.35C8.64 19.5 10.26 20 12 20c4.97 0 9-4.03 9-9 0-4.97-4.03-9-9-9zm0 16c-1.58 0-3.04-.47-4.27-1.28l-2.43.8.8-2.43C5.47 14.04 5 12.58 5 11c0-3.86 3.14-7 7-7 1.58 0 3.04.47 4.27 1.28l2.43-.8-.8 2.43C18.53 7.96 19 9.42 19 11c0 3.86-3.14 7-7 7z" class="opacity-40"/><path d="M12 18c-3.86 0-7-3.14-7-7 0-.5.06-1 .17-1.47 1.27 1.63 3.2 2.68 5.38 2.72.1-.82.49-1.57 1.12-2.1.37-.31.84-.48 1.33-.48s.96.17 1.33.48c.63.53 1.02 1.28 1.12 2.1 2.18-.04 4.11-1.09 5.38-2.72.11.47.17.97.17 1.47 0 3.86-3.14 7-7 7z" class="text-primary-lime"/></svg>
                </div>
                <div class="text-[10px] text-on-variant mt-2 font-bold tracking-tight">Personal Best: 21 Days</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
    <!-- Membership Card -->
    <div class="bg-primary-surface border-t-8 border-t-primary-lime border border-white/5 rounded-3xl p-10 flex flex-col justify-between min-h-[320px]">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-headline font-bold text-white mb-2 italic">Platinum Monthly</h3>
                <p class="text-[10px] text-on-variant uppercase tracking-widest">Full Access + Guest Passes</p>
            </div>
            <span class="px-3 py-1 bg-primary-lime/10 text-primary-lime text-[10px] font-bold rounded-full border border-primary-lime/30">ACTIVE</span>
        </div>
        
        <div class="flex gap-12 border-t border-white/5 pt-8">
            <div>
                <div class="text-5xl font-headline font-bold text-white">12</div>
                <div class="text-[10px] text-on-variant uppercase mt-1">Days Remaining</div>
            </div>
            <div>
                <div class="text-xl font-headline font-bold text-white mt-1">Oct 28, 2023</div>
                <div class="text-[10px] text-on-variant uppercase mt-2">Renewal Date</div>
            </div>
        </div>

        <button class="w-full kinetic-gradient py-4 rounded-xl text-black font-headline font-bold text-sm uppercase mt-8 hover:opacity-90 transition-all shadow-xl shadow-primary-lime/20">Renew Membership</button>
    </div>

    <!-- Stats Card 1 -->
    <div class="bg-primary-surface border border-white/5 rounded-3xl p-10 flex flex-col justify-between">
        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-primary-lime">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 11m0 0l11-11m-11 11v-5m0 5h5"/></svg>
        </div>
        <div>
            <div class="text-6xl font-headline font-bold text-white">18</div>
            <div class="text-[10px] text-on-variant uppercase mt-1">Sessions this month</div>
        </div>
        <div class="text-xs text-primary-lime font-bold">+3 vs last month</div>
    </div>

    <!-- Stats Card 2 -->
    <div class="bg-primary-surface border border-white/5 rounded-3xl p-10 flex flex-col justify-between">
        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-primary-lime">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="flex items-baseline gap-2">
                <div class="text-6xl font-headline font-bold text-white">72</div>
                <span class="text-on-variant text-xl uppercase font-bold tracking-tight">min</span>
            </div>
            <div class="text-[10px] text-on-variant uppercase mt-1">Avg. session duration</div>
        </div>
        <div class="text-xs text-on-variant font-medium">Consistent intensity</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Your Schedule -->
    <div class="lg:col-span-2 bg-primary-surface border border-white/5 rounded-3xl overflow-hidden p-8">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-2xl font-headline font-bold text-white uppercase italic">Your Schedule</h3>
            <span class="text-[10px] font-bold text-primary-lime uppercase tracking-widest">Next 48 Hours</span>
        </div>
        
        <div class="space-y-4">
            <div class="p-6 bg-white/5 rounded-2xl flex items-center justify-between group cursor-pointer hover:bg-white/10 transition-all border border-transparent hover:border-white/10">
                <div class="flex items-center gap-10">
                    <div class="text-center w-20">
                        <div class="text-[10px] text-on-variant uppercase tracking-tighter mb-1">TODAY</div>
                        <div class="text-2xl font-headline font-bold text-white">18:30</div>
                    </div>
                    <div class="h-10 w-px bg-white/10"></div>
                    <div>
                        <div class="text-lg font-bold text-white">HIIT Power Blast</div>
                        <div class="text-xs text-on-variant">Studio A • Coach Marcus</div>
                    </div>
                </div>
                <svg class="w-5 h-5 text-on-variant group-hover:text-primary-lime transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            
            <div class="p-6 bg-white/5 rounded-2xl flex items-center justify-between group cursor-pointer hover:bg-white/10 transition-all border border-transparent hover:border-white/10">
                <div class="flex items-center gap-10">
                    <div class="text-center w-20">
                        <div class="text-[10px] text-on-variant uppercase tracking-tighter mb-1">TOMORROW</div>
                        <div class="text-2xl font-headline font-bold text-white">07:00</div>
                    </div>
                    <div class="h-10 w-px bg-white/10"></div>
                    <div>
                        <div class="text-lg font-bold text-white">Heavy Leg Day</div>
                        <div class="text-xs text-on-variant">Main Gym • Personal Training</div>
                    </div>
                </div>
                <svg class="w-5 h-5 text-on-variant group-hover:text-primary-lime transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>
    </div>

    <!-- Payments & Notices -->
    <div class="space-y-8">
        <div class="bg-primary-surface border border-white/5 rounded-3xl p-8">
            <h3 class="text-xl font-headline font-bold text-white uppercase italic mb-8">Recent Payments</h3>
            <div class="space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-white/5">
                    <div>
                        <div class="text-sm font-bold text-white italic">$89.00</div>
                        <div class="text-[10px] text-on-variant uppercase">Sep 28 • Visa **** 4242</div>
                    </div>
                    <span class="text-[10px] font-bold text-primary-lime uppercase tracking-widest bg-primary-lime/10 px-2 py-0.5 rounded">Paid</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-white/5">
                    <div>
                        <div class="text-sm font-bold text-white italic">$89.00</div>
                        <div class="text-[10px] text-on-variant uppercase">Aug 28 • Visa **** 4242</div>
                    </div>
                    <span class="text-[10px] font-bold text-primary-lime uppercase tracking-widest bg-primary-lime/10 px-2 py-0.5 rounded">Paid</span>
                </div>
            </div>
        </div>

        <div class="bg-primary-surface border border-white/5 rounded-3xl p-8 h-full">
            <h3 class="text-xl font-headline font-bold text-white italic mb-10 uppercase">Notices</h3>
            <div class="space-y-8">
                <div class="relative pl-6 border-l-2 border-primary-lime">
                    <div class="text-sm font-bold text-white mb-2">Holiday Hours</div>
                    <p class="text-[11px] text-on-variant leading-relaxed">We are open from 08:00 to 14:00 this coming Sunday for the regional festival.</p>
                </div>
                <div class="relative pl-6 border-l-2 border-white/20">
                    <div class="text-sm font-bold text-white mb-2">New Equipment</div>
                    <p class="text-[11px] text-on-variant leading-relaxed">The rogue power racks in Zone 4 have been upgraded.</p>
                </div>
                <a href="#" class="inline-block text-[10px] font-bold text-primary-lime uppercase tracking-widest hover:underline mt-4">View All Notices &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
