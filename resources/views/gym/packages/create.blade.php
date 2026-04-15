@extends('layouts.gym')

@section('title', 'Create Package')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.packages.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Packages
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-8 max-w-2xl">
    <h2 class="text-2xl font-headline font-bold text-white mb-8">Create New Package</h2>
    
    <form method="POST" action="{{ route('gym.packages.store') }}" class="space-y-6">
        @csrf
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Package Name *</label>
            <input type="text" name="name" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="e.g., Monthly, Yearly">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all"></textarea>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-on-variant mb-2">Price (Rs.) *</label>
                <input type="number" name="price" required min="0" step="0.01" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
            <div>
                <label class="block text-sm text-on-variant mb-2">Duration Type *</label>
                <select name="duration_type" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                    <option value="days">Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Duration *</label>
            <input type="number" name="duration_days" required min="1" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="e.g., 30">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Features (one per line)</label>
            <textarea name="features" rows="4" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all" placeholder="Unlimited Access&#10;Locker Included&#10;Free Parking"></textarea>
        </div>
        
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 rounded border-primary-border bg-black/20 text-primary-lime focus:ring-primary-lime">
                <span class="text-sm text-white">Active</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded border-primary-border bg-black/20 text-primary-lime focus:ring-primary-lime">
                <span class="text-sm text-white">Featured</span>
            </label>
        </div>
        
        <button type="submit" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
            Create Package
        </button>
    </form>
</div>
@endsection
