<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sathi HQ | @yield('title', 'Super Admin')</title>

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
                            dark: '#111318',
                            surface: '#1A1D24',
                            border: '#2A2E37'
                        },
                        on: {
                            surface: '#FFFFFF',
                            variant: '#C5C9AE'
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
            background: rgba(200, 241, 53, 0.1);
            color: #C8F135;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2A2E37;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-primary-dark text-on-surface font-body font-medium antialiased custom-scrollbar">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 bg-black/40 border-r border-primary-border flex flex-col pt-8">
            <div class="px-8 mb-12">
                <div class="flex flex-col">
                    <span class="font-headline text-2xl font-bold tracking-tighter text-white">Sathi HQ</span>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-on-variant opacity-60">Super Admin</span>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-on-variant hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Global Overview</span>
                </a>
                <a href="{{ route('admin.tenants.index') }}" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all {{ request()->routeIs('admin.tenants.*') ? 'sidebar-active' : 'text-on-variant hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Gym Management</span>
                </a>
                <a href="{{ route('admin.subscriptions.dashboard') }}" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all {{ request()->routeIs('admin.subscriptions.*') ? 'sidebar-active' : 'text-on-variant hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Subscriptions</span>
                </a>
                <a href="{{ route('admin.support.index') }}" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all {{ request()->routeIs('admin.support.*') ? 'sidebar-active' : 'text-on-variant hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Support</span>
                </a>
                <a href="{{ route('admin.activity.index') }}" class="flex items-center gap-4 px-6 py-4 rounded-xl transition-all {{ request()->routeIs('admin.activity.*') ? 'sidebar-active' : 'text-on-variant hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Audit Logs</span>
                </a>
            </nav>

            <div class="p-4 space-y-4">
                <a href="{{ route('admin.tenants.create') }}" class="w-full kinetic-gradient text-black font-headline font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:opacity-90 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Add New Gym
                </a>
                <div class="px-4 py-6 text-on-variant space-y-4 text-sm font-label border-t border-primary-border/50">
                    <a href="{{ route('admin.support.index') }}" class="flex items-center gap-3 hover:text-primary-lime transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Help Desk
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 hover:text-primary-lime transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 bg-primary-dark">
            <!-- Topbar -->
            <header class="h-24 px-12 border-b border-primary-border flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-headline font-bold text-white">GymSathi Admin</h2>
                    <div class="flex gap-6 mt-1 text-sm font-label text-on-variant">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-primary-lime underline underline-offset-8 decoration-2' : 'hover:text-white transition-colors' }}">Dashboard</a>
                        <a href="{{ route('admin.activity.index') }}" class="{{ request()->routeIs('admin.activity.*') ? 'text-primary-lime underline underline-offset-8 decoration-2' : 'hover:text-white transition-colors' }}">Activity</a>
                        <a href="{{ route('admin.subscriptions.dashboard') }}" class="{{ request()->routeIs('admin.subscriptions.*') ? 'text-primary-lime underline underline-offset-8 decoration-2' : 'hover:text-white transition-colors' }}">Reports</a>
                    </div>
                </div>

                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-4 pr-6 border-r border-primary-border">
                        <button class="relative p-2 text-on-variant hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-primary-dark"></span>
                        </button>
                        <button class="p-2 text-on-variant hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="text-sm font-bold text-white">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-on-variant uppercase tracking-wider font-label">Platform Superuser</div>
                        </div>
                        <div class="w-12 h-12 rounded-full border-2 border-primary-lime p-1">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C8F135&color=000" class="w-full h-full rounded-full" alt="Avatar">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-12 custom-scrollbar">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
