@extends('layouts.admin')

@section('title', 'Onboard New Gym')

@section('content')
<script>
let currentStep = 0; // Global variable for onclick handlers

document.addEventListener('DOMContentLoaded', function() {
    const steps = [
        document.getElementById('step-1'),
        document.getElementById('step-2'),
        document.getElementById('step-3')
    ];
    const indicators = document.querySelectorAll('.step-indicator');

    function showStep(stepIndex) {
        steps.forEach((step, i) => {
            step.classList.toggle('hidden', i !== stepIndex);
        });
        indicators.forEach((ind, i) => {
            const circle = ind.querySelector('span:first-child');
            const label = ind.querySelector('span:last-child');
            if (i === stepIndex) {
                circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold tracking-wider bg-primary-lime text-black';
                label.className = 'text-[10px] uppercase tracking-widest font-bold text-white';
            } else if (i < stepIndex) {
                circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold tracking-wider bg-green-500 text-white';
                label.className = 'text-[10px] uppercase tracking-widest font-bold text-green-400';
            } else {
                circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold tracking-wider bg-primary-surface border border-primary-border text-on-variant';
                label.className = 'text-[10px] uppercase tracking-widest font-bold text-on-variant';
            }
        });
        
        // Update buttons
        const btnBack = document.getElementById('btn-back');
        const btnNext = document.getElementById('btn-next');
        const btnSubmit = document.getElementById('btn-submit');
        
        btnBack.classList.toggle('hidden', stepIndex === 0);
        btnNext.classList.toggle('hidden', stepIndex === 2);
        btnSubmit.classList.toggle('hidden', stepIndex !== 2);
        
        currentStep = stepIndex;
    }

    window.goToStep = function(stepIndex) {
        if (stepIndex < currentStep) {
            showStep(stepIndex);
            return;
        }
        // Validate current step
        const currentSection = steps[currentStep];
        const inputs = currentSection.querySelectorAll('input[required], select[required], textarea[required]');
        let valid = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                valid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        if (valid) {
            showStep(stepIndex);
        }
    };

    // Initialize
    showStep(0);
});
</script>

