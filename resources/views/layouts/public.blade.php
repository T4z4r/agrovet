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
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet"
        />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    </head>
    <body>
        <!-- Header -->
        <header class="bg-white shadow-sm border-bottom">
            <div class="container-fluid">
                <div class="row align-items-center py-3">
                    <div class="col">
                        <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Apex Logo" class="h-10 me-2">
                            <span class="h4 mb-0 fw-bold text-dark">Apex</span>
                        </a>
                    </div>
                    <nav class="col-auto d-none d-md-block">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link text-secondary">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('privacy-policy.public') }}" class="nav-link text-secondary">Privacy Policy</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-top mt-5">
            <div class="container-fluid py-4">
                <div class="text-center text-muted">
                    <p>&copy; {{ date('Y') }} Apex. All rights reserved.</p>
                    <p class="mt-2">Made with ❤️ by Apex Team</p>
                </div>
            </div>
        </footer>
    </body>
</html>
