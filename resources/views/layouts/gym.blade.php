<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GymSathi') }} | Gym Management</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
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
                        body: ['Manrope', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        .kinetic-gradient {
            background: linear-gradient(135deg, #C8F135 0%, #AACC22 100%);
        }
        .sidebar-active {
            color: #C8F135;
            border-left: 4px solid #C8F135;
            background: linear-gradient(90deg, rgba(200, 241, 53, 0.05) 0%, transparent 100%);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1E2128;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-primary-dark text-on-surface font-body font-medium antialiased custom-scrollbar">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-black/20 border-r border-primary-border flex flex-col pt-8">
            <div class="px-8 mb-12">
                <div class="flex flex-col">
                    <span class="font-headline text-2xl font-bold tracking-tighter text-primary-lime italic">GymSathi</span>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-on-variant opacity-60">Elite Performance</span>
                </div>
            </div>

            <nav class="flex-1 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-8 py-4 transition-all {{ request()->routeIs('dashboard') ? 'sidebar-active text-primary-lime' : 'text-on-variant hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Members</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-8 py-4 text-on-variant transition-all hover:text-white hover:bg-white/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Attendance</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-8 py-4 text-on-variant transition-all hover:text-white hover:bg-white/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Payments</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-8 py-4 text-on-variant transition-all hover:text-white hover:bg-white/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Reports</span>
                </a>
            </nav>

            <div class="p-6 space-y-6">
                <button class="w-full bg-white text-black font-headline font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:opacity-90 transition-all text-sm uppercase">
                    New Registration
                </button>
                <div class="space-y-4 pt-6 border-t border-primary-border">
                    <a href="#" class="flex items-center gap-3 text-on-variant hover:text-primary-lime transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Settings
                    </a>
                    <a href="#" class="flex items-center gap-3 text-on-variant hover:text-primary-lime transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Support
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="h-20 px-8 flex items-center justify-between border-b border-primary-border bg-primary-dark/50 backdrop-blur-md sticky top-0 z-10">
                <div class="flex items-center gap-8 flex-1">
                    <div class="relative w-96 group">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-on-variant group-focus-within:text-primary-lime transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" placeholder="Search members, transactions..." class="w-full bg-white/5 border border-primary-border rounded-xl py-2.5 pl-12 pr-6 text-sm text-on-surface focus:outline-none focus:border-primary-lime transition-all">
                    </div>
                    <nav class="flex items-center gap-6 text-sm font-label">
                        <a href="{{ route('dashboard') }}" class="text-primary-lime font-bold border-b-2 border-primary-lime pb-1">Dashboard</a>
                        <a href="#" class="text-on-variant hover:text-white transition-colors">Inventory</a>
                        <a href="#" class="text-on-variant hover:text-white transition-colors">Schedule</a>
                    </nav>
                </div>

                <div class="flex items-center gap-6 pl-8">
                    <div class="flex items-center gap-4">
                        <button class="p-2 text-on-variant hover:text-white transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                        </button>
                        <button class="p-2 text-on-variant hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full border border-primary-lime p-0.5">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C8F135&color=000" class="w-full h-full rounded-full" alt="Avatar">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
