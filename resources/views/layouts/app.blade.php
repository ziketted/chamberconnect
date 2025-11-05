<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ChamberConnect DRC') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-neutral-900 antialiased selection:bg-[#E71D36]/10 selection:text-[#E71D36]"
    style="font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, 'Apple Color Emoji', 'Segoe UI Emoji';">

    @include('layouts.partials.header')

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>

    @include('layouts.partials.footer')
    @include('layouts.partials.chat-widget')
    @include('layouts.partials.signin-modal')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        });

        function switchView(id) {
            document.querySelectorAll('[data-view]').forEach(s => s.classList.add('hidden'));
            const el = document.getElementById(id);
            if (el) el.classList.remove('hidden');
            setActiveToplink(id);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function setActiveToplink(id) {
            document.querySelectorAll('[data-toplink]').forEach(btn => {
                if (btn.getAttribute('data-toplink') === id) {
                    btn.classList.add('bg-neutral-100','text-neutral-900');
                } else {
                    btn.classList.remove('bg-neutral-100','text-neutral-900');
                }
            });
        }

        function openModal(id) {
            const root = document.getElementById(id);
            if (!root) return;
            root.classList.remove('invisible','pointer-events-none');
            const overlay = root.children[0];
            const panelWrap = root.children[1];
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                panelWrap.classList.remove('opacity-0','translate-y-6');
            });
        }

        function closeModal(id) {
            const root = document.getElementById(id);
            if (!root) return;
            const overlay = root.children[0];
            const panelWrap = root.children[1];
            overlay.classList.add('opacity-0');
            panelWrap.classList.add('opacity-0','translate-y-6');
            setTimeout(() => root.classList.add('invisible','pointer-events-none'), 150);
        }

        function toggleBookmark(btn) {
            const icon = btn.querySelector('i');
            const pressed = btn.getAttribute('aria-pressed') === 'true';
            btn.setAttribute('aria-pressed', String(!pressed));
            if (!pressed) {
                btn.classList.add('text-[#E71D36]');
                icon.setAttribute('data-lucide', 'heart');
                btn.innerHTML = '<i data-lucide="heart" class="h-4 w-4 fill-[#E71D36] text-[#E71D36]"></i>';
            } else {
                btn.classList.remove('text-[#E71D36]');
                btn.innerHTML = '<i data-lucide="heart" class="h-4 w-4"></i>';
            }
            lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        }
    </script>
    @stack('scripts')
</body>

</html>
