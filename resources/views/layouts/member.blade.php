<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GymSathi') }} | Leave it all on the floor</title>

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
    </style>
</head>
<body class="bg-primary-dark text-on-surface font-body font-medium antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Minimal Topbar -->
        <header class="h-20 px-12 flex items-center justify-between border-b border-white/5 bg-primary-dark/80 backdrop-blur-md sticky top-0 z-50">
            <div class="flex items-center gap-12">
                <a href="{{ route('welcome') }}" class="font-headline text-2xl font-bold tracking-tighter text-primary-lime italic">GymSathi</a>
                <nav class="hidden md:flex items-center gap-8 text-sm font-label uppercase tracking-widest text-on-variant">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-white' : 'hover:text-white transition-colors' }}">Dashboard</a>
                    <a href="#" class="hover:text-white transition-colors">Workouts</a>
                    <a href="#" class="hover:text-white transition-colors">Sessions</a>
                    <a href="#" class="hover:text-white transition-colors">Profile</a>
                </nav>
            </div>

            <div class="flex items-center gap-6">
                <button class="text-on-variant hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full border border-primary-lime p-0.5">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C8F135&color=000" class="w-full h-full rounded-full" alt="Avatar">
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-300 transition-colors uppercase">Logout</button>
                </form>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="flex-1 p-12 max-w-7xl mx-auto w-full">
            @yield('content')
        </main>
    </div>
</body>
</html>
