<!-- Top Navigation Bar -->
<nav class="fixed top-0 w-full z-50 bg-[#111318]/80 backdrop-blur-xl">
<div class="max-w-7xl mx-auto px-8 h-20 flex justify-between items-center" style="background: #001e2b;">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <div style="font-size: 1.75rem; font-weight: 700; color: #00ed64; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.02em;">
                <a href="http://localhost/gym" style="text-decoration: none; color: inherit;">GymSathi</a>
            </div>
            <div style="width: 6px; height: 6px; background: #00ed64; border-radius: 50%;"></div>
        </div>




    </div>

    <style>
        /* Navigation Link Styles */
        .nav-link:hover {
            color: #00ed64 !important;
            transform: translateY(-1px);
        }

        .nav-link.active {
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #00ed64;
        }

        /* CTA Button Styles */
        .cta-button:hover {
            background: #00ed64;
            color: #000000;
            transform: scale(1.05);
            box-shadow: rgba(0,0,0,0.06) 0px 1px 6px;
        }

        .cta-button:active {
            transform: scale(0.95);
        }

        /* Mobile Menu */
        .mobile-menu-btn:hover {
            color: #00ed64;
        }

        /* Mobile Navigation (Hidden by default) */
        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: #001e2b;
                border-top: 1px solid #3d4f58;
                padding: 1rem;
                box-shadow: rgba(0, 30, 43, 0.12) 0px 26px 44px;
            }

            .mobile-menu.active {
                display: block;
            }

            .mobile-menu a {
                display: block;
                padding: 0.75rem 0;
                color: #b8c4c2;
                text-decoration: none;
                font-family: 'Manrope', sans-serif;
                font-weight: 500;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .mobile-menu a:hover {
                color: #00ed64;
            }
        }
    </style>
        <div class="hidden md:flex items-center gap-8">
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight {{ request()->routeIs('welcome') ? 'text-[#C8F135] font-bold border-b-2 border-[#C8F135] pb-1' : '' }}" href="{{ route('welcome') }}">Home</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight {{ request()->routeIs('sectors') ? 'text-[#C8F135] font-bold border-b-2 border-[#C8F135] pb-1' : '' }}" href="{{ route('sectors') }}">Sectors</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight" href="{{ route('welcome') }}#features">Features</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight" href="{{ route('welcome') }}#pricing">Pricing</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight {{ request()->routeIs('about') ? 'text-[#C8F135] font-bold border-b-2 border-[#C8F135] pb-1' : '' }}" href="{{ route('about') }}">About</a>
        </div>
        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="text-[#C5C9AE] hover:text-[#C8F135] transition-all px-4 py-2 font-headline font-medium tracking-tight">Login</a>
                <a href="{{ route('login') }}" class="kinetic-gradient text-on-primary font-headline font-bold px-6 py-2.5 rounded-full hover:opacity-90 transition-all active:scale-95 inline-block">Get Started</a>
            @endguest

            @auth
                <span class="text-[#C5C9AE] text-sm font-label mr-2">Hello, {{ auth()->user()->name }}</span>
                <a href="{{ auth()->user()->platform_role === 'super_admin' ? route('admin.dashboard') : route('dashboard') }}" 
                   class="kinetic-gradient text-on-primary font-headline font-bold px-6 py-2 rounded-full hover:opacity-90 transition-all active:scale-95 inline-block mr-2">
                    DASHBOARD
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="text-[#C5C9AE] hover:text-red-400 transition-all px-4 py-2 font-headline font-medium tracking-tight border border-[#C5C9AE]/20 rounded-lg">Logout</button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden md:hidden" style="position: absolute; top: 80px; left: 0; right: 0; background: #001e2b; border-top: 1px solid #3d4f58; padding: 1rem; box-shadow: rgba(0, 30, 43, 0.12) 0px 26px 44px;">
        <a class="block py-3 text-[#b8c4c2] hover:text-[#C8F135] transition-colors" href="{{ route('welcome') }}">Home</a>
        <a class="block py-3 text-[#b8c4c2] hover:text-[#C8F135] transition-colors" href="{{ route('sectors') }}">Sectors</a>
        <a class="block py-3 text-[#b8c4c2] hover:text-[#C8F135] transition-colors" href="{{ route('welcome') }}#features">Features</a>
        <a class="block py-3 text-[#b8c4c2] hover:text-[#C8F135] transition-colors" href="{{ route('welcome') }}#pricing">Pricing</a>
        <a class="block py-3 text-[#b8c4c2] hover:text-[#C8F135] transition-colors" href="{{ route('about') }}">About</a>
        <a class="block py-3 text-[#b8c4c2] hover:text-[#C8F135] transition-colors px-4 py-2" href="{{ route('login') }}">Login</a>
        <a class="kinetic-gradient text-on-primary font-headline font-bold px-6 py-2.5 rounded-full hover:opacity-90 transition-all active:scale-95 inline-block mt-3" href="{{ route('login') }}">Get Started</a>
    </div>
</nav>
