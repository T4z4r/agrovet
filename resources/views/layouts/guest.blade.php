<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <script>
            document.addEventListener('click', function (event) {
                const button = event.target.closest('.toggle-password');
                if (!button) {
                    return;
                }

                const input = document.getElementById(button.dataset.target);
                if (!input) {
                    return;
                }

                const icon = button.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    if (icon) {
                        icon.classList.remove('bx-hide');
                        icon.classList.add('bx-show');
                    } else {
                        button.textContent = 'Hide';
                    }
                } else {
                    input.type = 'password';
                    if (icon) {
                        icon.classList.remove('bx-show');
                        icon.classList.add('bx-hide');
                    } else {
                        button.textContent = 'Show';
                    }
                }
            });
        </script>
    </body>
</html>
