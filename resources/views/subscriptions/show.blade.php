@extends('layouts.admin')

@section('title', 'Subscription Details - ' . $tenant->name)

@section('content')
<div class="min-h-screen bg-dark-surface text-on-surface font-body">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-headline font-bold text-on-surface">{{ $tenant->name }}</h1>
                    <p class="text-on-surface-variant mt-3 font-medium">{{ $tenant->city }} • {{ $tenant->owner_name }}</p>
                </div>
                <a href="{{ route('admin.tenants.index') }}" class="bg-surface-low hover:bg-surface text-on-surface px-6 py-3 rounded-xl font-medium transition-all">
                    ← Back to Gyms
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Subscription Status -->
            <div class="lg:col-span-2">
                <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                    <h2 class="text-2xl font-headline font-bold text-on-surface mb-8">Subscription Details</h2>

                    @if($subscription)
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div class="bg-surface p-6 rounded-xl border border-outline">
                            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Current Plan</p>
                            <p class="text-xl font-headline font-bold text-on-surface">{{ $subscription->plan->name }}</p>
                        </div>
                        <div class="bg-surface p-6 rounded-xl border border-outline">
                            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Status</p>
                            <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                @if($subscription->status === 'active') bg-green-500/20 text-green-400 border border-green-500/30
                                @elseif($subscription->status === 'trial') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                @elseif($subscription->status === 'past_due') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                @else bg-red-500/20 text-red-400 border border-red-500/30 @endif">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </div>
                        <div class="bg-surface p-6 rounded-xl border border-outline">
                            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Monthly Price</p>
                            <p class="text-2xl font-headline font-bold text-primary-lime">₨ {{ number_format($subscription->price, 0) }}</p>
                        </div>
                        <div class="bg-surface p-6 rounded-xl border border-outline">
                            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Billing Period</p>
                            <p class="text-sm text-on-surface font-medium">
                                {{ $subscription->starts_at->format('M d, Y') }} - {{ $subscription->ends_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    @if($subscription->isOnTrial())
                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-6 mb-8">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-500/20 rounded-lg mr-4">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-blue-400 uppercase tracking-wide">Trial Period Active</p>
                                <p class="text-sm text-blue-300">Expires on {{ $subscription->trial_ends_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Subscription Actions -->
                    <div class="border-t border-outline pt-8">
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-6">Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Change Plan -->
                            <div class="bg-surface p-6 rounded-xl border border-outline">
                                <form action="{{ route('admin.subscriptions.change-plan', $tenant) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide">Change Plan</label>
                                    <select name="plan_id" class="w-full bg-surface-low border border-outline rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary-lime focus:border-primary-lime transition-all">
                                        @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - ₨ {{ number_format($plan->price, 0) }}/month
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="w-full bg-primary-lime hover:bg-primary-lime/90 text-dark-surface px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide transition-all">
                                        Change Plan
                                    </button>
                                </form>
                            </div>

                            <!-- Extend Trial -->
                            @if($subscription->isOnTrial())
                            <div class="bg-surface p-6 rounded-xl border border-outline">
                                <form action="{{ route('admin.subscriptions.extend-trial', $tenant) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide">Extend Trial</label>
                                    <select name="days" class="w-full bg-surface-low border border-outline rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary-lime focus:border-primary-lime transition-all">
                                        <option value="7">+7 days</option>
                                        <option value="14">+14 days</option>
                                        <option value="30">+30 days</option>
                                    </select>
                                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide transition-all">
                                        Extend Trial
                                    </button>
                                </form>
                            </div>
                            @endif

                            <!-- Auto Renew Toggle -->
                            <div class="bg-surface p-6 rounded-xl border border-outline">
                                <form action="{{ route('admin.subscriptions.toggle-auto-renew', $tenant) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide">Auto Renew</label>
                                    <p class="text-xs text-on-surface-variant">
                                        Currently: <strong class="text-primary-lime">{{ $subscription->auto_renew ? 'Enabled' : 'Disabled' }}</strong>
                                    </p>
                                    <button type="submit" class="w-full {{ $subscription->auto_renew ? 'bg-red-500 hover:bg-red-600' : 'bg-primary-lime hover:bg-primary-lime/90' }} text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide transition-all">
                                        {{ $subscription->auto_renew ? 'Disable' : 'Enable' }} Auto Renew
                                    </button>
                                </form>
                            </div>

                            <!-- Cancel/Restore -->
                            @if($subscription->status !== 'cancelled')
                            <div class="bg-surface p-6 rounded-xl border border-outline">
                                <form action="{{ route('admin.subscriptions.cancel', $tenant) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide">Cancel Subscription</label>
                                    <p class="text-xs text-on-surface-variant">Gym will lose access at end of billing period</p>
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide transition-all"
                                            onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                        Cancel Subscription
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="bg-surface p-6 rounded-xl border border-outline">
                                <form action="{{ route('admin.subscriptions.reactivate', $tenant) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wide">Reactivate Subscription</label>
                                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide transition-all">
                                        Reactivate
                                    </button>
                                </form>
                            </div>
                            @endif
                    </div>
                </div>
                    @else
                    <div class="text-center py-12">
                        <div class="mb-6">
                            <svg class="w-16 h-16 text-on-surface-variant mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-on-surface-variant text-lg font-medium mb-2">No active subscription found</p>
                            <p class="text-on-surface-variant/70 text-sm">Get this gym started with their first payment</p>
                        </div>
                        <a href="{{ route('admin.billing.create-payment', $tenant) }}" class="bg-primary-lime hover:bg-primary-lime/90 text-dark-surface px-8 py-4 rounded-xl font-bold text-sm uppercase tracking-wide transition-all inline-block">
                            Record First Payment
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment History -->
            <div>
                <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-headline font-bold text-on-surface">Payment History</h2>
                        <a href="{{ route('admin.billing.payments', $tenant) }}" class="text-primary-lime hover:text-primary-lime/80 text-sm font-bold uppercase tracking-wide transition-all">
                            View all →
                        </a>
                    </div>

                    @if($payments->count() > 0)
                    <div class="space-y-4">
                        @foreach($payments as $payment)
                        <div class="flex justify-between items-center p-4 bg-surface rounded-lg border border-outline">
                            <div>
                                <p class="text-lg font-bold text-on-surface">
                                    ₨ {{ number_format($payment->amount, 0) }}
                                </p>
                                <p class="text-xs text-on-surface-variant mt-1">
                                    {{ $payment->payment_date->format('M d, Y') }} • {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                @if($payment->status === 'completed') bg-green-500/20 text-green-400 border border-green-500/30
                                @else bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-on-surface-variant mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-on-surface-variant text-sm">No payments recorded yet</p>
                    </div>
                    @endif

                    <div class="mt-8 pt-6 border-t border-outline">
                        <a href="{{ route('admin.billing.create-payment', $tenant) }}"
                           class="w-full bg-primary-lime hover:bg-primary-lime/90 text-dark-surface px-6 py-4 rounded-xl font-bold text-sm uppercase tracking-wide text-center block transition-all">
                            Record Payment
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline mt-8">
                    <h2 class="text-2xl font-headline font-bold text-on-surface mb-6">Quick Actions</h2>
                    <div class="space-y-4">
                        <a href="{{ route('admin.billing.invoice', $tenant) }}"
                           class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-4 rounded-xl font-bold text-sm uppercase tracking-wide text-center block transition-all">
                            Generate Invoice
                        </a>
                        <a href="tel:{{ $tenant->owner_phone }}"
                           class="w-full bg-primary-lime hover:bg-primary-lime/90 text-dark-surface px-6 py-4 rounded-xl font-bold text-sm uppercase tracking-wide text-center block transition-all">
                            Call Owner
                        </a>
                    </div>
                </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="toast" class="fixed bottom-6 right-6 bg-green-500/20 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-4 backdrop-blur-sm">
    <div class="p-2 bg-green-500/20 rounded-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>
    <span class="font-medium">{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="font-bold hover:bg-green-500/10 p-1 rounded-lg transition-all">×</button>
</div>
<script>setTimeout(()=>document.getElementById('toast')?.remove(),5000)</script>
@endif

@if(session('error'))
<div id="toast-err" class="fixed bottom-6 right-6 bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-4 backdrop-blur-sm">
    <div class="p-2 bg-red-500/20 rounded-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <span class="font-medium">{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" class="font-bold hover:bg-red-500/10 p-1 rounded-lg transition-all">×</button>
</div>
<script>setTimeout(()=>document.getElementById('toast-err')?.remove(),5000)</script>
@endif
@endsection