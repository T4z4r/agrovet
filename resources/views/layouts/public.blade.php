<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AgroVet') }} - @yield('title')</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="flex items-center">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Apex Logo" class="h-10 w-auto">
                            <span class="ml-2 text-xl font-bold text-gray-900">Apex</span>
                        </a>
                    </div>
                    <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Home</a>
                        <a href="{{ route('privacy-policy.public') }}" class="text-gray-700 hover:text-gray-900">Privacy Policy</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center text-gray-500">
                    <p>&copy; {{ date('Y') }} Apex. All rights reserved.</p>
                    <p class="mt-2">Made with ❤️ by Apex Team</p>
                </div>
            </div>
        </footer>
    </body>
</html>
