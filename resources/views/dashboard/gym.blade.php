@extends('layouts.gym')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Active Members -->
    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary-lime/10 flex items-center justify-center text-primary-lime">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="text-primary-lime text-xs font-bold">+12%</div>
            </div>
            <div class="text-on-variant text-[10px] uppercase tracking-widest font-label mb-1">Active Members</div>
            <div class="text-4xl font-headline font-bold text-white">187</div>
        </div>
    </div>

    <!-- Today's Collection -->
    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-on-variant text-xs font-medium">3 payments</div>
            </div>
            <div class="text-on-variant text-[10px] uppercase tracking-widest font-label mb-1">Today's Collection</div>
            <div class="text-4xl font-headline font-bold text-white italic">Rs 4,500</div>
        </div>
    </div>

    <!-- Pending Dues -->
    <div class="bg-primary-surface border-l-4 border-l-red-500/50 border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="text-red-500 text-xs font-bold">18 Unpaid</div>
            </div>
            <div class="text-on-variant text-[10px] uppercase tracking-widest font-label mb-1">Pending Dues</div>
            <div class="text-4xl font-headline font-bold text-white">Rs 23,000</div>
        </div>
    </div>

    <!-- Expiring Soon -->
    <div class="bg-primary-surface border border-primary-border p-8 rounded-3xl relative overflow-hidden group">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-on-variant text-xs font-medium">Next 3 days</div>
            </div>
            <div class="text-on-variant text-[10px] uppercase tracking-widest font-label mb-1">Expiring Soon</div>
            <div class="text-4xl font-headline font-bold text-white">5</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <div class="lg:col-span-2 space-y-8">
        <!-- Revenue Snapshot -->
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-xl font-headline font-bold text-white">Revenue Snapshot</h3>
                    <p class="text-xs text-on-variant">Monthly collection performance vs targets</p>
                </div>
                <div class="flex items-center gap-6 text-[10px] uppercase tracking-widest font-bold">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-primary-lime rounded-full"></span>
                        <span class="text-on-variant">Collected</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-white/10 rounded-full"></span>
                        <span class="text-on-variant opacity-60">Pending</span>
                    </div>
                </div>
            </div>
            
            <div class="h-64 flex items-end justify-between gap-6">
                @php $months = ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr']; @endphp
                @foreach($months as $month)
                <div class="flex-1 flex flex-col items-center gap-4">
                    <div class="w-full relative h-48 bg-white/5 rounded-lg overflow-hidden flex flex-col justify-end">
                        <div class="bg-white/10 w-full h-full absolute top-0"></div>
                        <div class="bg-primary-lime/60 w-full rounded-t-lg transition-all hover:bg-primary-lime" style="height: {{ rand(40, 90) }}%"></div>
                    </div>
                    <span class="text-[10px] uppercase font-bold text-on-variant">{{ $month }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Today's Pulse -->
            <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 relative overflow-hidden">
                <div class="flex flex-col h-full justify-between gap-8">
                    <h3 class="text-xl font-headline font-bold text-white">Today's Pulse</h3>
                    <div class="flex items-center gap-6">
                        <div class="relative w-24 h-24 flex items-center justify-center">
                            <svg class="w-full h-full -rotate-90">
                                <circle cx="48" cy="48" r="42" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/5"/>
                                <circle cx="48" cy="48" r="42" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="264" stroke-dashoffset="66" class="text-primary-lime"/>
                            </svg>
                            <span class="absolute text-2xl font-headline font-bold text-white">43</span>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-white">Check-ins</div>
                            <div class="text-xs text-primary-lime">+15% from yesterday</div>
                        </div>
                    </div>
                </div>
                <div class="absolute left-0 top-0 h-full w-1.5 bg-primary-lime rounded-full scale-y-50 origin-top"></div>
            </div>

            <!-- Peak Hours -->
            <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
                <h3 class="text-xl font-headline font-bold text-white mb-6">Peak Hours</h3>
                <div class="space-y-4">
                    <div class="bg-white/5 border border-primary-border/50 rounded-2xl p-4 flex justify-between items-center">
                        <span class="text-sm font-label text-on-variant">06:00 - 08:00 AM</span>
                        <svg class="w-4 h-4 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div class="bg-white/5 border border-primary-border/20 rounded-2xl p-4 flex justify-between items-center opacity-60">
                        <span class="text-sm font-label text-on-variant">05:00 - 07:00 PM</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <!-- Quick Actions -->
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <h3 class="text-xl font-headline font-bold text-white mb-8">Quick Actions</h3>
            <div class="space-y-4">
                <button class="w-full kinetic-gradient text-black font-headline font-bold py-5 rounded-2xl flex items-center justify-center gap-3 hover:opacity-90 transition-all text-sm uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Add Member
                </button>
                <button class="w-full bg-white/5 border border-primary-border rounded-2xl py-4 flex items-center justify-center gap-3 text-white font-headline font-bold transition-all hover:bg-white/10 text-sm uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Mark Attendance
                </button>
                <button class="w-full bg-white/5 border border-primary-border rounded-2xl py-4 flex items-center justify-center gap-3 text-white font-headline font-bold transition-all hover:bg-white/10 text-sm uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Record Payment
                </button>
            </div>
        </div>

        <!-- Renewal Alerts -->
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <div class="flex items-center gap-3 mb-8">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
                <h3 class="text-xl font-headline font-bold text-white">Renewal Alerts</h3>
            </div>
            
            <div class="space-y-4">
                <div class="p-4 bg-white/5 border-l-4 border-l-red-500 rounded-lg flex justify-between items-center group cursor-pointer hover:bg-white/10 transition-all">
                    <div>
                        <div class="text-sm font-bold text-white">Niraj KC</div>
                        <div class="text-[10px] uppercase font-bold text-red-500 tracking-tighter">Expired Today</div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 hover:bg-green-500 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.297.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                    </div>
                </div>
                <!-- Add another one similarly -->
                <div class="p-4 bg-white/5 border-l-4 border-l-yellow-500 rounded-lg flex justify-between items-center group cursor-pointer hover:bg-white/10 transition-all opacity-80">
                    <div>
                        <div class="text-sm font-bold text-white">Amit Mahato</div>
                        <div class="text-[10px] uppercase font-bold text-yellow-500 tracking-tighter">Expiring in 2 days</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Members -->
    <div class="lg:col-span-2 bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
        <div class="p-8 border-b border-primary-border flex justify-between items-center">
            <h3 class="text-xl font-headline font-bold text-white uppercase italic">Recent Members</h3>
            <a href="#" class="text-xs font-bold text-primary-lime hover:underline">View All &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] uppercase tracking-widest text-on-variant font-label border-b border-primary-border/30 bg-black/5">
                        <th class="px-8 py-4">Member</th>
                        <th class="px-8 py-4">Plan Status</th>
                        <th class="px-8 py-4 text-right">Payment</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-border/20">
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-xs font-bold">RK</div>
                                <div>
                                    <div class="text-sm font-bold text-white">Rahul Kumar</div>
                                    <div class="text-[10px] text-on-variant">Joined 2 hours ago</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-primary-lime/10 text-primary-lime text-[10px] font-bold rounded-full">Active</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-sm text-primary-lime font-bold">Paid</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors opacity-80">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-xs font-bold">SP</div>
                                <div>
                                    <div class="text-sm font-bold text-white">Sunita Prasad</div>
                                    <div class="text-[10px] text-on-variant">Renewed yesterday</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-primary-lime/10 text-primary-lime text-[10px] font-bold rounded-full">Active</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-sm text-primary-lime font-bold">Paid</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notice Board -->
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 flex flex-col">
        <h3 class="text-xl font-headline font-bold text-white italic mb-10">Notice Board</h3>
        <div class="flex-1 space-y-8 pr-2 custom-scrollbar">
            <div class="relative pl-6 border-l-2 border-primary-lime">
                <div class="text-[10px] uppercase font-bold text-on-variant mb-1">APR 10, 2024</div>
                <div class="text-sm font-bold text-white mb-2">New Year Holiday Closure</div>
                <p class="text-[10px] text-on-variant leading-relaxed">Gym will be closed on April 14th for the festive holiday.</p>
            </div>
            <div class="relative pl-6 border-l-2 border-white/20">
                <div class="text-[10px] uppercase font-bold text-on-variant mb-1">APR 05, 2024</div>
                <div class="text-sm font-bold text-white mb-2">Zumba Workshop</div>
                <p class="text-[10px] text-on-variant leading-relaxed">Special session at 7 PM this Friday.</p>
            </div>
        </div>
        <button class="w-full mt-10 bg-white/5 border border-primary-border py-4 rounded-xl text-[10px] uppercase font-bold tracking-widest hover:bg-white/10 transition-all">Post Announcement</button>
    </div>
</div>
@endsection
