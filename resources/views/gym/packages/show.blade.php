@extends('layouts.gym')

@section('title', $package->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.packages.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Packages
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8 mb-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <div class="text-xs text-on-variant uppercase tracking-widest mb-2">{{ $package->duration_text }}</div>
                    <h2 class="text-3xl font-headline font-bold text-white">{{ $package->name }}</h2>
                </div>
                <span class="px-4 py-2 text-xs uppercase font-bold tracking-widest rounded-full {{ $package->is_active ? 'bg-primary-lime/10 border border-primary-lime text-primary-lime' : 'bg-red-500/10 border border-red-500 text-red-500' }}">
                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="text-4xl font-headline font-bold text-primary-lime mb-6">
                Rs. {{ number_format($package->price, 0) }}
            </div>

            @if($package->description)
                <p class="text-on-variant mb-8">{{ $package->description }}</p>
            @endif

            @if($package->features)
                <h3 class="text-lg font-headline font-bold text-white mb-4">Features</h3>
                <ul class="space-y-3 mb-8">
                    @foreach($package->features as $feature)
                    <li class="flex items-center gap-3 text-on-surface">
                        <svg class="w-5 h-5 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
            @endif

            <div class="grid grid-cols-2 gap-6 pt-6 border-t border-primary-border">
                <div>
                    <span class="text-sm text-on-variant">Duration</span>
                    <p class="text-white font-bold">{{ $package->duration_days }} {{ $package->duration_type }}</p>
                </div>
                @if($package->max_members)
                <div>
                    <span class="text-sm text-on-variant">Max Members</span>
                    <p class="text-white font-bold">{{ $package->max_members }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-primary-surface border border-primary-border rounded-3xl p-8">
            <h3 class="text-lg font-headline font-bold text-white mb-6">Actions</h3>
            
            <div class="space-y-4">
                <a href="{{ route('gym.packages.edit', $package->id) }}" class="block w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl text-center hover:scale-[1.02] transition-all">
                    Edit Package
                </a>
                
                <form action="{{ route('gym.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500/10 border border-red-500 text-red-500 font-headline font-bold py-4 rounded-xl hover:bg-red-500/20 transition-all">
                        Delete Package
                    </button>
                </form>
            </div>

            @if($package->is_featured)
            <div class="mt-6 p-4 bg-primary-lime/10 border border-primary-lime/30 rounded-xl">
                <div class="flex items-center gap-2 text-primary-lime text-sm font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    Featured Package
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
