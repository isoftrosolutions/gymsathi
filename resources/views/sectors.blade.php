@extends('layouts.public')

@section('title', 'GymSathi — Sector Solutions')

@section('content')
<div class="pt-32 pb-24">
    <!-- Hero Section -->
    <header class="max-w-7xl mx-auto px-8 mb-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-3xl">
                <span class="inline-block py-1 px-3 rounded-full bg-surface-container-high border border-outline-variant/20 text-secondary text-xs font-bold tracking-widest uppercase mb-4">Sectors &amp; Solutions</span>
                <h1 class="text-6xl md:text-8xl font-headline font-bold tracking-tighter leading-none mb-6">
                    One Software.<br/>
                    <span class="text-[#C8F135] text-glow">Infinite Ambition.</span>
                </h1>
                <p class="text-xl text-on-surface-variant max-w-xl font-light leading-relaxed">
                    GymSathi is built to power the kinetic pulse of every fitness and wellness ecosystem.
                </p>
            </div>
            <div class="hidden lg:block pb-4">
                <div class="w-16 h-1 w-24 bg-primary-container mb-4"></div>
                <p class="text-on-surface-variant text-sm font-label uppercase tracking-widest">Select your domain</p>
            </div>
        </div>
    </header>

    <!-- Sectors Showcase Grid -->
    <section class="max-w-7xl mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Sector 1: Fitness Club -->
            <div class="group relative overflow-hidden rounded-[2rem] bg-surface-container-low border-l-4 border-primary-container flex flex-col h-[520px]">
                <div class="absolute inset-0 z-0">
                    <img alt="Gym Floor" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                </div>
                <div class="relative z-10 p-8 mt-auto">
                    <span class="material-symbols-outlined text-primary-container text-4xl mb-4">fitness_center</span>
                    <h3 class="text-3xl font-headline font-bold mb-3">Fitness Club</h3>
                    <p class="text-on-surface-variant mb-6 text-sm leading-relaxed">Stop chasing payments. Automate memberships, track attendance, and increase monthly revenue — without hiring more staff.</p>
                    <a class="inline-flex items-center gap-2 text-primary-container font-bold hover:gap-4 transition-all duration-300" href="{{ route('welcome') }}#features">
                        See How It Works <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Sector 2: Dance Academy -->
            <div class="group relative overflow-hidden rounded-[2rem] bg-surface-container-low border-l-4 border-secondary flex flex-col h-[520px]">
                <div class="absolute inset-0 z-0">
                    <img alt="Dance Studio" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=2069&auto=format&fit=crop"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                </div>
                <div class="relative z-10 p-8 mt-auto">
                    <span class="material-symbols-outlined text-secondary text-4xl mb-4">auto_awesome_motion</span>
                    <h3 class="text-3xl font-headline font-bold mb-3">Dance Academy</h3>
                    <p class="text-on-surface-variant mb-6 text-sm leading-relaxed">End the scheduling chaos. Manage batches effortlessly, send automated SMS updates to parents, and track every student's progress.</p>
                    <a class="inline-flex items-center gap-2 text-secondary font-bold hover:gap-4 transition-all duration-300" href="{{ route('welcome') }}#features">
                        See How It Works <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Sector 3: Yoga Center -->
            <div class="group relative overflow-hidden rounded-[2rem] bg-surface-container-low border-l-4 border-tertiary-fixed-dim flex flex-col h-[520px]">
                <div class="absolute inset-0 z-0">
                    <img alt="Yoga Studio" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=2020&auto=format&fit=crop"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                </div>
                <div class="relative z-10 p-8 mt-auto">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-4xl mb-4">self_improvement</span>
                    <h3 class="text-3xl font-headline font-bold mb-3">Yoga Center</h3>
                    <p class="text-on-surface-variant mb-6 text-sm leading-relaxed">No more overbooked sessions. Take control of your batches with smart slot management and seamless member check-ins.</p>
                    <a class="inline-flex items-center gap-2 text-tertiary-fixed-dim font-bold hover:gap-4 transition-all duration-300" href="{{ route('welcome') }}#features">
                        See How It Works <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Sector 4: Swim Center -->
            <div class="group relative overflow-hidden rounded-[2rem] bg-surface-container-low border-l-4 border-primary-container flex flex-col h-[520px] lg:mt-8">
                <div class="absolute inset-0 z-0">
                    <img alt="Swimming Pool" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1519315901367-f34ff9154487?q=80&w=1974&auto=format&fit=crop"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                </div>
                <div class="relative z-10 p-8 mt-auto">
                    <span class="material-symbols-outlined text-primary-container text-4xl mb-4">pool</span>
                    <h3 class="text-3xl font-headline font-bold mb-3">Swim Center</h3>
                    <p class="text-on-surface-variant mb-6 text-sm leading-relaxed">Simplify lane bookings and seasonal memberships. Track swimmer progress and manage pool access with digital precision.</p>
                    <a class="inline-flex items-center gap-2 text-primary-container font-bold hover:gap-4 transition-all duration-300" href="{{ route('welcome') }}#features">
                        See How It Works <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Sector 5: Spa & Leisure -->
            <div class="group relative overflow-hidden rounded-[2rem] bg-surface-container-low border-l-4 border-secondary flex flex-col h-[520px] lg:mt-8">
                <div class="absolute inset-0 z-0">
                    <img alt="Luxury Spa" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2070&auto=format&fit=crop"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                </div>
                <div class="relative z-10 p-8 mt-auto">
                    <span class="material-symbols-outlined text-secondary text-4xl mb-4">spa</span>
                    <h3 class="text-3xl font-headline font-bold mb-3">Spa &amp; Leisure</h3>
                    <p class="text-on-surface-variant mb-6 text-sm leading-relaxed">Eliminate missed appointments. Automate booking reminders, maintain detailed client history, and run a stress-free facility.</p>
                    <a class="inline-flex items-center gap-2 text-secondary font-bold hover:gap-4 transition-all duration-300" href="{{ route('welcome') }}#features">
                        See How It Works <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Sector 6: Training Institute -->
            <div class="group relative overflow-hidden rounded-[2rem] bg-surface-container-low border-l-4 border-tertiary-fixed-dim flex flex-col h-[520px] lg:mt-8">
                <div class="absolute inset-0 z-0">
                    <img alt="Classroom" class="w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2070&auto=format&fit=crop"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                </div>
                <div class="relative z-10 p-8 mt-auto">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-4xl mb-4">history_edu</span>
                    <h3 class="text-3xl font-headline font-bold mb-3">Training Institute</h3>
                    <p class="text-on-surface-variant mb-6 text-sm leading-relaxed">Replace manual student logs with full automation. Centralize your certifications, attendance, and fee tracking in one powerful system.</p>
                    <a class="inline-flex items-center gap-2 text-tertiary-fixed-dim font-bold hover:gap-4 transition-all duration-300" href="{{ route('welcome') }}#features">
                        See How It Works <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="max-w-7xl mx-auto px-8 mt-32">
        <div class="relative rounded-[3rem] overflow-hidden bg-surface-container-low p-12 md:p-20 text-center">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-primary-container/10 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-secondary/10 blur-[100px] rounded-full"></div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-headline font-bold tracking-tight mb-8">Ready to <span class="text-primary-container italic">Automate?</span></h2>
                <p class="text-on-surface-variant text-lg mb-12">Join leading modern fitness businesses across Nepal transforming their operations with GymSathi.</p>
                <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                    <a href="{{ route('login') }}" class="kinetic-gradient text-on-primary font-headline font-bold text-lg px-10 py-5 rounded-full hover:scale-105 transition-all shadow-xl shadow-primary-container/20 inline-block">Automate Your Facility Today</a>
                    <button class="text-on-surface border border-outline-variant/30 font-headline font-medium px-10 py-5 rounded-full hover:bg-surface-bright transition-all">See Demo in 2 Minutes</button>
                </div>
                <p class="mt-8 text-on-surface-variant/60 text-sm font-label uppercase tracking-widest">Trusted by 50+ gyms and institutes across Nepal</p>
            </div>
        </div>
    </section>
</div>
@endsection
