<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'GymSathi'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        @page {
            size: A4;
            margin: 14mm;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; }
        }
    </style>

    @yield('styles')
</head>
<body class="bg-[#f5f6f8] text-[#111318] font-body antialiased">
    @yield('content')
</body>
</html>

