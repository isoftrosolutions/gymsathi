<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GymSathi — Kinetic Gym Management for Nepal')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Space+Grotesk:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    <style>
        .glass-card {
            background: rgba(40, 42, 47, 0.4);
            backdrop-filter: blur(12px) saturate(180%);
        }
        .kinetic-gradient {
            background: linear-gradient(135deg, #ffffef 0%, #c8f135 100%);
        }
        .text-glow {
            text-shadow: 0 0 20px rgba(200, 241, 53, 0.3);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Landing page legacy overrides */
        :root {
            --primary-lime: #c8f135;
            --on-primary-lime: #171e00;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-background text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container">
    
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')


    @include('components.chatbot-widget')

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hamburger = document.querySelector('.hamburger');
            const mobileMenu = document.querySelector('.mobile-menu');
            if (hamburger && mobileMenu) {
                hamburger.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
