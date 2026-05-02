@extends('layouts.gym')

@section('title', 'Payments')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-headline font-bold text-white">Payments</h1>
        <p class="text-on-variant mt-1">Track member payments</p>
    </div>
    <a href="{{ route('gym.payments.create') }}" class="kinetic-gradient text-black font-headline font-bold px-6 py-3 rounded-xl hover:scale-105 transition-all">
        + Record Payment
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <div class="bg-primary-surface p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-1 h-full bg-primary-lime"></div>
        <p class="text-on-variant text-xs font-medium uppercase tracking-widest mb-2">Total Collected (Monthly)</p>
        <div class="flex items-baseline gap-1">
            <span class="text-3xl font-bold font-headline tracking-tighter text-primary-lime">Rs. {{ number_format($totalCollected, 0) }}</span>
        </div>
        <div class="mt-4 flex items-center gap-2 text-green-400 text-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            <span>12% from last month</span>
        </div>
    </div>

    <div class="bg-primary-surface p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
        <p class="text-on-variant text-xs font-medium uppercase tracking-widest mb-2">Pending Dues</p>
        <div class="flex items-baseline gap-1">
            <span class="text-3xl font-bold font-headline tracking-tighter text-red-400">{{ $pendingDues }}</span>
            <span class="text-sm text-on-variant">Overdue payments</span>
        </div>
    </div>

    <div class="bg-primary-surface p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-1 h-full bg-green-400"></div>
        <p class="text-on-variant text-xs font-medium uppercase tracking-widest mb-2">Today's Cash Collection</p>
        <div class="flex items-baseline gap-1">
            <span class="text-3xl font-bold font-headline tracking-tighter">Rs. {{ number_format($todayCash, 0) }}</span>
        </div>
        <p class="mt-4 text-on-variant text-xs">{{ $todayTransactions }} transactions today</p>
    </div>

    <div class="bg-primary-surface p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-1 h-full bg-primary-lime"></div>
        <p class="text-on-variant text-xs font-medium uppercase tracking-widest mb-2">Unpaid Members</p>
        <div class="flex items-baseline gap-1">
            <span class="text-3xl font-bold font-headline tracking-tighter">{{ $unpaidMembers }}</span>
            <span class="text-sm text-on-variant">/ {{ $totalMembers }} total</span>
        </div>
        <div class="mt-4 h-1 w-full bg-primary-border rounded-full overflow-hidden">
            <div class="h-full bg-primary-lime" style="width: {{ $totalMembers > 0 ? ($unpaidMembers / $totalMembers) * 100 : 0 }}%"></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <div class="lg:col-span-8 space-y-6">
        <div class="flex justify-between items-center px-2">
            <h2 class="text-2xl font-bold font-headline">Recent Transactions</h2>
            <div class="flex gap-2">
                <button class="bg-primary-border text-on-surface text-xs px-4 py-2 rounded-full font-medium hover:bg-white/10 transition-all">
                    Export PDF
                </button>
                <button class="bg-primary-border text-on-surface text-xs px-4 py-2 rounded-full font-medium hover:bg-white/10 transition-all">
                    Filter
                </button>
            </div>
        </div>
        <div class="bg-primary-surface rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black/20 text-on-variant">
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-widest">Date</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-widest">Member</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-widest">Package</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-widest">Amount</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-widest">Method</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-border/10">
                    @forelse($recentTransactions as $payment)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium">{{ $payment->start_date->format('M d, Y') }}</span>
                                <span class="text-[10px] text-on-variant">{{ $payment->start_date->format('h:i A') }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-lime/20 flex items-center justify-center text-primary-lime text-xs font-bold">
                                    {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold">{{ $payment->user->name }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="text-xs bg-primary-border px-3 py-1 rounded-full">{{ $payment->gymPackage->name ?? 'N/A' }}</span>
                        </td>
                        <td class="py-5 px-6">
                            <span class="text-sm font-bold">Rs. {{ number_format($payment->amount_paid, 0) }}</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                <span class="text-xs font-medium">Manual</span>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <a href="{{ route('gym.payments.show', $payment->id) }}" class="primary-lime hover:underline text-xs flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Receipt
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-on-variant">No recent transactions.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="lg:col-span-4 space-y-8">
        <div class="bg-primary-surface p-6 rounded-3xl">
            <h3 class="text-lg font-bold font-headline mb-6">Daily Revenue Mix</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-on-variant">eSewa</span>
                        <span class="font-bold">65%</span>
                    </div>
                    <div class="h-2 w-full bg-primary-border rounded-full overflow-hidden">
                        <div class="h-full bg-green-400 w-[65%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-on-variant">Cash</span>
                        <span class="font-bold">25%</span>
                    </div>
                    <div class="h-2 w-full bg-primary-border rounded-full overflow-hidden">
                        <div class="h-full bg-primary-lime w-[25%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-on-variant">Khalti</span>
                        <span class="font-bold">10%</span>
                    </div>
                    <div class="h-2 w-full bg-primary-border rounded-full overflow-hidden">
                        <div class="h-full bg-blue-400 w-[10%]"></div>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-primary-border/10 flex justify-between items-center">
                <span class="text-xs font-medium text-on-variant">Total Volume</span>
                <span class="text-lg font-bold">Rs. {{ number_format($todayCash, 0) }}</span>
            </div>
        </div>

        <div class="bg-primary-surface p-6 rounded-3xl relative overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold font-headline">Pending Dues</h3>
                <span class="text-[10px] bg-red-900/30 text-red-400 px-2 py-0.5 rounded-full font-bold uppercase">Critical</span>
            </div>
            <div class="space-y-6">
                @php
                    $pendingPayments = \App\Models\MemberPackage::where('tenant_id', auth()->user()->tenant->id)
                        ->where('status', 'active')
                        ->where('end_date', '<', now()->toDateString())
                        ->with('user')
                        ->limit(5)
                        ->get();
                @endphp
                @forelse($pendingPayments as $pending)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-border flex items-center justify-center text-xs font-bold border border-primary-border/20">
                            {{ strtoupper(substr($pending->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold">{{ $pending->user->name }}</p>
                            <p class="text-[10px] text-red-400 font-medium">
                                Overdue: {{ now()->diffInDays($pending->end_date) }} Days
                            </p>
                        </div>
                    </div>
                    <button class="w-10 h-10 rounded-full bg-green-500/20 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Send WhatsApp Reminder">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </button>
                </div>
                @empty
                <p class="text-on-variant text-sm">No pending dues.</p>
                @endforelse
            </div>
            @if($pendingPayments->count() > 0)
            <button class="w-full mt-8 py-3 bg-primary-border/40 rounded-xl text-xs font-bold hover:bg-white/10 transition-all">
                View All Pending ({{ $pendingPayments->count() }})
            </button>
            @endif
        </div>
    </div>
</div>
@endsection