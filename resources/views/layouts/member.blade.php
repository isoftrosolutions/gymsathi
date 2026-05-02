<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GymSathi') }} | @yield('title', 'Member Portal')</title>

    <!-- Fonts: Syne (headlines) + Manrope (body) + Space Grotesk (data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Manrope:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'surface':                  '#111318',
                        'surface-dim':              '#111318',
                        'surface-bright':           '#37393f',
                        'surface-container-lowest': '#0c0e13',
                        'surface-container-low':    '#1a1b21',
                        'surface-container':        '#1e1f25',
                        'surface-container-high':   '#282a2f',
                        'surface-container-highest':'#33353a',
                        'on-surface':               '#e2e2e9',
                        'on-surface-variant':       '#c5c9ae',
                        'primary':                  '#ffffef',
                        'primary-fixed':            '#c9f236',
                        'primary-fixed-dim':        '#aed50d',
                        'primary-container':        '#c8f135',
                        'on-primary':               '#293500',
                        'on-primary-container':     '#566c00',
                        'secondary':                '#44faa4',
                        'secondary-container':      '#00dc8a',
                        'on-secondary':             '#003920',
                        'on-secondary-container':   '#005b36',
                        'error':                    '#ffb4ab',
                        'error-container':          '#93000a',
                        'outline':                  '#8f937b',
                        'outline-variant':          '#444934',
                        'background':               '#111318',
                    },
                    fontFamily: {
                        'headline': ['Syne', 'sans-serif'],
                        'body':     ['Manrope', 'sans-serif'],
                        'data':     ['Space Grotesk', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        /* Base */
        body { font-family: 'Manrope', sans-serif; background: #111318; color: #e2e2e9; }
        .font-syne  { font-family: 'Syne', sans-serif; }
        .font-grotesk { font-family: 'Space Grotesk', sans-serif; }

        /* Material Symbols */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
            line-height: 1;
            display: inline-block;
        }
        .ms-fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        /* Kinetic gradient */
        .kinetic-gradient { background: linear-gradient(135deg, #ffffef 0%, #c8f135 100%); }

        /* Glassmorphism */
        .glass-panel {
            background: rgba(51, 53, 58, 0.4);
            backdrop-filter: blur(12px) saturate(180%);
        }

        /* Sidebar nav active pill */
        .nav-active {
            background: #c8f135;
            color: #293500;
            border-radius: 0 9999px 9999px 0;
            font-weight: 700;
            margin-right: 1rem;
            transform: translateX(2px);
        }
        .nav-inactive {
            color: #c5c9ae;
        }
        .nav-inactive:hover {
            color: #c8f135;
            background: rgba(51, 53, 58, 0.6);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #111318; }
        ::-webkit-scrollbar-thumb { background: #33353a; border-radius: 10px; }

        /* Sidebar width */
        .sidebar-w { width: 256px; min-width: 256px; }
    </style>

    @yield('styles')
</head>
<body class="antialiased selection:bg-primary-container selection:text-on-primary">

{{-- ─────────────────────────── SIDEBAR (desktop) ─────────────────────────── --}}
<aside class="hidden md:flex sidebar-w flex-col fixed inset-y-0 left-0 z-40 bg-surface-container-lowest overflow-y-auto">

    {{-- Logo area --}}
    <div class="px-6 pt-8 pb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined ms-fill text-on-primary text-xl">bolt</span>
            </div>
            <div>
                <p class="font-syne font-black text-xl text-primary-container leading-none tracking-tight">GymSathi</p>
                <p class="text-on-surface-variant text-[10px] font-medium tracking-widest uppercase mt-0.5">Member Portal</p>
            </div>
        </a>
    </div>

    {{-- Member quick-card --}}
    <div class="mx-4 mb-6 px-4 py-4 bg-surface-container-high rounded-2xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-container shrink-0">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset(Storage::url(auth()->user()->profile_picture)) }}" class="w-full h-full object-cover" alt="">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=293500&color=c8f135&size=64&bold=true" class="w-full h-full object-cover" alt="">
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-on-surface font-bold text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-on-surface-variant text-[10px] truncate font-medium">{{ auth()->user()->tenant?->name ?? 'Member' }}</p>
            </div>
            <span class="shrink-0 w-2 h-2 rounded-full bg-secondary shadow-[0_0_6px_rgba(68,250,164,0.6)]"></span>
        </div>
    </div>

    {{-- Navigation --}}
    @php
        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'match' => 'dashboard',
                'icon'  => 'grid_view',
            ],
            [
                'label' => 'My Profile',
                'route' => 'member.profile',
                'match' => 'member.profile',
                'icon'  => 'person',
            ],
            [
                'label' => 'Membership',
                'route' => 'member.membership',
                'match' => 'member.membership',
                'icon'  => 'card_membership',
            ],
            [
                'label' => 'Attendance',
                'route' => 'member.attendance',
                'match' => 'member.attendance',
                'icon'  => 'how_to_reg',
            ],
            [
                'label' => 'Support',
                'route' => 'contact-support',
                'match' => 'contact-support',
                'icon'  => 'help_center',
            ],
        ];
    @endphp

    <nav class="flex-1 space-y-0.5 py-2">
        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-6 py-3 text-sm transition-all duration-200 {{ $active ? 'nav-active' : 'nav-inactive' }}">
                <span class="material-symbols-outlined text-xl {{ $active ? 'ms-fill' : '' }}">{{ $item['icon'] }}</span>
                <span class="font-grotesk font-{{ $active ? 'bold' : 'medium' }}">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- Divider --}}
    <div class="mx-6 my-2 h-px bg-outline-variant opacity-20"></div>

    {{-- Bottom actions --}}
    <div class="p-4 space-y-3 pb-6">
        {{-- Book a Class CTA --}}
        <button class="w-full kinetic-gradient text-on-primary font-syne font-black text-xs uppercase tracking-wider py-4 rounded-2xl flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-95 transition-all shadow-lg shadow-primary-container/20">
            <span class="material-symbols-outlined ms-fill text-lg">add_circle</span>
            Book a Class
        </button>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 text-on-surface-variant hover:text-error text-xs font-medium py-2 transition-colors">
                <span class="material-symbols-outlined text-base">logout</span>
                Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ─────────────────────────── TOPBAR ─────────────────────────────────────── --}}
