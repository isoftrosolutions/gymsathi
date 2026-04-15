@extends('layouts.gym')

@section('title', 'Packages')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-headline font-bold text-white">Packages</h1>
        <p class="text-on-variant mt-1">Manage membership packages</p>
    </div>
    <a href="{{ route('gym.packages.create') }}" class="kinetic-gradient text-black font-headline font-bold px-6 py-3 rounded-xl hover:scale-105 transition-all">
        + Add Package
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($packages as $package)
    <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 relative overflow-hidden group {{ $package->is_featured ? 'border-primary-lime' : '' }}">
        @if($package->is_featured)
        <div class="absolute top-4 right-4 px-3 py-1 bg-primary-lime text-black text-[10px] font-bold uppercase tracking-wider rounded-full">
            Featured
        </div>
        @endif
        
        <div class="text-xs text-on-variant uppercase tracking-widest mb-2">{{ $package->duration_text }}</div>
        <h3 class="text-2xl font-headline font-bold text-white mb-4">{{ $package->name }}</h3>
        <div class="text-3xl font-headline font-bold text-primary-lime mb-6">
            Rs. {{ number_format($package->price, 0) }}
        </div>
        
        @if($package->description)
        <p class="text-on-variant text-sm mb-6">{{ $package->description }}</p>
        @endif
        
        @if($package->features)
        <ul class="space-y-2 mb-8">
            @foreach($package->features as $feature)
            <li class="flex items-center gap-2 text-sm text-on-surface">
                <svg class="w-4 h-4 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ $feature }}
            </li>
            @endforeach
        </ul>
        @endif
        
        <div class="flex items-center gap-2 pt-6 border-t border-primary-border/50">
            <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest rounded-full {{ $package->is_active ? 'bg-primary-lime/10 border border-primary-lime text-primary-lime' : 'bg-red-500/10 border border-red-500 text-red-500' }}">
                {{ $package->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        
        <div class="flex items-center justify-end gap-2 mt-4">
            <a href="{{ route('gym.packages.edit', $package->id) }}" class="p-2 text-on-variant hover:text-primary-lime transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-on-variant">
        No packages found. Create your first package.
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $packages->links() }}
</div>
@endsection
