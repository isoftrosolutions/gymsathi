<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tenant->name ?? config('app.name') }} | GymSathi</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            lime: '#C8F135',
                            dark: '#0C0E13',
                            surface: '#12141B',
                            border: '#1E2128'
                        },
                        on: {
                            surface: '#FFFFFF',
                            variant: '#8A8D98'
                        }
                    },
                    fontFamily: {
                        headline: ['Space Grotesk', 'sans-serif'],
                        body: ['Manrope', 'sans-serif'],
                        label: ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .kinetic-gradient { background: linear-gradient(135deg, #C8F135 0%, #AACC22 100%); }
        .sidebar-active {
            color: #C8F135;
            border-left: 4px solid #C8F135;
            background: linear-gradient(90deg, rgba(200, 241, 53, 0.05) 0%, transparent 100%);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #1E2128; border-radius: 10px; }
        body { font-family: 'Manrope', sans-serif; }
        
        /* Sidebar transitions */
        .sidebar-transition { transition: transform 0.3s ease-in-out, width 0.3s ease-in-out; }
        
        /* Mobile overlay */
        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
    </style>

    @yield('styles')
</head>
<body class="bg-primary-dark text-on-surface font-body font-medium antialiased custom-scrollbar">
    
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" 
         class="fixed inset-0 bg-black/60 z-40 sidebar-overlay opacity-0 invisible lg:hidden"
         onclick="toggleSidebar()">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" 
               class="fixed lg:relative z-50 w-64 h-full bg-black/20 border-r border-primary-border flex flex-col pt-4 shrink-0 sidebar-transition -translate-x-full lg:translate-x-0">
            
            <!-- Mobile Header -->
            <div class="lg:hidden flex items-center justify-between px-4 mb-6">
                <a href="{{ route('dashboard') }}" class="flex flex-col">
                    <span class="font-headline text-xl font-bold tracking-tighter text-primary-lime italic">GymSathi</span>
                    <span class="text-[9px] uppercase tracking-[0.2em] text-on-variant opacity-60">{{ auth()->user()->tenant?->name ?? 'Gym Portal' }}</span>
                </a>
                <button onclick="toggleSidebar()" class="p-2 text-on-variant hover:text-white transition-colors lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Desktop Logo -->
            <div class="hidden lg:block px-6 mb-8">
                <a href="{{ route('dashboard') }}" class="flex flex-col">
                    <span class="font-headline text-2xl font-bold tracking-tighter text-primary-lime italic">GymSathi</span>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-on-variant opacity-60">{{ auth()->user()->tenant?->name ?? 'Gym Portal' }}</span>
                </a>
            </div>

            <nav class="flex-1 space-y-0.5 overflow-y-auto custom-scrollbar px-2">

                @php
                    $navItems = [
                        ['route' => 'dashboard',             'label' => 'Dashboard',  'match' => 'dashboard',           'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                        ['route' => 'gym.members.index',     'label' => 'Members',    'match' => 'gym.members.*',        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                        ['route' => 'gym.attendance.index',  'label' => 'Attendance', 'match' => 'gym.attendance.*',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                        ['route' => 'gym.payments.index',    'label' => 'Payments',   'match' => 'gym.payments.*',       'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'],
                        ['route' => 'gym.packages.index',    'label' => 'Packages',   'match' => 'gym.packages.*',       'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
                        ['route' => 'gym.staff.index',       'label' => 'Staff',      'match' => 'gym.staff.*',          'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
                        ['route' => 'gym.attendance.report', 'label' => 'Reports',    'match' => 'gym.attendance.report','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                    ];
                @endphp

                @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs($item['match']) ? 'sidebar-active text-primary-lime' : 'text-on-variant hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    <span class="text-sm font-medium">{{ $item['label'] }}</span>
                </a>
                @endforeach

            </nav>

            <div class="p-4 space-y-3 border-t border-primary-border">
                <a href="{{ route('gym.members.create') }}" class="w-full kinetic-gradient text-black font-headline font-bold py-3 rounded-xl flex items-center justify-center gap-2 hover:opacity-90 transition-all text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    New Member
                </a>
                <div class="flex gap-2">
                    <a href="{{ route('support') }}" class="flex-1 flex items-center gap-2 justify-center text-on-variant hover:text-primary-lime transition-all text-xs py-2 rounded-lg hover:bg-white/5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Support
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 justify-center text-on-variant hover:text-red-400 transition-all text-xs py-2 rounded-lg hover:bg-red-500/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Topbar -->
            <header class="h-16 px-4 lg:px-6 flex items-center justify-between border-b border-primary-border bg-primary-dark/80 backdrop-blur-md sticky top-0 z-30 shrink-0">
                
                <!-- Mobile Menu Button -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-on-variant hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Breadcrumb - Hidden on mobile -->
                <nav class="hidden sm:flex items-center gap-2 text-xs text-on-variant flex-1 ml-2 lg:ml-0">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary-lime transition-colors">Dashboard</a>
                    @hasSection('breadcrumb')
                        <span>/</span>
                        @yield('breadcrumb')
                    @endif
                </nav>

                <!-- Mobile Title -->
                <div class="sm:hidden flex items-center gap-2">
                    <span class="font-headline text-lg font-bold tracking-tighter text-primary-lime italic">GymSathi</span>
                </div>

                <div class="flex items-center gap-2 lg:gap-4">
                    <!-- Notifications -->
                    <button class="p-2 text-on-variant hover:text-white transition-colors relative" title="Notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- User avatar -->
                    <div class="flex items-center gap-2 lg:gap-3">
                        <div class="hidden sm:block text-right">
                            <div class="text-xs font-bold text-white leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-on-variant leading-tight">{{ ucfirst(auth()->user()->role?->name ?? 'Admin') }}</div>
                        </div>
                        <div class="w-8 h-8 lg:w-9 lg:h-9 rounded-full border border-primary-lime/50 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C8F135&color=000&size=64"
                                 class="w-full h-full object-cover" alt="{{ auth()->user()->name }}">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash messages -->
            @if(session('success') || session('error'))
            <div class="px-4 lg:px-6 pt-4">
                @if(session('success'))
                <div class="p-3 lg:p-4 rounded-xl bg-primary-lime/10 border border-primary-lime/30 text-primary-lime text-sm flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="p-3 lg:p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
                @endif
            </div>
            @endif

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-6 xl:p-8 custom-scrollbar">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0', 'invisible');
                overlay.classList.remove('opacity-100', 'visible');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-0', 'invisible');
                overlay.classList.add('opacity-100', 'visible');
                document.body.classList.add('overflow-hidden');
            }
        }

        // Close sidebar on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('opacity-0', 'invisible');
                overlay.classList.remove('opacity-100', 'visible');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
