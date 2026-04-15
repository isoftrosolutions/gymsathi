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

<div class="bg-primary-surface border border-primary-border rounded-3xl overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="text-[10px] uppercase tracking-widest text-on-variant font-label border-b border-primary-border/50 bg-black/5">
                <th class="px-8 py-6">Member</th>
                <th class="px-8 py-6">Package</th>
                <th class="px-8 py-6">Amount</th>
                <th class="px-8 py-6">Start Date</th>
                <th class="px-8 py-6">End Date</th>
                <th class="px-8 py-6">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-primary-border/30">
            @forelse($payments as $payment)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-lime/10 flex items-center justify-center text-primary-lime font-bold">
                            {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                        </div>
                        <div class="text-sm font-bold text-white">{{ $payment->user->name }}</div>
                    </div>
                </td>
                <td class="px-8 py-6 text-sm text-white">
                    {{ $payment->gymPackage->name }}
                </td>
                <td class="px-8 py-6 text-sm text-primary-lime font-bold">
                    Rs. {{ number_format($payment->amount_paid, 0) }}
                </td>
                <td class="px-8 py-6 text-sm text-on-variant">
                    {{ $payment->start_date->format('M d, Y') }}
                </td>
                <td class="px-8 py-6 text-sm text-on-variant">
                    {{ $payment->end_date->format('M d, Y') }}
                </td>
                <td class="px-8 py-6">
                    <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest rounded-full 
                        {{ $payment->status === 'active' ? 'bg-primary-lime/10 border border-primary-lime text-primary-lime' : '' }}
                        {{ $payment->status === 'expired' ? 'bg-red-500/10 border border-red-500 text-red-500' : '' }}
                        {{ $payment->status === 'frozen' ? 'bg-blue-500/10 border border-blue-500 text-blue-500' : '' }}">
                        {{ $payment->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-8 py-12 text-center text-on-variant">
                    No payment records found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-6 border-t border-primary-border">
        {{ $payments->links() }}
    </div>
</div>
@endsection