<div class="max-w-7xl">

    {{-- Back link --}}
    <a href="{{ route('admin.tenants.index') }}"
        class="inline-flex items-center gap-2 text-[10px] uppercase tracking-widest font-bold text-on-variant hover:text-primary-lime transition-colors mb-8">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
        </svg>
        Gym Management / Add New Gym
    </a>

    {{-- Page title --}}
    <div class="mb-10">
        <h1 class="text-5xl font-headline font-bold tracking-tighter leading-none">
            Execute <span class="text-primary-lime">Onboarding</span>
        </h1>
        <p class="text-on-variant mt-3 max-w-xl">
            Drop the details. Register a new gym client and roll out setup, administrative essentials, and deploy their unique account.
        </p>
    </div>

    {{-- Step indicator --}}
    <div class="flex items-center gap-3 mb-10">
        @foreach([['01','Gym Details'], ['02','Owner Identity'], ['03','Platform Tier']] as $i => $step)
        <div class="flex items-center gap-3 step-indicator" style="cursor: pointer;" onclick="goToStep({{ $i }})">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold tracking-wider
                    {{ $i === 0 ? 'bg-primary-lime text-black' : 'bg-primary-surface border border-primary-border text-on-variant' }}">
                    {{ $i < 3 ? '✓' : $step[0] }}
                </span>
                <span class="text-[10px] uppercase tracking-widest font-bold {{ $i === 0 ? 'text-white' : 'text-on-variant' }}">{{ $step[1] }}</span>
            </div>
            @if($i < 2)
            <div class="w-12 h-px bg-primary-border mx-1"></div>
            @endif
        </div>
        @endforeach
    </div>

    @if ($errors->any())
    <div class="mb-8 p-5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 flex gap-3 items-start">
        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <ul class="list-none text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.tenants.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-8 items-start">

            {{-- ─── Left: Main Form ─── --}}
            <div class="space-y-6">

                {{-- GYM DETAILS --}}
                <div id="step-1" class="rounded-2xl bg-primary-surface border border-primary-border overflow-hidden">
                    <div class="px-8 py-5 border-b border-primary-border flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-primary-lime/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </span>
                            <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant">Gym Details</span>
                        </div>
                        <span class="text-[10px] text-on-variant opacity-40 uppercase tracking-widest">Step 01</span>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Gym Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="e.g. Muscle Bank" required
                                    class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Gym Type</label>
                                <div class="relative">
                                    <select name="gym_type"
                                        class="w-full appearance-none bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm cursor-pointer">
                                        <option value="single_studio" {{ old('gym_type') == 'single_studio' ? 'selected' : '' }}>Single Studio</option>
                                        <option value="multi_branch" {{ old('gym_type') == 'multi_branch' ? 'selected' : '' }}>Multi-Branch</option>
                                        <option value="boutique" {{ old('gym_type') == 'boutique' ? 'selected' : '' }}>Boutique Gym</option>
                                        <option value="crossfit" {{ old('gym_type') == 'crossfit' ? 'selected' : '' }}>CrossFit Box</option>
                                        <option value="yoga" {{ old('gym_type') == 'yoga' ? 'selected' : '' }}>Yoga Studio</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-on-variant pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">City / Location</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                placeholder="e.g. Birgunj, Kathmandu" required
                                class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">
                                Owner Address <span class="text-on-variant/40 normal-case tracking-normal text-[9px]">(optional)</span>
                            </label>
                            <textarea name="address" rows="2" placeholder="Full street address..."
                                class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm resize-none">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- OWNER IDENTITY --}}
                <div id="step-2" class="hidden rounded-2xl bg-primary-surface border border-primary-border overflow-hidden">
                    <div class="px-8 py-5 border-b border-primary-border flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-primary-lime/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant">Owner Identity</span>
                        </div>
                        <span class="text-[10px] text-on-variant opacity-40 uppercase tracking-widest">Step 02</span>
                    </div>

                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Full Name</label>
                                <input type="text" name="owner_name" value="{{ old('owner_name') }}"
                                    placeholder="Owner's full name" required
                                    class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Contact Number</label>
                                <input type="text" name="owner_phone" value="{{ old('owner_phone') }}"
                                    placeholder="98XXXXXXXX" required
                                    class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Owner Email</label>
                            <input type="email" name="owner_email" value="{{ old('owner_email') }}"
                                placeholder="owner@example.com" required
                                class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] uppercase tracking-widest text-on-variant font-bold">Password</label>
                            <input type="password" name="owner_password" required
                                placeholder="Set login password" minlength="8"
                                class="w-full bg-primary-dark border border-primary-border rounded-xl px-5 py-3.5 text-white placeholder-on-variant/40 focus:outline-none focus:border-primary-lime/50 focus:ring-1 focus:ring-primary-lime/20 transition-all text-sm">
                            <p class="text-[9px] text-on-variant/60">Minimum 8 characters. This will be the gym owner's login password.</p>
                        </div>
                    </div>
                </div>

                {{-- PLATFORM TIER --}}
                <div id="step-3" class="hidden rounded-2xl bg-primary-surface border border-primary-border overflow-hidden">
                    <div class="px-8 py-5 border-b border-primary-border flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-primary-lime/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-lime" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </span>
                            <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant">Platform Tier</span>
                        </div>
                        <span class="text-[10px] text-on-variant opacity-40 uppercase tracking-widest">Step 03</span>
                    </div>

                    <div class="p-8">
                        <p class="text-xs text-on-variant mb-6">Select the subscription tier that best fits this gym's operational scale and requirements.</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            {{-- Basic --}}
                            <label class="relative group cursor-pointer">
                                <input type="radio" name="plan" value="basic" class="peer hidden" {{ old('plan', 'standard') == 'basic' ? 'checked' : '' }}>
                                <div class="h-full p-6 rounded-2xl bg-primary-dark border border-primary-border
                                    peer-checked:border-primary-lime peer-checked:bg-primary-lime/5
                                    hover:border-primary-border/80 transition-all flex flex-col">
                                    <div class="flex items-start justify-between mb-5">
                                        <div>
                                            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant mb-3">Basic</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-[10px] text-on-variant font-bold">NPR</span>
                                                <span class="text-3xl font-headline font-bold text-white">800</span>
                                                <span class="text-[10px] text-on-variant">/mo</span>
                                            </div>
                                        </div>
                                        <div class="w-8 h-8 rounded-full border-2 border-primary-border peer-checked:border-primary-lime flex items-center justify-center shrink-0 mt-1 transition-all">
                                            <span class="w-3 h-3 rounded-full bg-primary-lime opacity-0 peer-checked:opacity-100 transition-all"></span>
                                        </div>
                                    </div>
                                    <ul class="space-y-2.5 mb-6 flex-1">
                                        @foreach(['Up to 100 Members','Manual Attendance','Payment Tracking','Core Dashboard'] as $feat)
                                        <li class="flex items-center gap-2 text-xs text-on-variant">
                                            <svg class="w-3.5 h-3.5 text-on-variant/50 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            {{ $feat }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center py-2.5 rounded-xl border border-primary-border peer-checked:border-primary-lime peer-checked:text-primary-lime text-on-variant text-[10px] font-bold uppercase tracking-widest transition-all group-hover:border-on-variant/40">
                                        Join Basic
                                    </div>
                                </div>
                            </label>

                            {{-- Standard --}}
                            <label class="relative group cursor-pointer">
                                <input type="radio" name="plan" value="standard" class="peer hidden" {{ old('plan', 'standard') == 'standard' ? 'checked' : '' }}>
                                <div class="h-full p-6 rounded-2xl bg-primary-dark border-2 border-primary-lime bg-primary-lime/5
                                    peer-checked:bg-primary-lime/10
                                    hover:bg-primary-lime/8 transition-all flex flex-col relative overflow-hidden">
                                    <span class="absolute top-0 right-0 bg-primary-lime text-black text-[8px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-bl-xl">Best Value</span>
                                    <div class="flex items-start justify-between mb-5">
                                        <div>
                                            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-primary-lime mb-3">Standard</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-[10px] text-primary-lime font-bold">NPR</span>
                                                <span class="text-3xl font-headline font-bold text-white">1,200</span>
                                                <span class="text-[10px] text-on-variant">/mo</span>
                                            </div>
                                        </div>
                                        <div class="w-8 h-8 rounded-full border-2 border-primary-lime flex items-center justify-center shrink-0 mt-1 transition-all bg-primary-lime/20">
                                            <span class="w-3 h-3 rounded-full bg-primary-lime"></span>
                                        </div>
                                    </div>
                                    <ul class="space-y-2.5 mb-6 flex-1">
                                        @foreach(['Up to 300 Members','WhatsApp Reminders','One-Tap Attendance','PDF Report Exports'] as $feat)
                                        <li class="flex items-center gap-2 text-xs text-on-variant">
                                            <svg class="w-3.5 h-3.5 text-primary-lime shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            {{ $feat }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center py-2.5 rounded-xl kinetic-gradient text-black text-[10px] font-bold uppercase tracking-widest transition-all">
                                        Join Standard
                                    </div>
                                </div>
                            </label>

                            {{-- Premium --}}
                            <label class="relative group cursor-pointer">
                                <input type="radio" name="plan" value="premium" class="peer hidden" {{ old('plan', 'standard') == 'premium' ? 'checked' : '' }}>
                                <div class="h-full p-6 rounded-2xl bg-primary-dark border border-primary-border
                                    peer-checked:border-primary-lime peer-checked:bg-primary-lime/5
                                    hover:border-primary-border/80 transition-all flex flex-col">
                                    <div class="flex items-start justify-between mb-5">
                                        <div>
                                            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant mb-3">Premium</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-[10px] text-on-variant font-bold">NPR</span>
                                                <span class="text-3xl font-headline font-bold text-white">2,000</span>
                                                <span class="text-[10px] text-on-variant">/mo</span>
                                            </div>
                                        </div>
                                        <div class="w-8 h-8 rounded-full border-2 border-primary-border peer-checked:border-primary-lime flex items-center justify-center shrink-0 mt-1 transition-all">
                                            <span class="w-3 h-3 rounded-full bg-primary-lime opacity-0 peer-checked:opacity-100 transition-all"></span>
                                        </div>
                                    </div>
                                    <ul class="space-y-2.5 mb-6 flex-1">
                                        @foreach(['Unlimited Members','Multi-Staff Access','Advanced Analytics','Priority Support'] as $feat)
                                        <li class="flex items-center gap-2 text-xs text-on-variant">
                                            <svg class="w-3.5 h-3.5 text-on-variant/50 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            {{ $feat }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center py-2.5 rounded-xl border border-primary-border peer-checked:border-primary-lime peer-checked:text-primary-lime text-on-variant text-[10px] font-bold uppercase tracking-widest transition-all group-hover:border-on-variant/40">
                                        Join Premium
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-4 pt-2">
                    <div class="flex gap-4">
                        <button type="button" id="btn-back" onclick="goToStep(currentStep - 1)" class="hidden flex-1 py-5 rounded-2xl border border-primary-border text-on-variant font-headline font-bold text-sm uppercase tracking-widest hover:bg-primary-surface transition-all">
                            Back
                        </button>
                        <button type="button" id="btn-next" onclick="goToStep(currentStep + 1)" class="flex-1 kinetic-gradient text-black font-headline font-bold py-5 rounded-2xl hover:opacity-90 hover:scale-[1.01] transition-all shadow-xl shadow-primary-lime/20 text-sm uppercase tracking-widest">
                            Next Step
                        </button>
                        <button type="submit" id="btn-submit" class="hidden flex-1 kinetic-gradient text-black font-headline font-bold py-5 rounded-2xl hover:opacity-90 hover:scale-[1.01] transition-all shadow-xl shadow-primary-lime/20 text-sm uppercase tracking-widest flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Execute Onboarding
                        </button>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <button type="reset" class="text-[10px] uppercase tracking-widest font-bold text-on-variant hover:text-white transition-colors">
                            Clear Form
                        </button>
                        <span class="w-px h-3 bg-primary-border"></span>
                        <a href="{{ route('admin.tenants.index') }}" class="text-[10px] uppercase tracking-widest font-bold text-on-variant hover:text-white transition-colors">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>

            {{-- ─── Right: Assist Panel ─── --}}
            <div class="space-y-5">

                {{-- Onboarding Assist --}}
                <div class="rounded-2xl bg-primary-surface border border-primary-border overflow-hidden">
                    <div class="px-6 py-4 border-b border-primary-border">
                        <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant">Onboarding Assist</span>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <div class="text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">Auto-generated on submit</div>
                            <ul class="space-y-2.5 text-xs text-on-variant">
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-lime shrink-0 mt-1.5"></span>
                                    Secure login credentials for the gym owner
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-lime shrink-0 mt-1.5"></span>
                                    30-day free trial starts immediately
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-lime shrink-0 mt-1.5"></span>
                                    WhatsApp notification to owner's number
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-lime shrink-0 mt-1.5"></span>
                                    Isolated tenant workspace created
                                </li>
                            </ul>
                        </div>

                        <div class="border-t border-primary-border pt-5">
                            <div class="text-[10px] uppercase tracking-widest text-on-variant font-bold mb-2">Guidelines</div>
                            <ul class="space-y-2.5 text-xs text-on-variant">
                                <li class="flex items-start gap-2.5">
                                    <svg class="w-3.5 h-3.5 text-on-variant/50 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Phone number must be a valid WhatsApp-enabled number
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <svg class="w-3.5 h-3.5 text-on-variant/50 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Gym name must be unique across the platform
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <svg class="w-3.5 h-3.5 text-on-variant/50 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Plan can be upgraded later from the billing panel
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Motivational card --}}
                <div class="rounded-2xl bg-primary-lime/5 border border-primary-lime/20 p-6">
                    <p class="font-headline font-bold text-xl text-white leading-snug tracking-tight mb-2">
                        Build the next<br><span class="text-primary-lime">Legacy.</span>
                    </p>
                    <p class="text-xs text-on-variant leading-relaxed">
                        Every great gym starts with a single onboarding. You're not just adding a client — you're growing the GymSathi network.
                    </p>
                </div>

                {{-- Plan comparison quick-ref --}}
                <div class="rounded-2xl bg-primary-surface border border-primary-border overflow-hidden">
                    <div class="px-6 py-4 border-b border-primary-border">
                        <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-on-variant">Plan Quick-Ref</span>
                    </div>
                    <div class="divide-y divide-primary-border">
                        @foreach([
                            ['Basic','NPR 800','100 members · Manual attendance'],
                            ['Standard','NPR 1,200','300 members · WhatsApp · PDF reports'],
                            ['Premium','NPR 2,000','Unlimited · Multi-staff · Analytics'],
                        ] as $ref)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-white">{{ $ref[0] }}</div>
                                <div class="text-[10px] text-on-variant mt-0.5">{{ $ref[2] }}</div>
                            </div>
                            <span class="text-xs font-bold text-primary-lime">{{ $ref[1] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
