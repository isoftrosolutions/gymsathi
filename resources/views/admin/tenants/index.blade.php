@extends('layouts.admin')

@section('title', 'Gym Management')

@section('content')
@php
    $plans = \App\Models\Plan::active()->get();
@endphp
<div class="space-y-12">
    <!-- Header -->
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-5xl font-headline font-bold tracking-tighter">Gym <span class="text-primary-lime">Network</span></h1>
            <p class="text-on-variant mt-2">Manage the lifecycle of every facility on the platform.</p>
        </div>
        <a href="{{ route('admin.tenants.create') }}" class="kinetic-gradient text-black font-headline font-bold px-8 py-4 rounded-xl flex items-center gap-2 hover:scale-105 transition-all">
            <span class="material-symbols-outlined">add</span>
            Add New Gym
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="p-8 rounded-[2rem] bg-primary-surface border border-primary-border/50">
        <form action="{{ route('admin.tenants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="md:col-span-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">Search</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Gym Name or City..."
                        class="w-full bg-primary-dark border-none rounded-xl px-12 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-variant">search</span>
                </div>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">Status</label>
                <select name="status" class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all appearance-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">Plan</label>
                <select name="plan" class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all appearance-none">
                    <option value="">All Plans</option>
                    @foreach($plans as $plan)
                    <option value="{{ $plan->slug }}" {{ request('plan') == $plan->slug ? 'selected' : '' }}>
                        {{ $plan->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-white/5 text-white font-bold py-4 rounded-xl hover:bg-white/10 transition-all border border-white/5">Apply Filters</button>
            </div>
        </form>
    </div>

    <!-- Gym List Table -->
    <div class="bg-primary-surface rounded-[2.5rem] border border-primary-border/50 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-primary-border/50">
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold">Gym Details</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold">City</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold">Plan</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold">Members</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold">Status</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold">Expiry</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest text-on-variant font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-border/30">
                    @forelse($tenants as $tenant)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-white font-bold">{{ $tenant->name }}</span>
                                <span class="text-xs text-on-variant">{{ $tenant->owner_name }} ({{ $tenant->owner_phone }})</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-on-variant font-medium">{{ $tenant->city }}</td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/5 text-white border border-white/10">
                                {{ $tenant->plan?->name ?? $tenant->plan }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-white font-headline font-bold">{{ $tenant->getMemberCount() }}</td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $tenant->getStatusBadgeClass() }} border">
                                {{ $tenant->getStatusDisplayText() }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-on-variant text-xs">
                            {{ $tenant->subscription_expires_at?->format('M d, Y') ?? 'N/A' }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-1">
                                {{-- View Details --}}
                                <a href="{{ route('admin.tenants.show', $tenant) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-surface border border-primary-border text-on-variant hover:text-primary-lime hover:border-primary-lime transition-all duration-200"
                                    title="View Details">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </a>

                                {{-- Status-specific Actions --}}
                                @if($tenant->isPending())
                                    {{-- Approve --}}
                                    <form action="{{ route('admin.tenants.approve', $tenant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-surface border border-primary-border text-on-variant hover:text-green-500 hover:border-green-500 transition-all duration-200"
                                                title="Approve Gym">
                                            <span class="material-symbols-outlined text-base">check_circle</span>
                                        </button>
                                    </form>
                                    {{-- Reject --}}
                                    <form action="{{ route('admin.tenants.reject', $tenant) }}" method="POST" class="inline" onsubmit="return confirm('Reject this gym application?');">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-surface border border-primary-border text-on-variant hover:text-red-500 hover:border-red-500 transition-all duration-200"
                                                title="Reject Gym">
                                            <span class="material-symbols-outlined text-base">cancel</span>
                                        </button>
                                    </form>
                                @elseif($tenant->isActive() || $tenant->isExpired())
                                    {{-- Suspend --}}
                                    <form action="{{ route('admin.tenants.suspend', $tenant) }}" method="POST" class="inline" onsubmit="return confirm('Suspend this gym? Members will lose access.');">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-surface border border-primary-border text-on-variant hover:text-orange-500 hover:border-orange-500 transition-all duration-200"
                                                title="Suspend Gym">
                                            <span class="material-symbols-outlined text-base">pause_circle</span>
                                        </button>
                                    </form>
                                @elseif($tenant->isSuspended())
                                    {{-- Reactivate --}}
                                    <form action="{{ route('admin.tenants.reactivate', $tenant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-surface border border-primary-border text-on-variant hover:text-green-500 hover:border-green-500 transition-all duration-200"
                                                title="Reactivate Gym">
                                            <span class="material-symbols-outlined text-base">play_circle</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete (always available) --}}
                                <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Permanently delete this gym? This cannot be undone.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-surface border border-primary-border text-on-variant hover:text-red-500 hover:border-red-500 transition-all duration-200"
                                            title="Delete Gym">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center text-on-variant italic">No gyms found matching your criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tenants->hasPages())
        <div class="px-8 py-6 bg-primary-dark/50 border-t border-primary-border/50">
            {{ $tenants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
