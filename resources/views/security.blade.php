@extends('layouts.public')

@section('title', 'Security | GymSathi Kinetic')

@section('content')
<div class="pt-32 pb-24">
    <div class="max-w-4xl mx-auto px-8">
        <header class="mb-16">
            <span class="inline-block py-1 px-3 rounded-full bg-surface-container-high border border-outline-variant/20 text-primary-lime text-xs font-bold tracking-widest uppercase mb-4">Security Standards</span>
            <h1 class="text-6xl font-headline font-bold tracking-tighter leading-none mb-6">
                Protecting Your <br/><span class="text-primary-lime italic">Kinetic Data.</span>
            </h1>
            <p class="text-xl text-on-surface-variant font-light">
                At GymSathi, we treat your facility's data with the same intensity you bring to your training.
            </p>
        </header>

        <div class="space-y-12">
            <section class="p-8 rounded-3xl bg-surface-container-low border border-white/5">
                <div class="flex items-start gap-6">
                    <div class="w-12 h-12 bg-primary-lime/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-primary-lime">lock</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-headline font-bold mb-4">End-to-End Encryption</h2>
                        <p class="text-on-surface-variant leading-relaxed">
                            All communication between your device and our servers is encrypted using 256-bit SSL. Your member data, payment history, and staff records are protected at rest and in transit.
                        </p>
                    </div>
                </div>
            </section>

            <section class="p-8 rounded-3xl bg-surface-container-low border border-white/5">
                <div class="flex items-start gap-6">
                    <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-secondary">database</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-headline font-bold mb-4">Daily Backups</h2>
                        <p class="text-on-surface-variant leading-relaxed">
                            We perform automated daily backups of all tenant databases. In the event of a critical failure, your data can be restored within minutes to ensure minimal disruption to your facility.
                        </p>
                    </div>
                </div>
            </section>

            <section class="p-8 rounded-3xl bg-surface-container-low border border-white/5">
                <div class="flex items-start gap-6">
                    <div class="w-12 h-12 bg-tertiary-fixed-dim/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-tertiary-fixed-dim">verified_user</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-headline font-bold mb-4">Role-Based Access Control</h2>
                        <p class="text-on-surface-variant leading-relaxed">
                            You have full control over who sees what. Set permissions for your staff members so they only access the modules they need—nothing more, nothing less.
                        </p>
                    </div>
                </div>
            </section>

            <div class="mt-16 pt-16 border-t border-white/5">
                <h3 class="text-xl font-headline font-bold mb-4">Found a Vulnerability?</h3>
                <p class="text-on-surface-variant mb-6">
                    We take security seriously. If you've discovered a bug or security issue, please contact our security team immediately.
                </p>
                <a href="{{ route('contact-support') }}" class="inline-block border border-primary-lime text-primary-lime px-8 py-3 rounded-full font-bold hover:bg-primary-lime hover:text-on-primary transition-all">Report Security Issue</a>
            </div>
        </div>
    </div>
</div>
@endsection
