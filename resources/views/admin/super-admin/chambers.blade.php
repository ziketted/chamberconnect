@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestion des Chambres</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Gérez toutes les chambres de commerce et leurs paramètres</p>
            </div>
            <a href="{{ route('chambers.create') }}"
                class="bg-[#073066] text-white px-4 py-2 rounded-lg hover:bg-[#052347] transition-colors flex items-center">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Créer une chambre
            </a>
        </div>

        <!-- Barre de recherche et filtres -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 p-6">
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-4">
                <!-- Recherche -->
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input type="text" id="chamber-search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:border-gray-400 rounded-md leading-5 bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Rechercher une chambre par nom, localisation...">
                    </div>
                </div>

                <!-- Filtres -->
                <div class="flex items-center space-x-4">
                    <select id="status-filter"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:border-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Tous les statuts</option>
                        <option value="certified">Certifiées</option>
                        <option value="pending">En attente</option>
                        <option value="suspended">Suspendues</option>
                    </select>

                    <select id="sort-filter"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:border-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="name">Trier par nom</option>
                        <option value="created_at">Plus récentes</option>
                        <option value="members_count">Plus de membres</option>
                        <option value="location">Par localisation</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="building" class="h-8 w-8 text-blue-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Chambres</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chambers->total() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="shield-check" class="h-8 w-8 text-green-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Certifiées</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chambers->where('verified', true)->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="clock" class="h-8 w-8 text-yellow-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">En attente</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chambers->where('verified', false)->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="users" class="h-8 w-8 text-purple-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Membres</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chambers->sum(function($chamber) { return
                            $chamber->members->count(); }) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Chambres Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($chambers as $chamber)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 cursor-pointer chamber-card relative"
            data-chamber-id="{{ $chamber->id }}"
            onclick="window.location.href='{{ route('admin.chambers.manage', $chamber) }}'">

            <!-- Header de la carte -->
            <div class="relative">
                @if($chamber->cover_image_path)
                <!-- Image avec overlay dégradé pour améliorer la lisibilité -->
                <div class="relative overflow-hidden rounded-t-lg">
                    <img class="w-full h-32 object-cover" src="{{ asset('storage/' . $chamber->cover_image_path) }}"
                        alt="{{ $chamber->name }}">
                    <!-- Dégradé overlay pour améliorer la lisibilité du badge et créer une séparation -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-black/10"></div>
                    <!-- Bordure inférieure pour séparer de la zone blanche -->
                    <div
                        class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent">
                    </div>
                </div>
                @else
                <!-- Fallback avec dégradé et icône maison -->
                <div
                    class="w-full h-32 bg-gradient-to-r from-gray-400 to-gray-600 rounded-t-lg flex items-center justify-start pl-6 overflow-hidden">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white dark:bg-gray-800 bg-opacity-20 rounded-full p-2">
                            <i data-lucide="home" class="h-6 w-6 text-white"></i>
                        </div>
                        <div class="text-white">
                            <h4 class="text-sm font-semibold truncate max-w-32">{{ $chamber->name }}</h4>
                            <p class="text-gray-200 text-xs truncate max-w-32">{{ $chamber->location ?? 'Non définie' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Statut badge avec meilleur contraste -->
                <div class="absolute top-3 right-3 z-10">
                    @if($chamber->verified && $chamber->state_number)
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600 text-white shadow-lg border border-green-500">
                        <i data-lucide="shield-check" class="h-3 w-3 mr-1"></i>
                        Certifiée
                    </span>
                    @else
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500 text-white shadow-lg border border-yellow-400">
                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                        En attente
                    </span>
                    @endif
                </div>
            </div>

            <!-- Logo positionné au niveau de la carte (pas du header) pour éviter l'overflow -->
            <div class="absolute top-24 left-6 z-20">
                @if($chamber->logo_path)
                <img class="h-12 w-12 rounded-full border-4 border-white shadow-xl object-cover"
                    src="{{ asset('storage/' . $chamber->logo_path) }}" alt="{{ $chamber->name }}">
                @else
                <div
                    class="h-12 w-12 rounded-full border-4 border-white shadow-xl bg-white dark:bg-gray-800 flex items-center justify-center">
                    <div class="text-center">
                        <i data-lucide="building-2" class="h-4 w-4 text-gray-600 dark:text-gray-400 mx-auto mb-0.5"></i>
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-bold">{{ strtoupper(substr($chamber->name, 0, 2))
                            }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Contenu de la carte -->
            <div class="pt-8 pb-6 px-6 relative">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $chamber->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                        <i data-lucide="map-pin" class="h-4 w-4 mr-1"></i>
                        {{ $chamber->location ?? 'Localisation non définie' }}
                    </p>
                    @if($chamber->state_number)
                    <p class="text-xs text-gray-400 mt-1">N° État: {{ $chamber->state_number }}</p>
                    @endif
                </div>

                <!-- Statistiques -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $chamber->members->count() }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Membres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $chamber->members->where('pivot.role',
                            'manager')->count() }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Gestionnaires</div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <div class="flex space-x-2">
                        @if(!$chamber->verified || !$chamber->state_number)
                        <button onclick="event.stopPropagation(); openCertificationModal('{{ $chamber->slug }}')"
                            class="text-green-600 hover:text-green-800 p-1 rounded">
                            <i data-lucide="shield-check" class="h-4 w-4"></i>
                        </button>
                        @endif

                        <a href="{{ route('chamber.show', $chamber) }}" onclick="event.stopPropagation()"
                            class="text-blue-600 hover:text-blue-800 p-1 rounded">
                            <i data-lucide="external-link" class="h-4 w-4"></i>
                        </a>
                    </div>

                    <span class="text-xs text-gray-400">
                        Cliquez pour gérer
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <i data-lucide="building" class="mx-auto h-12 w-12 text-gray-400"></i>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Aucune chambre</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Commencez par créer une nouvelle chambre de commerce.</p>
                <div class="mt-6">
                    <a href="{{ route('chambers.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#073066] hover:bg-[#052347]">
                        <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                        Créer une chambre
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($chambers->hasPages())
    <div class="mt-8">
        {{ $chambers->links() }}
    </div>
    @endif
