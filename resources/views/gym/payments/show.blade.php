@extends('layouts.gym')

@section('title', 'Payment Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.payments.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Payments
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 mb-8">
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-headline font-bold text-white">Payment #{{ $payment->id }}</h2>
                    <p class="text-on-variant mt-1">Recorded {{ $payment->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-4 py-2 text-xs uppercase font-bold tracking-widest rounded-full 
                    {{ $payment->status === 'active' ? 'bg-primary-lime/10 border border-primary-lime text-primary-lime' : '' }}
                    {{ $payment->status === 'expired' ? 'bg-red-500/10 border border-red-500 text-red-500' : '' }}
                    {{ $payment->status === 'frozen' ? 'bg-blue-500/10 border border-blue-500 text-blue-500' : '' }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div class="bg-black/20 rounded-xl p-6 border border-primary-border/30">
                    <span class="text-sm text-on-variant">Member</span>
                    <p class="text-xl font-bold text-white mt-1">{{ $payment->user->name }}</p>
                    <p class="text-sm text-on-variant mt-1">{{ $payment->user->email }}</p>
                </div>
                <div class="bg-black/20 rounded-xl p-6 border border-primary-border/30">
                    <span class="text-sm text-on-variant">Package</span>
                    <p class="text-xl font-bold text-white mt-1">{{ $payment->gymPackage->name }}</p>
                    <p class="text-sm text-on-variant mt-1">{{ $payment->gymPackage->duration_text }}</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 pt-6 border-t border-primary-border">
                <div>
                    <span class="text-sm text-on-variant">Amount Paid</span>
                    <p class="text-2xl font-headline font-bold text-primary-lime mt-1">Rs. {{ number_format($payment->amount_paid, 0) }}</p>
                </div>
                <div>
                    <span class="text-sm text-on-variant">Start Date</span>
                    <p class="text-white font-bold mt-1">{{ $payment->start_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="text-sm text-on-variant">End Date</span>
                    <p class="text-white font-bold mt-1">{{ $payment->end_date->format('M d, Y') }}</p>
                </div>
            </div>

            @if($payment->payment_method)
            <div class="mt-6 pt-6 border-t border-primary-border">
                <span class="text-sm text-on-variant">Payment Method</span>
                <p class="text-white capitalize mt-1">{{ str_replace('_', ' ', $payment->payment_method) }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <h3 class="text-lg font-headline font-bold text-white mb-6">Actions</h3>
            
            <div class="space-y-4">
                <a href="{{ route('gym.payments.receipt', $payment->id) }}" target="_blank" class="block w-full bg-white/5 border border-primary-border text-white font-headline font-bold py-4 rounded-xl text-center hover:bg-white/10 transition-all">
                    Print Receipt (A4)
                </a>
                <a href="{{ route('gym.payments.edit', $payment->id) }}" class="block w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl text-center hover:scale-[1.02] transition-all">
                    Edit Payment
                </a>
                
                <form action="{{ route('gym.payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500/10 border border-red-500 text-red-500 font-headline font-bold py-4 rounded-xl hover:bg-red-500/20 transition-all">
                        Delete Record
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 mt-6">
            <h3 class="text-lg font-headline font-bold text-white mb-4">Member Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-on-variant">Total Packages</span>
                    <span class="text-white">{{ $payment->user->memberPackages->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-on-variant">Active</span>
                    <span class="text-primary-lime">{{ $payment->user->memberPackages->where('status', 'active')->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-on-variant">Total Spent</span>
                    <span class="text-white">Rs. {{ number_format($payment->user->memberPackages->sum('amount_paid'), 0) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