<header class="md:pl-64 fixed top-0 inset-x-0 z-30 h-16 bg-surface/80 backdrop-blur-xl border-b border-outline-variant/10 flex items-center px-6 gap-4">

    {{-- Mobile: hamburger --}}
    <button id="mob-menu-btn" class="md:hidden text-on-surface-variant hover:text-on-surface transition-colors p-1">
        <span class="material-symbols-outlined text-2xl">menu</span>
    </button>

    {{-- Page title (slot) or breadcrumb --}}
    <div class="flex-1 min-w-0">
        @hasSection('topbar-title')
            <h2 class="font-syne font-black text-lg text-on-surface truncate">@yield('topbar-title')</h2>
        @else
            <p class="text-on-surface-variant text-sm font-medium">
                Welcome back, <span class="text-on-surface font-bold">{{ explode(' ', auth()->user()->name)[0] }}</span>
            </p>
        @endif
    </div>

    {{-- Right: notifications + avatar --}}
    <div class="flex items-center gap-3">
        <button class="relative p-2 text-on-surface-variant hover:text-on-surface transition-colors rounded-full hover:bg-surface-container-high">
            <span class="material-symbols-outlined text-xl">notifications</span>
            {{-- Unread dot --}}
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-secondary rounded-full shadow-[0_0_6px_rgba(68,250,164,0.8)]"></span>
        </button>

        <div class="w-9 h-9 rounded-full overflow-hidden border-2 border-primary-container">
            @if(auth()->user()->profile_picture)
                <img src="{{ asset(Storage::url(auth()->user()->profile_picture)) }}" class="w-full h-full object-cover" alt="">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=293500&color=c8f135&size=64&bold=true" class="w-full h-full object-cover" alt="">
            @endif
        </div>
    </div>
</header>

