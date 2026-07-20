<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @PwaHead
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#6777ef">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="JCS">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-100 font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100 px-3 py-4 sm:px-6 sm:py-8">
            <div class="mb-4 sm:mb-6">
                <a href="/">
                    <x-application-logo class="h-16 w-16 fill-current text-gray-500 sm:h-20 sm:w-20" />
                </a>
            </div>

            <div class="w-full max-w-[92vw] overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:max-w-md sm:p-8">
                {{ $slot }}
            </div>
        </div>
        @RegisterServiceWorkerScript
    </body>
</html>
