<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GymSathi — Kinetic Gym Management for Nepal')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Space+Grotesk:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Scripts and Styles -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                "colors": {
                        "tertiary": "#fefdff",
                        "secondary-fixed": "#53ffab",
                        "tertiary-fixed": "#c5e7ff",
                        "surface-dim": "#111318",
                        "on-error": "#690005",
                        "surface-container-low": "#1a1b21",
                        "surface": "#111318",
                        "secondary-fixed-dim": "#16e28f",
                        "on-tertiary-fixed-variant": "#274b5f",
                        "surface-container-highest": "#33353a",
                        "primary-container": "#c8f135",
                        "on-secondary-container": "#005b36",
                        "surface-tint": "#aed50d",
                        "surface-container-high": "#282a2f",
                        "primary-fixed": "#c9f236",
                        "on-secondary-fixed-variant": "#005230",
                        "on-secondary": "#003920",
                        "surface-bright": "#37393f",
                        "tertiary-container": "#c2e6ff",
                        "on-primary-fixed-variant": "#3d4d00",
                        "surface-container-lowest": "#0c0e13",
                        "on-tertiary-fixed": "#001e2d",
                        "error": "#ffb4ab",
                        "surface-variant": "#33353a",
                        "outline-variant": "#444934",
                        "on-error-container": "#ffdad6",
                        "outline": "#8f937b",
                        "inverse-primary": "#526600",
                        "primary": "#ffffef",
                        "on-surface-variant": "#c5c9ae",
                        "tertiary-fixed-dim": "#a8cbe4",
                        "secondary": "#44faa4",
                        "on-surface": "#e2e2e9",
                        "background": "#111318",
                        "surface-container": "#1e1f25",
                        "secondary-container": "#00dc8a",
                        "inverse-on-surface": "#2e3036",
                        "on-secondary-fixed": "#002111",
                        "on-background": "#e2e2e9",
                        "inverse-surface": "#e2e2e9",
                        "on-primary-container": "#566c00",
                        "error-container": "#93000a",
                        "on-tertiary-container": "#45687d",
                        "on-tertiary": "#0c3447",
                        "primary-fixed-dim": "#aed50d",
                        "on-primary": "#293500",
                        "on-primary-fixed": "#171e00"
                },
                "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                },
                "fontFamily": {
                        "headline": ["Space Grotesk"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                }
              },
            },
          }
    </script>
    
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

    @yield('scripts')
</body>
</html>