</div>



<!-- Modal de certification -->
<div id="certificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-50 dark:bg-gray-8000 bg-opacity-75" onclick="closeCertificationModal()">
        </div>

        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="certificationForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="shield-check" class="h-6 w-6 text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Certifier la chambre
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="state_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Numéro d'État *
                                    </label>
                                    <input type="text" name="state_number" id="state_number" required
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:border-gray-400 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        placeholder="Ex: CC-2024-001">
                                </div>

                                <div>
                                    <label for="certification_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Date de certification *
                                    </label>
                                    <input type="date" name="certification_date" id="certification_date" required
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:border-gray-400 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Notes (optionnel)
                                    </label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:border-gray-400 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        placeholder="Notes sur la certification..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Certifier
                    </button>
                    <button type="button" onclick="closeCertificationModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'assignation de gestionnaire -->
<div id="assignManagerModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-50 dark:bg-gray-8000 bg-opacity-75" onclick="closeAssignManagerModal()">
        </div>

        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="assignManagerForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="user-plus" class="h-6 w-6 text-purple-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Assigner un gestionnaire
                            </h3>
                            <div class="mt-4">
                                <label for="user_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Rechercher un utilisateur
                                </label>
                                <div class="mt-1 relative">
                                    <input type="text" id="user_search"
                                        class="block w-full border-gray-300 dark:border-gray-600 dark:border-gray-400 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                        placeholder="Tapez le nom ou email de l'utilisateur...">
                                    <input type="hidden" name="user_id" id="selected_user_id">

                                    <!-- Résultats de recherche -->
                                    <div id="search_results"
                                        class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden">
                                        <!-- Les résultats seront ajoutés ici dynamiquement -->
                                    </div>
                                </div>

                                <!-- Utilisateur sélectionné -->
                                <div id="selected_user" class="mt-3 hidden">
                                    <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-8 w-8 rounded-full bg-purple-200 flex items-center justify-center">
                                                <span class="text-sm font-medium text-purple-800"
                                                    id="selected_user_initial"></span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white" id="selected_user_name"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" id="selected_user_email"></p>
                                        </div>
                                        <button type="button" onclick="clearSelectedUser()"
                                            class="ml-auto text-purple-600 hover:text-purple-800">
                                            <i data-lucide="x" class="h-4 w-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" id="assign_submit_btn" disabled
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm disabled:bg-gray-300 dark:bg-gray-600 disabled:cursor-not-allowed">
                        Assigner
                    </button>
                    <button type="button" onclick="closeAssignManagerModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les icônes Lucide
    lucide.createIcons();
});

