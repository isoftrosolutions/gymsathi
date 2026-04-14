@extends('layouts.admin')

@section('title', 'Onboard New Gym')

@section('content')
<div class="max-w-4xl">
    <!-- Header -->
    <div class="mb-12">
        <a href="{{ route('admin.tenants.index') }}" class="text-on-variant hover:text-primary-lime transition-colors flex items-center gap-2 text-xs font-bold uppercase tracking-widest mb-4">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Back to Network
        </a>
        <h1 class="text-5xl font-headline font-bold tracking-tighter">Manual <span class="text-primary-lime">Onboarding</span></h1>
        <p class="text-on-variant mt-2">Initialize a new gym account and generate credentials.</p>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tenants.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="p-10 rounded-[2.5rem] bg-primary-surface border border-primary-border/50 space-y-10 shadow-2xl">
            <!-- Gym Basics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Gym name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Muscle Bank" required
                        class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="e.g. Birgunj" required
                        class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all">
                </div>
            </div>

            <!-- Owner Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Owner Name</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name') }}" placeholder="Full name of the owner" required
                        class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Owner Phone (WhatsApp)</label>
                    <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" placeholder="e.g. 98XXXXXXXX" required
                        class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all">
                </div>
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Address (Optional)</label>
                <textarea name="address" rows="3" placeholder="Full street address..."
                    class="w-full bg-primary-dark border-none rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-primary-lime/20 transition-all resize-none">{{ old('address') }}</textarea>
            </div>

            <!-- Subscription Plan -->
            <div class="space-y-2">
                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Initial Plan</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach(['basic', 'standard', 'premium'] as $plan)
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="plan" value="{{ $plan }}" class="peer hidden" {{ old('plan', 'basic') == $plan ? 'checked' : '' }}>
                        <div class="p-6 rounded-2xl bg-primary-dark border border-primary-border/50 peer-checked:border-primary-lime peer-checked:bg-primary-lime/5 transition-all text-center">
                            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold {{ $plan == 'basic' ? 'text-on-variant' : ($plan == 'standard' ? 'text-secondary' : 'text-primary-lime') }} mb-1">{{ $plan }}</span>
                            <span class="text-xs text-on-variant group-hover:text-white transition-colors capitalize">Select Plan</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <button type="reset" class="px-8 py-4 rounded-xl text-on-variant font-bold hover:text-white transition-all uppercase tracking-widest text-xs">Reset Form</button>
            <button type="submit" class="kinetic-gradient text-black font-headline font-bold px-12 py-4 rounded-xl hover:scale-105 transition-all shadow-xl shadow-primary-lime/20">
                Create Gym Account
            </button>
        </div>
    </form>

    <div class="mt-12 p-6 rounded-2xl bg-white/5 border border-white/5 flex gap-4 items-center">
        <span class="material-symbols-outlined text-primary-lime">info</span>
        <p class="text-xs text-on-variant leading-relaxed">The system will automatically generate a password and start a 30-day free trial for this gym. A notification should be sent to the owner's WhatsApp number.</p>
    </div>
</div>
@endsection