{{-- ─────────────────────────── MOBILE DRAWER ──────────────────────────────── --}}
<div id="mob-overlay" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm hidden md:hidden"></div>
<aside id="mob-sidebar" class="fixed inset-y-0 left-0 z-50 sidebar-w bg-surface-container-lowest flex flex-col -translate-x-full transition-transform duration-300 md:hidden overflow-y-auto">
    {{-- same content as desktop sidebar --}}
    <div class="px-6 pt-8 pb-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined ms-fill text-on-primary text-xl">bolt</span>
            </div>
            <div>
                <p class="font-syne font-black text-xl text-primary-container leading-none">GymSathi</p>
                <p class="text-on-surface-variant text-[10px] tracking-widest uppercase mt-0.5">Member Portal</p>
            </div>
        </a>
        <button id="mob-close-btn" class="text-on-surface-variant hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="mx-4 mb-6 px-4 py-4 bg-surface-container-high rounded-2xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-container">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=293500&color=c8f135&size=64&bold=true" class="w-full h-full object-cover" alt="">
            </div>
            <div>
                <p class="text-on-surface font-bold text-sm">{{ auth()->user()->name }}</p>
                <p class="text-on-surface-variant text-[10px]">{{ auth()->user()->tenant?->name ?? 'Member' }}</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 space-y-0.5 py-2">
        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-6 py-3 text-sm transition-all duration-200 {{ $active ? 'nav-active' : 'nav-inactive' }}">
                <span class="material-symbols-outlined text-xl {{ $active ? 'ms-fill' : '' }}">{{ $item['icon'] }}</span>
                <span class="font-grotesk font-{{ $active ? 'bold' : 'medium' }}">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="p-4 pb-8 space-y-3">
        <button class="w-full kinetic-gradient text-on-primary font-syne font-black text-xs uppercase tracking-wider py-4 rounded-2xl flex items-center justify-center gap-2">
            <span class="material-symbols-outlined ms-fill text-lg">add_circle</span>
            Book a Class
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 text-on-surface-variant hover:text-error text-xs font-medium py-2 transition-colors">
                <span class="material-symbols-outlined text-base">logout</span>
                Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ─────────────────────────── MAIN CONTENT ────────────────────────────────── --}}
<div class="md:pl-64 pt-16 min-h-screen bg-surface">

    {{-- Flash messages --}}
    @if(session('success') || session('error') || session('info'))
    <div class="px-6 md:px-10 pt-6">
        @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-secondary/10 border border-secondary/30 text-secondary text-sm mb-2">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-error/10 border border-error/30 text-error text-sm mb-2">
            <span class="material-symbols-outlined text-lg">error</span>
            {{ session('error') }}
        </div>
        @endif
        @if(session('info'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-primary-container/10 border border-primary-container/30 text-primary-container text-sm mb-2">
            <span class="material-symbols-outlined text-lg">info</span>
            {{ session('info') }}
        </div>
        @endif
    </div>
    @endif

    {{-- Page content --}}
    <main class="px-6 md:px-10 py-8 pb-28 md:pb-10">
        @yield('content')
    </main>
</div>

{{-- ─────────────────────────── MOBILE BOTTOM NAV ──────────────────────────── --}}
<nav class="md:hidden fixed bottom-0 inset-x-0 z-30 bg-surface-container-lowest border-t border-outline-variant/10 flex justify-around items-center py-3 px-4">
    @php
        $mob = [
            ['r'=>'dashboard',        'i'=>'grid_view',      'l'=>'Home'],
            ['r'=>'member.membership','i'=>'card_membership', 'l'=>'Plan'],
            ['r'=>'member.attendance','i'=>'how_to_reg',      'l'=>'Check-In'],
            ['r'=>'member.profile',   'i'=>'person',          'l'=>'Profile'],
        ];
    @endphp

    @foreach($mob as $idx => $m)
        @if($idx === 2)
        {{-- Center FAB before 3rd item --}}
        <div class="-mt-8">
            <a href="{{ route('member.attendance') }}" class="w-14 h-14 kinetic-gradient rounded-full flex items-center justify-center shadow-xl shadow-primary-container/30 hover:scale-105 active:scale-95 transition-all">
                <span class="material-symbols-outlined ms-fill text-on-primary text-2xl">qr_code_scanner</span>
            </a>
        </div>
        @endif
        <a href="{{ route($m['r']) }}"
           class="flex flex-col items-center gap-1 {{ request()->routeIs($m['r']) ? 'text-primary-container' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs($m['r']) ? 'ms-fill' : '' }}">{{ $m['i'] }}</span>
            <span class="text-[9px] font-bold uppercase tracking-tight">{{ $m['l'] }}</span>
        </a>
    @endforeach
</nav>

{{-- ─────────────────────────── SCRIPTS ─────────────────────────────────────── --}}
<script>
    // Mobile sidebar toggle
    const menuBtn   = document.getElementById('mob-menu-btn');
    const closeBtn  = document.getElementById('mob-close-btn');
    const overlay   = document.getElementById('mob-overlay');
    const mobSidebar= document.getElementById('mob-sidebar');

    function openSidebar() {
        mobSidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        mobSidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    menuBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>

@yield('scripts')
</body>
</html>
