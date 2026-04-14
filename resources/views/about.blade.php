@extends('layouts.public')

@section('title', 'About GymSathi — Our Mission & Vision')

@section('content')
<div class="pt-32 pb-24">
    <!-- Hero Section -->
    <header class="max-w-7xl mx-auto px-8 mb-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-3xl">
                <span class="inline-block py-1 px-3 rounded-full bg-surface-container-high border border-outline-variant/20 text-primary-lime text-xs font-bold tracking-widest uppercase mb-4">Our Story</span>
                <h1 class="text-6xl md:text-8xl font-headline font-bold tracking-tighter leading-none mb-6">
                    Powering the<br/>
                    <span class="text-[#C8F135] text-glow">Kinetic Pulse.</span>
                </h1>
                <p class="text-xl text-on-surface-variant max-w-xl font-light leading-relaxed">
                    GymSathi was born from a simple observation: Nepal's fitness industry is moving fast, but management tools were stuck in the past.
                </p>
            </div>
        </div>
    </header>

    <!-- Mission & Vision -->
    <section class="max-w-7xl mx-auto px-8 mb-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="p-12 rounded-[2.5rem] bg-surface-container-low border border-white/5 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-8xl text-primary-lime">rocket_launch</span>
                </div>
                <h2 class="text-4xl font-headline font-bold mb-6">The Mission</h2>
                <p class="text-on-surface-variant text-lg leading-relaxed">
                    To empower facility owners across Nepal with world-class automation. We believe that by removing the friction of manual management—payment chasing, attendance logs, and missed renewals—owners can focus on what truly matters: **the transformation of their members.**
                </p>
            </div>
            <div class="p-12 rounded-[2.5rem] bg-surface-container-low border border-white/5 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-8xl text-secondary">visibility</span>
                </div>
                <h2 class="text-4xl font-headline font-bold mb-6">The Vision</h2>
                <p class="text-on-surface-variant text-lg leading-relaxed">
                    A fitness ecosystem where data-driven decisions are the norm. We envision GymSathi as the central nervous system for every kinetic facility in Nepal, from local gyms to premium CrossFit boxes and luxury wellness retreats.
                </p>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="max-w-7xl mx-auto px-8 mb-32">
        <h2 class="text-3xl font-headline font-bold mb-12 text-center uppercase tracking-widest opacity-50">Our Core Principles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8">
                <div class="w-16 h-16 bg-primary-lime/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary-lime">bolt</span>
                </div>
                <h3 class="text-xl font-headline font-bold mb-4">Precision over Paper</h3>
                <p class="text-on-surface-variant text-sm">Replace ink-stained registers with real-time digital accuracy. No more "lost" records or missed fees.</p>
            </div>
            <div class="text-center p-8">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-secondary">favorite</span>
                </div>
                <h3 class="text-xl font-headline font-bold mb-4">Local First</h3>
                <p class="text-on-surface-variant text-sm">Built specifically for the Nepali market. Native eSewa/Khalti support and local WhatsApp/SMS gateways.</p>
            </div>
            <div class="text-center p-8">
                <div class="w-16 h-16 bg-tertiary-fixed-dim/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim">diversity_3</span>
                </div>
                <h3 class="text-xl font-headline font-bold mb-4">Member Centric</h3>
                <p class="text-on-surface-variant text-sm">Every feature is designed to improve the member experience, leading to higher retention and growth.</p>
            </div>
        </div>
    </section>

    <!-- Why "Kinetic"? -->
    <section class="max-w-7xl mx-auto px-8 relative">
        <div class="absolute inset-0 bg-primary-lime/5 blur-[120px] rounded-full"></div>
        <div class="relative z-10 bg-black/40 backdrop-blur-xl border border-white/5 rounded-[3rem] p-12 md:p-20 flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1">
                <h2 class="text-4xl md:text-5xl font-headline font-bold mb-8">Why <span class="text-primary-lime">"Kinetic"</span>?</h2>
                <div class="space-y-6 text-on-surface-variant text-lg leading-relaxed">
                    <p>Kinetic energy is energy in motion. We believe a gym is not a static building—it is a dynamic, moving environment filled with ambition, effort, and transformation.</p>
                    <p>Our software isn't just a database; it is the kinetic driver that keeps your business moving forward. We handle the static tasks (admin) so you can maintain the kinetic energy (growth).</p>
                </div>
            </div>
            <div class="w-full md:w-1/3">
                <div class="aspect-square rounded-2xl bg-surface-container-high border border-primary-lime/20 flex flex-col items-center justify-center p-8 text-center">
                    <span class="text-7xl font-headline font-bold text-primary-lime mb-4">K</span>
                    <span class="text-xs uppercase tracking-[0.3em] font-bold">The Kinetic Standard</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="max-w-7xl mx-auto px-8 mt-32 text-center">
        <h2 class="text-3xl font-headline font-bold mb-8">Ready to join the movement?</h2>
        <a href="{{ route('login') }}" class="kinetic-gradient text-on-primary font-headline font-bold text-lg px-12 py-5 rounded-full hover:scale-105 transition-all inline-block">Start Your Journey</a>
    </section>
</div>
@endsection
