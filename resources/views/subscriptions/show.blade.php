@extends('layouts.admin')

@section('title', 'Subscription Details - ' . $tenant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $tenant->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $tenant->city }} • {{ $tenant->owner_name }}</p>
            </div>
            <a href="{{ route('admin.tenants.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                ← Back to Gyms
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Subscription Status -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Subscription Details</h2>

                @if($subscription)
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Current Plan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $subscription->plan->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($subscription->status === 'active') bg-green-100 text-green-800
                            @elseif($subscription->status === 'trial') bg-blue-100 text-blue-800
                            @elseif($subscription->status === 'past_due') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($subscription->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Monthly Price</p>
                        <p class="text-lg font-semibold text-gray-900">₨ {{ number_format($subscription->price, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Billing Period</p>
                        <p class="text-sm text-gray-900">
                            {{ $subscription->starts_at->format('M d, Y') }} - {{ $subscription->ends_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                @if($subscription->onTrial())
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Trial Period</p>
                            <p class="text-sm text-blue-700">Expires on {{ $subscription->trial_ends_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Subscription Actions -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Change Plan -->
                        <form action="{{ route('admin.subscriptions.change-plan', $tenant) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Change Plan</label>
                            <select name="plan_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} - ₨ {{ number_format($plan->price, 0) }}/month
                                </option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Change Plan
                            </button>
                        </form>

                        <!-- Extend Trial -->
                        @if($subscription->onTrial())
                        <form action="{{ route('admin.subscriptions.extend-trial', $tenant) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Extend Trial</label>
                            <select name="days" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="7">+7 days</option>
                                <option value="14">+14 days</option>
                                <option value="30">+30 days</option>
                            </select>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Extend Trial
                            </button>
                        </form>
                        @endif

                        <!-- Auto Renew Toggle -->
                        <form action="{{ route('admin.subscriptions.toggle-auto-renew', $tenant) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Auto Renew</label>
                            <div class="flex items-center">
                                <input type="checkbox" {{ $subscription->auto_renew ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-900">Enable auto-renewal</span>
                            </div>
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                {{ $subscription->auto_renew ? 'Disable' : 'Enable' }} Auto Renew
                            </button>
                        </form>

                        <!-- Cancel/Restore -->
                        @if($subscription->status !== 'cancelled')
                        <form action="{{ route('admin.subscriptions.cancel', $tenant) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Cancel Subscription</label>
                            <p class="text-xs text-gray-500">Gym will lose access at end of billing period</p>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                                    onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                Cancel Subscription
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.subscriptions.reactivate', $tenant) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Reactivate Subscription</label>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Reactivate
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">No active subscription found</p>
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Create Subscription
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment History -->
        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Payment History</h2>
                    <a href="{{ route('admin.billing.payments', $tenant) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all →
                    </a>
                </div>

                @if($payments->count() > 0)
                <div class="space-y-4">
                    @foreach($payments as $payment)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                ₨ {{ number_format($payment->amount, 0) }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $payment->payment_date->format('M d, Y') }} • {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($payment->status === 'completed') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm">No payments recorded yet</p>
                @endif

                <div class="mt-6 pt-4 border-t">
                    <a href="{{ route('admin.billing.create-payment', $tenant) }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center block">
                        Record Payment
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.billing.invoice', $tenant) }}"
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center block">
                        Generate Invoice
                    </a>
                    <a href="tel:{{ $tenant->owner_phone }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center block">
                        Call Owner
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
@endsection