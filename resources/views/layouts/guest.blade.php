<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ssubsclub') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('sclublogo.png') }}">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            *, *::before, *::after {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            h1, h2, h3, h4, h5, h6, .brand-font {
                font-family: 'Plus Jakarta Sans', sans-serif !important;
                font-weight: 800;
            }
            body {
                background-color: #050506 !important;
                color: #FFFFFF !important;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-[#050506]">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>