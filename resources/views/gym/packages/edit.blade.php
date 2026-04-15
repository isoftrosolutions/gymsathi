@extends('layouts.gym')

@section('title', 'Edit Package')

@section('content')
<div class="mb-8">
    <a href="{{ route('gym.packages.show', $package->id) }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Package
    </a>
</div>

<div class="bg-primary-surface border border-primary-border rounded-3xl p-8 max-w-2xl">
    <h2 class="text-2xl font-headline font-bold text-white mb-8">Edit Package</h2>
    
    <form method="POST" action="{{ route('gym.packages.update', $package->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Package Name *</label>
            <input type="text" name="name" value="{{ old('name', $package->name) }}" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">{{ old('description', $package->description) }}</textarea>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-on-variant mb-2">Price (Rs.) *</label>
                <input type="number" name="price" value="{{ old('price', $package->price) }}" required min="0" step="0.01" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
            </div>
            <div>
                <label class="block text-sm text-on-variant mb-2">Duration Type *</label>
                <select name="duration_type" required class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
                    <option value="days" {{ old('duration_type', $package->duration_type) === 'days' ? 'selected' : '' }}>Days</option>
                    <option value="months" {{ old('duration_type', $package->duration_type) === 'months' ? 'selected' : '' }}>Months</option>
                    <option value="years" {{ old('duration_type', $package->duration_type) === 'years' ? 'selected' : '' }}>Years</option>
                </select>
            </div>
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Duration *</label>
            <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" required min="1" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">
        </div>
        
        <div>
            <label class="block text-sm text-on-variant mb-2">Features (one per line)</label>
            <textarea name="features" rows="4" class="w-full bg-black/20 border border-primary-border rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-lime transition-all">{{ old('features', is_array($package->features) ? implode("\n", $package->features) : '') }}</textarea>
        </div>
        
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-primary-border bg-black/20 text-primary-lime focus:ring-primary-lime">
                <span class="text-sm text-white">Active</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }} class="w-5 h-5 rounded border-primary-border bg-black/20 text-primary-lime focus:ring-primary-lime">
                <span class="text-sm text-white">Featured</span>
            </label>
        </div>
        
        <button type="submit" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl hover:scale-[1.02] transition-all">
            Update Package
        </button>
    </form>
</div>
@endsection
