<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ChamberConnect') }} - SuperAdmin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-950">
        <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-950">
            @include('layouts.super-admin-navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-6 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                        <p>&copy; {{ date('Y') }} ChamberConnect. SuperAdmin Dashboard. Tous droits réservés.</p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>


