@extends('layouts.public')

@section('title', 'About GymSathi - More Than A Tool')

@section('content')
<div class="bg-surface text-on-surface">
    <!-- Hero -->
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('about-us-dark.png') }}" alt="Gym floor" class="h-full w-full object-cover object-center" />
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/15 to-surface"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 pt-28 pb-20 lg:pt-40 lg:pb-28">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-surface-container-low/70 px-3 py-1 text-xs font-bold tracking-widest uppercase text-primary-container">
                    <span class="h-1.5 w-1.5 rounded-full bg-primary-container"></span>
                    About GymSathi
                </div>

                <h1 class="mt-6 font-headline font-bold tracking-tighter leading-[0.95] text-white text-5xl sm:text-6xl lg:text-7xl">
                    MORE THAN A<br class="hidden sm:block" />
                    TOOL.<br />
                    WE ARE YOUR<br class="hidden sm:block" />
                    <span class="text-primary-container text-glow">SATHI.</span>
                </h1>

                <p class="mt-6 max-w-2xl text-on-surface-variant text-base sm:text-lg leading-relaxed">
                    Built for Nepal's fitness facilities: member management, attendance, payment tracking, and renewal automation - in one kinetic dashboard.
                </p>

                <div class="mt-10 flex flex-wrap items-center gap-3">
                    <a href="{{ route('login') }}" class="kinetic-gradient text-on-primary font-headline font-bold px-7 py-3 rounded-full hover:scale-[1.02] transition">
                        Start Free Trial
                    </a>
                    <a href="{{ route('support') }}" class="rounded-full bg-surface-container-high/70 px-7 py-3 font-headline font-bold text-white hover:bg-surface-container-high transition">
                        Talk to Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Story / Feature Cards -->
    <section class="py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-7 rounded-[2rem] bg-surface-container-low p-8 lg:p-10">
                    <div class="flex items-center justify-between gap-6">
                        <h2 class="font-headline font-bold text-xl tracking-wide uppercase">The meaning of Sathi</h2>
                        <span class="material-symbols-outlined text-primary-container">handshake</span>
                    </div>
                    <p class="mt-6 text-on-surface-variant leading-relaxed">
                        "Sathi" means partner. GymSathi is built to stand beside owners and managers - removing manual chaos (registers, payment chasing, missed renewals) so you can focus on the transformations that matter.
                    </p>
                </div>

                <div class="lg:col-span-5 rounded-[2rem] bg-surface-container-high p-8 lg:p-10">
                    <div class="flex items-center justify-between gap-6">
                        <h2 class="font-headline font-bold text-xl tracking-wide uppercase">Radical precision</h2>
                        <span class="material-symbols-outlined text-primary-container">verified</span>
                    </div>
                    <p class="mt-6 text-on-surface-variant leading-relaxed">
                        Tenant-first separation and clean flows keep every action predictable: members, packages, attendance, and billing - always in sync.
                    </p>
                </div>

                <div class="lg:col-span-4 rounded-[2rem] bg-surface-container-low p-8">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary-container">bolt</span>
                        <h3 class="font-headline font-bold tracking-wide uppercase">Elite performance</h3>
                    </div>
                    <p class="mt-4 text-on-surface-variant leading-relaxed">
                        One-tap attendance and fast member search keep the front desk moving.
                    </p>
                </div>

                <div class="lg:col-span-8 rounded-[2rem] bg-surface-container-low p-8">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <h3 class="font-headline font-bold tracking-wide uppercase">The companion bond</h3>
                            <p class="mt-4 text-on-surface-variant leading-relaxed">
                                Renewals and support stay close: WhatsApp notification hooks are present, and the site includes an AI support widget backed by a local knowledge base.
                            </p>
                        </div>
                        <div class="hidden sm:flex h-14 w-14 shrink-0 rounded-full bg-surface-container-high items-center justify-center">
                            <span class="material-symbols-outlined text-primary-container">forum</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooted Section -->
    <section class="py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <div class="lg:col-span-6 rounded-[2rem] overflow-hidden bg-surface-container-low relative min-h-[320px]">
                    <img src="{{ asset('about-us-dark.png') }}" alt="Nepal" class="absolute inset-0 h-full w-full object-cover object-center opacity-70" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-black/10"></div>
                    <div class="relative h-full p-8 flex flex-col justify-end">
                        <div class="inline-flex items-center gap-2 rounded-full bg-black/40 px-3 py-1 text-xs font-bold tracking-widest uppercase text-white">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary-container"></span>
                            Birgunj, Nepal
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 rounded-[2rem] bg-surface-container-low p-8 lg:p-10 flex flex-col justify-between">
                    <div>
                        <h2 class="font-headline font-bold text-2xl sm:text-3xl tracking-tight uppercase">Rooted in the gateway</h2>
                        <p class="mt-5 text-on-surface-variant leading-relaxed">
                            GymSathi is local-first. Built for Nepal, priced in NPR, and designed around the workflows gym owners actually use.
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-3xl sm:text-4xl font-headline font-bold text-primary-container">50+</div>
                            <div class="mt-1 text-xs uppercase tracking-widest text-on-surface-variant">Facilities served</div>
                        </div>
                        <div>
                            <div class="text-3xl sm:text-4xl font-headline font-bold text-primary-container">30</div>
                            <div class="mt-1 text-xs uppercase tracking-widest text-on-surface-variant">Day free trial</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Curators -->
    <section class="py-14 lg:py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h2 class="font-headline font-bold text-xl tracking-widest uppercase text-on-surface-variant">The Curators</h2>
            <p class="mt-4 max-w-2xl text-on-surface-variant leading-relaxed">
                A small crew obsessed with clarity: the product, the experience, and the outcomes for Nepal's fitness facilities.
            </p>

            <div class="mt-10 grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['role' => 'Product', 'focus' => 'Workflows'],
                    ['role' => 'Engineering', 'focus' => 'Reliability'],
                    ['role' => 'Design', 'focus' => 'Editorial UI'],
                    ['role' => 'Support', 'focus' => 'Onboarding'],
                ] as $person)
                    <div class="rounded-[1.75rem] bg-surface-container-low p-6">
                        <div class="aspect-[3/4] rounded-[1.25rem] bg-surface-container-high flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary-container text-5xl">person</span>
                        </div>
                        <div class="mt-5">
                            <div class="font-headline font-bold text-white">{{ $person['role'] }}</div>
                            <div class="mt-1 text-xs uppercase tracking-widest text-on-surface-variant">{{ $person['focus'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-primary-container text-on-primary-fixed">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                <div>
                    <h2 class="font-headline font-bold tracking-tighter uppercase text-3xl sm:text-4xl">Ready to find your Sathi?</h2>
                    <p class="mt-3 max-w-2xl text-on-primary-fixed/80 leading-relaxed">
                        Start your 30-day free trial or reach out for a quick onboarding walkthrough.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('login') }}" class="rounded-full bg-on-primary-fixed text-primary-container font-headline font-bold px-8 py-3 hover:scale-[1.02] transition">
                        Start Free Trial
                    </a>
                    <a href="{{ route('support') }}" class="rounded-full bg-primary-container/20 text-on-primary-fixed font-headline font-bold px-8 py-3 hover:bg-primary-container/25 transition">
                        Talk to Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
