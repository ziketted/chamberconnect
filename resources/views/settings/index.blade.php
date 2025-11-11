@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Paramètres') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('Gérez vos préférences et paramètres de compte') }}</p>
        </div>

        <!-- Carte des paramètres de thème -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Apparence') }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Personnalisez l\'apparence de l\'interface') }}</p>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Thème') }}</label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Option Système -->
                        <div class="theme-option relative cursor-pointer" data-theme="system">
                            <input type="radio" name="theme_preference" value="system" 
                                   class="sr-only peer" 
                                   {{ auth()->user()->theme_preference === 'system' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-gray-200 dark:border-gray-600 dark:border-gray-400 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:border-gray-300 dark:hover:border-gray-500 dark:border-gray-600 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ __('Système') }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Suit les paramètres du système') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Option Clair -->
                        <div class="theme-option relative cursor-pointer" data-theme="light">
                            <input type="radio" name="theme_preference" value="light" 
                                   class="sr-only peer"
                                   {{ auth()->user()->theme_preference === 'light' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-gray-200 dark:border-gray-600 dark:border-gray-400 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:border-gray-300 dark:hover:border-gray-500 dark:border-gray-600 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ __('Clair') }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Thème clair permanent') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Option Sombre -->
                        <div class="theme-option relative cursor-pointer" data-theme="dark">
                            <input type="radio" name="theme_preference" value="dark" 
                                   class="sr-only peer"
                                   {{ auth()->user()->theme_preference === 'dark' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-gray-200 dark:border-gray-600 dark:border-gray-400 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 hover:border-gray-300 dark:hover:border-gray-500 dark:border-gray-600 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{ __('Sombre') }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Thème sombre permanent') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message de succès -->
        <div id="success-message" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ __('Paramètres mis à jour avec succès !') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeOptions = document.querySelectorAll('.theme-option');
    const successMessage = document.getElementById('success-message');

    themeOptions.forEach(option => {
        option.addEventListener('click', function() {
            const theme = this.dataset.theme;
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            // Mettre à jour le thème immédiatement
            updateTheme(theme);

            // Envoyer la requête au serveur
            fetch('{{ route("settings.theme") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    theme_preference: theme
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessMessage();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });

    function updateTheme(theme) {
        const html = document.documentElement;
        
        if (theme === 'dark') {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else if (theme === 'light') {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            // Système
            localStorage.removeItem('theme');
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        }
    }

    function showSuccessMessage() {
        successMessage.classList.remove('hidden');
        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 3000);
    }
});
</script>
@endsection