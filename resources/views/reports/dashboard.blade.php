@extends('layouts.admin')

@section('title', 'Subscription Dashboard')

@section('content')
<div class="min-h-screen bg-dark-surface text-on-surface font-body">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-12">
            <h1 class="text-4xl font-headline font-bold text-on-surface">Subscription & Billing Dashboard</h1>
            <p class="text-on-surface-variant mt-3 font-medium">Monitor your business revenue and subscription metrics</p>
        </div>

        <!-- MRR Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-green-500/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Monthly Recurring Revenue</p>
                        <p class="text-3xl font-headline font-bold text-green-400">₨ {{ number_format($mrr, 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-500/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Active Subscriptions</p>
                        <p class="text-3xl font-headline font-bold text-blue-400">{{ $planDistribution->sum('tenants_count') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-500/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">On Trial</p>
                        <p class="text-3xl font-headline font-bold text-yellow-400">{{ $trialCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-lime/20 rounded-xl mr-6">
                        <svg class="w-8 h-8 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">This Month</p>
                        <p class="text-3xl font-headline font-bold text-primary-lime">₨ {{ number_format($recentPayments->where('payment_date', '>=', now()->startOfMonth())->sum('amount'), 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Distribution -->
        <div class="bg-surface-low rounded-2xl shadow-xl p-8 mb-12 border border-outline">
            <h2 class="text-2xl font-headline font-bold text-on-surface mb-8">Subscriptions by Plan</h2>
            <div class="space-y-6">
                @foreach($planDistribution as $plan)
                <div class="flex items-center justify-between p-4 bg-surface rounded-xl border border-outline">
                    <div class="flex items-center">
                        <div class="w-5 h-5 rounded-full bg-primary-lime mr-4"></div>
                        <span class="text-base font-bold text-on-surface">{{ $plan->name }}</span>
                    </div>
                    <span class="text-sm font-medium text-on-surface-variant bg-primary-lime/20 px-3 py-1 rounded-lg">{{ $plan->tenants_count }} gyms</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-headline font-bold text-on-surface">Recent Payments</h2>
                <a href="{{ route('admin.tenants.index') }}" class="text-primary-lime hover:text-primary-lime/80 text-sm font-bold uppercase tracking-wide transition-all">View all gyms →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-outline">
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Gym</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline">
                        @foreach($recentPayments as $payment)
                        <tr class="hover:bg-surface transition-all">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-on-surface">
                                {{ $payment->tenant->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary-lime">
                                ₨ {{ number_format($payment->amount, 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-variant">
                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-on-surface-variant">
                                {{ $payment->payment_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide {{ $payment->status === 'completed' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <a href="{{ route('admin.subscriptions.reports.growth') }}" class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline hover:bg-surface hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="p-4 bg-blue-500/20 rounded-xl mr-6 group-hover:bg-blue-500/30 transition-all">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-1">Growth Analysis</h3>
                        <p class="text-on-surface-variant text-sm font-medium">Onboarding & Acquisition</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.subscriptions.reports.leaderboard') }}" class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline hover:bg-surface hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="p-4 bg-yellow-500/20 rounded-xl mr-6 group-hover:bg-yellow-500/30 transition-all">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-1">Leaderboard</h3>
                        <p class="text-on-surface-variant text-sm font-medium">Top performing gym entities</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.subscriptions.reports.health-score') }}" class="bg-surface-low rounded-2xl shadow-xl p-8 border border-outline hover:bg-surface hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="p-4 bg-red-500/20 rounded-xl mr-6 group-hover:bg-red-500/30 transition-all">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-1">Health Scores</h3>
                        <p class="text-on-surface-variant text-sm font-medium">Engagement and churn risk</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection