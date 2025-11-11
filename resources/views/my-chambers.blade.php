@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mes Chambres</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Gérez vos abonnements aux chambres de commerce
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                        Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i data-lucide="building" class="h-6 w-6 text-blue-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total des chambres
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $stats['total_chambers'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i data-lucide="check-circle" class="h-6 w-6 text-green-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Chambres vérifiées
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $stats['verified_chambers'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i data-lucide="users" class="h-6 w-6 text-purple-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total des membres
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $stats['total_members'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="mb-6">
            <div class="max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input type="text" id="chambersSearch" placeholder="Rechercher une chambre..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Liste des chambres -->
        @if($userChambers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="chambersList">
            @foreach($userChambers as $chamber)
            <div class="chamber-card bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200"
                data-name="{{ strtolower($chamber->name) }}">
                <div class="p-6">
                    <!-- Header avec logo et statut -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: {{ $chamber->verified ? '#3B82F6' : '#6B7280' }}">
                                @if($chamber->logo_path)
                                <img src="{{ $chamber->logo_path }}" alt="{{ $chamber->name }}"
                                    class="w-full h-full rounded-lg object-cover">
                                @else
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr($chamber->name, 0, 2)) }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @if($chamber->verified)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                            <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                            Vérifiée
                        </span>
                        @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                            <i data-lucide="clock" class="mr-1 h-3 w-3"></i>
                            En attente
                        </span>
                        @endif
                    </div>

                    <!-- Nom et description -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ $chamber->name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                            {{ $chamber->description ?? 'Description non disponible' }}
                        </p>
                    </div>

                    <!-- Informations -->
                    <div class="space-y-2 mb-4">
                        @if($chamber->location)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i data-lucide="map-pin" class="mr-2 h-4 w-4"></i>
                            {{ $chamber->location }}
                        </div>
                        @endif
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i data-lucide="users" class="mr-2 h-4 w-4"></i>
                            {{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}
                        </div>
                        @if($chamber->state_number)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i data-lucide="shield-check" class="mr-2 h-4 w-4"></i>
                            N° État: {{ $chamber->state_number }}
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('chamber.show', $chamber) }}"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <i data-lucide="eye" class="mr-2 h-4 w-4"></i>
                            Voir
                        </a>
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800">
                            <i data-lucide="user-minus" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Message quand aucun résultat de recherche -->
        <div id="noResults" class="hidden text-center py-12">
            <div
                class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                <i data-lucide="search" class="h-6 w-6 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune chambre trouvée</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Essayez de modifier votre recherche.</p>
        </div>

        @else
        <!-- État vide -->
        <div class="text-center py-12">
            <div
                class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                <i data-lucide="building" class="h-6 w-6 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune chambre rejointe</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Vous n'avez pas encore rejoint de chambres de commerce.
            </p>
            <a href="{{ route('chambers') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                Découvrir les chambres
            </a>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('chambersSearch');
    const chamberCards = document.querySelectorAll('.chamber-card');
    const noResults = document.getElementById('noResults');
    const chambersList = document.getElementById('chambersList');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            chamberCards.forEach(card => {
                const chamberName = card.dataset.name;
                const isVisible = chamberName.includes(searchTerm);
                
                card.style.display = isVisible ? 'block' : 'none';
                if (isVisible) visibleCount++;
            });

            // Afficher/masquer le message "aucun résultat"
            if (noResults && chambersList) {
                if (visibleCount === 0 && searchTerm !== '') {
                    noResults.classList.remove('hidden');
                    chambersList.classList.add('hidden');
                } else {
                    noResults.classList.add('hidden');
                    chambersList.classList.remove('hidden');
                }
            }
        });
    }
});
</script>
@endsection