// Fonction pour ouvrir le modal de certification
function openCertificationModal(chamberSlug) {
    const modal = document.getElementById('certificationModal');
    const form = document.getElementById('certificationForm');
    
    // Définir l'action du formulaire
    form.action = `/admin/chambers/${chamberSlug}/certify`;
    
    // Afficher le modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus sur le premier champ
    setTimeout(() => {
        document.getElementById('state_number').focus();
    }, 100);
}

// Fonction pour fermer le modal de certification
function closeCertificationModal() {
    const modal = document.getElementById('certificationModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Réinitialiser le formulaire
    document.getElementById('certificationForm').reset();
}

// Fonction pour ouvrir le modal d'assignation de gestionnaire
function openAssignManagerModal(chamberId) {
    const modal = document.getElementById('assignManagerModal');
    const form = document.getElementById('assignManagerForm');
    
    // Définir l'action du formulaire
    form.action = `/admin/chambers/${chamberId}/assign-manager`;
    
    // Afficher le modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus sur le champ de recherche
    setTimeout(() => {
        document.getElementById('user_search').focus();
    }, 100);
}

// Fonction pour fermer le modal d'assignation de gestionnaire
function closeAssignManagerModal() {
    const modal = document.getElementById('assignManagerModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Réinitialiser le formulaire
    document.getElementById('assignManagerForm').reset();
    clearSelectedUser();
}

// Variables pour la recherche d'utilisateurs
let searchTimeout;
let currentSearchRequest;

// Recherche d'utilisateurs
document.addEventListener('DOMContentLoaded', function() {
    const userSearchInput = document.getElementById('user_search');
    if (userSearchInput) {
        userSearchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            const resultsContainer = document.getElementById('search_results');
            
            // Annuler la recherche précédente
            if (currentSearchRequest) {
                currentSearchRequest.abort();
            }
            
            // Effacer le timeout précédent
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }
            
            // Délai pour éviter trop de requêtes
            searchTimeout = setTimeout(() => {
                // Créer une nouvelle requête
                currentSearchRequest = new AbortController();
                
                fetch(`/api/users/search?q=${encodeURIComponent(query)}`, {
                    signal: currentSearchRequest.signal
                })
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    if (error.name !== 'AbortError') {
                        console.error('Erreur de recherche:', error);
                    }
                });
            }, 300);
        });
    }
});

