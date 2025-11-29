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

    <!-- Theme Script (must run before page render) -->
    <script>
        // Initialiser le thème avant le rendu de la page
        (function() {
            @auth
                const userTheme = '{{ auth()->user()->theme_preference ?? "system" }}';
            @else
                const userTheme = 'system';
            @endauth
            
            const savedTheme = localStorage.getItem('theme');
            let theme = savedTheme || userTheme;
            
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f5f2ee] dark:bg-gray-900 text-neutral-900 dark:text-gray-100 antialiased selection:bg-[#073066]/10 selection:text-[#073066] dark:selection:bg-blue-500/20 dark:selection:text-blue-300"
    style="font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, 'Apple Color Emoji', 'Segoe UI Emoji';">

    @auth
        @if(Auth::user()->isSuperAdmin())
            @include('layouts.super-admin-navigation')
        @else
            @include('layouts.partials.header')
        @endif
    @else
        @include('layouts.partials.header')
    @endauth

    @if(request()->routeIs('home'))
        <main>
            @yield('content')
        </main>
    @else
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            @yield('content')
        </main>
    @endif

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
                    btn.classList.add('bg-neutral-100 dark:bg-gray-700','text-neutral-900 dark:text-white');
                } else {
                    btn.classList.remove('bg-neutral-100 dark:bg-gray-700','text-neutral-900 dark:text-white');
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
                btn.classList.add('text-[#073066] dark:text-blue-400');
                icon.setAttribute('data-lucide', 'heart');
                btn.innerHTML = '<i data-lucide="heart" class="h-4 w-4 fill-[#073066] dark:fill-blue-400 text-[#073066] dark:text-blue-400"></i>';
            } else {
                btn.classList.remove('text-[#073066] dark:text-blue-400');
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
                button.classList.add('bg-white dark:bg-gray-800', 'text-neutral-700 dark:text-gray-300', 'border-neutral-200 dark:border-gray-700');
                button.innerHTML = '<i data-lucide="heart" class="h-4 w-4"></i>';
                currentLikes--;
            } else {
                // Ajouter le like
                button.classList.add('liked', 'bg-red-50', 'text-red-600', 'border-red-200');
                button.classList.remove('bg-white dark:bg-gray-800', 'text-neutral-700 dark:text-gray-300', 'border-neutral-200 dark:border-gray-700');
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

        // Fonction pour réserver un événement
        function bookEvent(eventId) {
            // Créer un formulaire dynamique pour la réservation
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/events/${eventId}/book`;
            
            // Ajouter le token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Soumettre le formulaire
            document.body.appendChild(form);
            form.submit();
        }

        // Fonction pour annuler une réservation
        function cancelBooking(eventId) {
            if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/events/${eventId}/cancel`;
                
                // Ajouter le token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken.getAttribute('content');
                    form.appendChild(csrfInput);
                }
                
                // Ajouter la méthode DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Gestion du bouton de basculement de thème
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    const html = document.documentElement;
                    const isDark = html.classList.contains('dark');
                    
                    if (isDark) {
                        // Passer en mode clair
                        html.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        updateUserThemePreference('light');
                    } else {
                        // Passer en mode sombre
                        html.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        updateUserThemePreference('dark');
                    }
                    
                    // Recréer les icônes Lucide
                    lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
                });
            }
        });

        // Fonction pour mettre à jour la préférence de thème de l'utilisateur
        function updateUserThemePreference(theme) {
            @auth
            fetch('{{ route("settings.theme") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    theme_preference: theme
                })
            }).catch(error => {
                console.error('Erreur lors de la mise à jour du thème:', error);
            });
            @endauth
        }
    </script>
    @stack('scripts')
</body>

</html>
