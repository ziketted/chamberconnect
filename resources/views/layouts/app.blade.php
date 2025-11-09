<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ChambreRDC') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-neutral-900 antialiased selection:bg-[#073066]/10 selection:text-[#073066]"
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
                btn.classList.add('text-[#073066]');
                icon.setAttribute('data-lucide', 'heart');
                btn.innerHTML = '<i data-lucide="heart" class="h-4 w-4 fill-[#073066] text-[#073066]"></i>';
            } else {
                btn.classList.remove('text-[#073066]');
                btn.innerHTML = '<i data-lucide="heart" class="h-4 w-4"></i>';
            }
            lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        }

        // Fonction pour gérer le bouton J'aime avec compteur
        function toggleLike(button) {
            const isLiked = button.classList.contains('liked');
            const eventCard = button.closest('.event-card') || button.closest('article');
            const likesCountElement = eventCard.querySelector('.likes-count');
            let currentLikes = parseInt(likesCountElement.textContent);
            
            if (isLiked) {
                // Retirer le like
                button.classList.remove('liked', 'bg-red-50', 'text-red-600', 'border-red-200');
                button.classList.add('bg-white', 'text-neutral-700', 'border-neutral-200');
                button.innerHTML = '<i data-lucide="heart" class="h-4 w-4"></i>';
                currentLikes--;
            } else {
                // Ajouter le like
                button.classList.add('liked', 'bg-red-50', 'text-red-600', 'border-red-200');
                button.classList.remove('bg-white', 'text-neutral-700', 'border-neutral-200');
                button.innerHTML = '<i data-lucide="heart" class="h-4 w-4 fill-current"></i>';
                currentLikes++;
            }
            
            // Mettre à jour le compteur
            likesCountElement.textContent = currentLikes;
            button.setAttribute('data-likes', currentLikes);
            
            // Recréer les icônes Lucide
            lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        }
        
        // Fonction pour incrémenter les vues
        function incrementViews(button) {
            const eventCard = button.closest('.event-card') || button.closest('article');
            const viewsCountElement = eventCard.querySelector('.views-count');
            let currentViews = parseInt(viewsCountElement.textContent);
            
            // Incrémenter les vues
            currentViews++;
            viewsCountElement.textContent = currentViews;
            button.setAttribute('data-views', currentViews);
            
            // Ici vous pouvez ajouter une requête AJAX pour sauvegarder en base de données
            // fetch('/events/increment-views', { method: 'POST', ... });
        }
    </script>
    @stack('scripts')
</body>

</html>
