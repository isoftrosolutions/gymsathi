@extends('layouts.admin')

@section('title', $tenant->name)

@section('content')
<div class="space-y-12">
    <!-- Breadcrumbs & Header -->
    <div>
        <a href="{{ route('admin.tenants.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-xs font-bold uppercase tracking-widest mb-4">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Back to Network
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-6xl font-headline font-bold tracking-tighter">{{ $tenant->name }}</h1>
                <div class="flex items-center gap-4 mt-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $tenant->getStatusBadgeClass() }} border">
                        {{ $tenant->getStatusDisplayText() }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/5 text-white border border-white/10">
                        {{ $tenant->plan?->name ?? $tenant->plan }} Plan
                    </span>
                    <span class="text-on-variant text-sm">Since {{ $tenant->created_at->format('M Y') }}</span>
                </div>
            </div>
            
            <div class="flex gap-3">
                <form action="{{ route('admin.tenants.reset-password', $tenant) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white/5 hover:bg-white/10 text-white font-bold px-6 py-4 rounded-xl border border-white/5 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock_reset</span>
                        Reset Password
                    </button>
                </form>

                @if($tenant->isPending())
                <form action="{{ route('admin.tenants.approve', $tenant) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="kinetic-gradient text-black font-headline font-bold px-8 py-4 rounded-xl hover:scale-105 transition-all shadow-xl shadow-primary-lime/20">
                        Approve & Activate
                    </button>
                </form>
                @elseif($tenant->isActive() || $tenant->isExpired())
                <form action="{{ route('admin.tenants.suspend', $tenant) }}" method="POST" onsubmit="return confirm('Suspend this gym? Members will lose access.');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-500 font-bold px-8 py-4 rounded-xl border border-red-500/20 transition-all">
                        Suspend Gym
                    </button>
                </form>
                @elseif($tenant->isSuspended())
                <form action="{{ route('admin.tenants.reactivate', $tenant) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="kinetic-gradient text-black font-headline font-bold px-8 py-4 rounded-xl hover:scale-105 transition-all">
                        Reactivate Gym
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Info Card -->
            <div class="p-10 rounded-[2.5rem] bg-primary-surface border border-primary-border/50">
                <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant mb-8">Facility Profile</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-variant/40 font-bold mb-1">Owner</p>
                        <p class="text-xl font-bold text-white">{{ $tenant->owner_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-variant/40 font-bold mb-1">Contact</p>
                        <p class="text-xl font-bold text-white">{{ $tenant->owner_phone }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-variant/40 font-bold mb-1">Location</p>
                        <p class="text-lg text-white">{{ $tenant->city }}</p>
                        <p class="text-sm text-on-variant">{{ $tenant->address ?? 'No street address provided.' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-variant/40 font-bold mb-1">Subscription Expiry</p>
                        <p class="text-lg font-bold {{ $tenant->subscription_expires_at?->isPast() ? 'text-red-500' : 'text-primary-lime' }}">
                            {{ $tenant->subscription_expires_at?->format('M d, Y') ?? 'N/A' }}
                        </p>
                        <p class="text-[10px] text-on-variant uppercase mt-1">{{ $tenant->subscription_expires_at?->diffForHumans() ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Subscription History -->
            <div class="p-10 rounded-[2.5rem] bg-primary-surface border border-primary-border/50">
                <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant mb-8">Subscription History</h3>
                @if($tenant->subscriptions->count() > 0)
                <div class="space-y-4">
                    @foreach($tenant->subscriptions()->latest()->take(5)->get() as $subscription)
                    <div class="flex items-center justify-between p-4 bg-white/[0.02] rounded-xl">
                        <div class="flex items-center gap-4">
                            <div class="p-2 rounded-lg {{ $subscription->status === 'active' ? 'bg-green-500/10' : 'bg-gray-500/10' }}">
                                <span class="material-symbols-outlined text-sm {{ $subscription->status === 'active' ? 'text-green-500' : 'text-gray-500' }}">
                                    {{ $subscription->status === 'trial' ? 'schedule' : ($subscription->status === 'active' ? 'check_circle' : 'cancel') }}
                                </span>
                            </div>
                            <div>
                                <p class="text-white font-bold">{{ $subscription->plan->name }} Plan</p>
                                <p class="text-xs text-on-variant">
                                    {{ $subscription->starts_at->format('M d, Y') }} - {{ $subscription->ends_at->format('M d, Y') }}
                                    @if($subscription->trial_ends_at)
                                    (Trial until {{ $subscription->trial_ends_at->format('M d, Y') }})
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-bold">₨ {{ number_format($subscription->price, 0) }}/month</p>
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' :
                                   ($subscription->status === 'trial' ? 'bg-blue-100 text-blue-800' :
                                   'bg-gray-100 text-gray-800') }} border">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-primary-border text-4xl mb-4">receipt_long</span>
                    <p class="text-on-variant">No subscription history available</p>
                </div>
                @endif
            </div>

            <!-- Activity / Growth (Placeholder) -->
            <div class="p-10 rounded-[2.5rem] bg-primary-surface border border-primary-border/50 h-80 flex flex-col justify-center items-center text-center">
                <span class="material-symbols-outlined text-primary-border text-6xl mb-4">insights</span>
                <h4 class="text-white font-bold">Growth Analytics</h4>
                <p class="text-on-variant text-sm max-w-xs mt-2">Member count and revenue graphs will appear here once more data is collected.</p>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Stats Summary -->
            <div class="p-8 rounded-[2.5rem] bg-primary-surface border border-primary-border/50">
                <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant mb-6">Vital Metrics</h3>
                <div class="space-y-6">
                    <div class="flex justify-between items-end">
                        <span class="text-sm text-on-variant">Total Members</span>
                        <span class="text-2xl font-headline font-bold text-white">{{ $tenant->getMemberCount() }}</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-sm text-on-variant">Monthly Revenue</span>
                        <span class="text-2xl font-headline font-bold text-primary-lime">₨ {{ number_format($tenant->activeSubscription()?->price ?? 0, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-sm text-on-variant">Support Tickets</span>
                        <span class="text-2xl font-headline font-bold text-white">{{ $tenant->getSupportTicketsCount() }}</span>
                    </div>
                </div>
            </div>

            <!-- Transfer Ownership -->
            <div class="p-8 rounded-[2.5rem] bg-white/[0.02] border border-dashed border-primary-border">
                <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant mb-4">Transfer Control</h3>
                <p class="text-xs text-on-variant mb-6">Assign this facility to a new owner phone number.</p>

                <form action="{{ route('admin.tenants.transfer-ownership', $tenant) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">New Owner Name</label>
                        <input type="text" name="new_owner_name" required
                               class="w-full bg-primary-dark border-none rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all"
                               placeholder="Enter new owner's full name">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">New Owner Phone</label>
                        <input type="text" name="new_owner_phone" required
                               class="w-full bg-primary-dark border-none rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all"
                               placeholder="Enter new owner's phone number">
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-primary-lime/10 border border-primary-lime/20 text-primary-lime text-xs font-bold hover:bg-primary-lime/20 transition-all"
                            onclick="return confirm('Transfer ownership to the new owner? The new owner will receive login credentials.')">
                        Transfer Ownership
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