// Afficher les résultats de recherche
function displaySearchResults(users) {
    const resultsContainer = document.getElementById('search_results');
    
    if (users.length === 0) {
        resultsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">Aucun utilisateur trouvé</div>';
    } else {
        resultsContainer.innerHTML = users.map(user => `
            <div class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-purple-50" onclick="selectUser(${user.id}, '${user.name}', '${user.email}')">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-6 w-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">${user.name.charAt(0).toUpperCase()}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${user.name}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${user.email}</div>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    resultsContainer.classList.remove('hidden');
}

// Sélectionner un utilisateur
function selectUser(userId, userName, userEmail) {
    document.getElementById('selected_user_id').value = userId;
    document.getElementById('user_search').value = userName;
    document.getElementById('selected_user_name').textContent = userName;
    document.getElementById('selected_user_email').textContent = userEmail;
    document.getElementById('selected_user_initial').textContent = userName.charAt(0).toUpperCase();
    
    document.getElementById('selected_user').classList.remove('hidden');
    document.getElementById('search_results').classList.add('hidden');
    document.getElementById('assign_submit_btn').disabled = false;
}

// Effacer la sélection d'utilisateur
function clearSelectedUser() {
    document.getElementById('selected_user_id').value = '';
    document.getElementById('user_search').value = '';
    document.getElementById('selected_user').classList.add('hidden');
    document.getElementById('assign_submit_btn').disabled = true;
}

// Fermer les modals avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertificationModal();
        closeAssignManagerModal();
    }
});

// Fermer les résultats de recherche en cliquant ailleurs
document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('user_search');
    const resultsContainer = document.getElementById('search_results');
    
    if (searchInput && resultsContainer && !searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
        resultsContainer.classList.add('hidden');
    }
});

// Fonctionnalité de recherche et filtrage des chambres
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('chamber-search');
    const statusFilter = document.getElementById('status-filter');
    const sortFilter = document.getElementById('sort-filter');
    const chamberCards = document.querySelectorAll('.chamber-card');

    // Fonction de recherche et filtrage
    function filterChambers() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const sortValue = sortFilter.value;

        let visibleCards = [];

        chamberCards.forEach(card => {
            const chamberName = card.querySelector('h3').textContent.toLowerCase();
            const chamberLocation = card.querySelector('.text-gray-500 dark:text-gray-400').textContent.toLowerCase();
            const statusBadge = card.querySelector('.inline-flex');
            const isCertified = statusBadge && statusBadge.textContent.includes('Certifiée');
            const isPending = statusBadge && statusBadge.textContent.includes('En attente');

            // Filtrage par recherche
            const matchesSearch = chamberName.includes(searchTerm) || chamberLocation.includes(searchTerm);

            // Filtrage par statut
            let matchesStatus = true;
            if (statusValue === 'certified') {
                matchesStatus = isCertified;
            } else if (statusValue === 'pending') {
                matchesStatus = isPending;
            }

            // Afficher/masquer la carte
            if (matchesSearch && matchesStatus) {
                card.style.display = 'block';
                visibleCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        // Tri des cartes visibles
        if (sortValue && visibleCards.length > 0) {
            const container = visibleCards[0].parentNode;
            
            visibleCards.sort((a, b) => {
                if (sortValue === 'name') {
                    const nameA = a.querySelector('h3').textContent;
                    const nameB = b.querySelector('h3').textContent;
                    return nameA.localeCompare(nameB);
                } else if (sortValue === 'members_count') {
                    const membersA = parseInt(a.querySelector('.text-blue-600').textContent);
                    const membersB = parseInt(b.querySelector('.text-blue-600').textContent);
                    return membersB - membersA; // Ordre décroissant
                } else if (sortValue === 'location') {
                    const locationA = a.querySelector('.text-gray-500 dark:text-gray-400').textContent;
                    const locationB = b.querySelector('.text-gray-500 dark:text-gray-400').textContent;
                    return locationA.localeCompare(locationB);
                }
                return 0;
            });

            // Réorganiser les cartes dans le DOM
            visibleCards.forEach(card => {
                container.appendChild(card);
            });
        }

        // Afficher un message si aucune chambre trouvée
        updateEmptyState(visibleCards.length === 0);
    }

    // Fonction pour afficher/masquer le message d'état vide
    function updateEmptyState(isEmpty) {
        let emptyState = document.getElementById('empty-search-state');
        
        if (isEmpty && !emptyState) {
            // Créer le message d'état vide
            emptyState = document.createElement('div');
            emptyState.id = 'empty-search-state';
            emptyState.className = 'col-span-full text-center py-12';
            emptyState.innerHTML = `
                <i data-lucide="search-x" class="mx-auto h-12 w-12 text-gray-400 mb-4"></i>
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Aucune chambre trouvée</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Essayez de modifier vos critères de recherche.</p>
                <button onclick="clearFilters()" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200">
                    <i data-lucide="x" class="h-4 w-4 mr-2"></i>
                    Effacer les filtres
                </button>
            `;
            
            const container = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
            container.appendChild(emptyState);
            
            // Réinitialiser les icônes
            setTimeout(() => lucide.createIcons(), 10);
        } else if (!isEmpty && emptyState) {
            emptyState.remove();
        }
    }

    // Fonction pour effacer tous les filtres
    window.clearFilters = function() {
        searchInput.value = '';
        statusFilter.value = '';
        sortFilter.value = 'name';
        filterChambers();
    };

    // Écouteurs d'événements
    searchInput.addEventListener('input', filterChambers);
    statusFilter.addEventListener('change', filterChambers);
    sortFilter.addEventListener('change', filterChambers);

    // Animation de focus sur la barre de recherche
    searchInput.addEventListener('focus', function() {
        this.parentElement.classList.add('ring-2', 'ring-blue-500');
    });

    searchInput.addEventListener('blur', function() {
        this.parentElement.classList.remove('ring-2', 'ring-blue-500');
    });
});
</script>
@endpush

@endsection
