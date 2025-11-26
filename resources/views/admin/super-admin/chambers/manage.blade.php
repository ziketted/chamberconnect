@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center">
                    <!-- Logo de la chambre -->
                    @if($chamber->logo_path)
                        <img class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-lg mr-4" 
                             src="{{ asset('storage/' . $chamber->logo_path) }}" 
                             alt="{{ $chamber->name }}">
                    @else
                        <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center border-4 border-white shadow-lg mr-4">
                            <span class="text-white font-bold text-xl">{{ strtoupper(substr($chamber->name, 0, 2)) }}</span>
                        </div>
                    @endif
                    
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $chamber->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">Gestion détaillée de la chambre</p>
                        
                        <!-- Badges de statut -->
                        <div class="flex items-center space-x-2 mt-2">
                            @if($chamber->is_suspended)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <i data-lucide="pause-circle" class="h-3 w-3 mr-1"></i>
                                    Suspendue
                                </span>
                            @elseif($chamber->verified && $chamber->state_number)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i data-lucide="shield-check" class="h-3 w-3 mr-1"></i>
                                    Certifiée
                                </span>
                            @elseif($chamber->verified)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i>
                                    Vérifiée
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                    En attente
                                </span>
                            @endif
                            
                            @if($chamber->state_number)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    <i data-lucide="hash" class="h-3 w-3 mr-1"></i>
                                    {{ $chamber->state_number }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Actions rapides -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('chamber.show', $chamber) }}" target="_blank"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center">
                        <i data-lucide="external-link" class="h-4 w-4 mr-2"></i>
                        Voir publiquement
                    </a>
                    
                    @if($chamber->is_suspended)
                        <button onclick="confirmReactivate('{{ $chamber->id }}', '{{ $chamber->name }}')"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center">
                            <i data-lucide="play-circle" class="h-4 w-4 mr-2"></i>
                            Réactiver
                        </button>
                    @else
                        <button onclick="openSuspendModal('{{ $chamber->id }}', '{{ $chamber->name }}')"
                            class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-medium transition-colors flex items-center">
                            <i data-lucide="pause-circle" class="h-4 w-4 mr-2"></i>
                            Suspendre
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="users" class="h-8 w-8 text-blue-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Total Membres</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chamber->members->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="user-check" class="h-8 w-8 text-green-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Gestionnaires</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chamber->members->where('pivot.role', 'manager')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="calendar" class="h-8 w-8 text-purple-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Événements</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chamber->events->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="handshake" class="h-8 w-8 text-orange-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">Partenaires</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $chamber->partners->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informations générales -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">📋 Informations générales</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Nom</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $chamber->name }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Localisation</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $chamber->location ?? 'Non définie' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Email</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $chamber->email ?? 'Non défini' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Téléphone</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $chamber->phone ?? 'Non défini' }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Type</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                @if($chamber->type === 'national')
                                    Nationale
                                @else
                                    Bilatérale ({{ $chamber->embassy_country }})
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Date de création</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $chamber->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    @if($chamber->description)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">Description</label>
                        <div class="max-w-full">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap break-words">{{ $chamber->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Membres récents -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">👥 Membres récents</h2>
                        <span class="text-sm text-gray-500 dark:text-gray-300">{{ $chamber->members->count() }} au total</span>
                    </div>
                    
                    @if($chamber->members->count() > 0)
                        <div class="space-y-4">
                            @foreach($chamber->members->take(5) as $member)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold mr-3">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $member->pivot->role === 'manager' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200' }}">
                                        {{ $member->pivot->role === 'manager' ? 'Gestionnaire' : 'Membre' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($member->pivot->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($chamber->members->count() > 5)
                        <div class="mt-4 text-center">
                            <button class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                Voir tous les membres ({{ $chamber->members->count() - 5 }} de plus)
                            </button>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <i data-lucide="users" class="mx-auto h-12 w-12 text-gray-400 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-300">Aucun membre pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="space-y-8">
                <!-- Actions rapides -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🔧 Actions rapides</h3>
                    
                    <div class="space-y-3">
                        <button onclick="openAddManagerModal('{{ $chamber->slug }}')"
                            class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                            <i data-lucide="user-plus" class="h-4 w-4 mr-2"></i>
                            Ajouter un gestionnaire
                        </button>

                        @if(!$chamber->verified || !$chamber->state_number)
                        <button onclick="openCertificationModal('{{ $chamber->id }}')"
                            class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                            <i data-lucide="shield-check" class="h-4 w-4 mr-2"></i>
                            Certifier la chambre
                        </button>
                        @endif
                        
                        <button onclick="window.location.href='{{ route('chambers.edit', $chamber) }}'"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center justify-center">
                            <i data-lucide="edit" class="h-4 w-4 mr-2"></i>
                            Modifier les informations
                        </button>
                        
                        <button onclick="confirmDelete('{{ $chamber->id }}', '{{ $chamber->name }}')"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                            <i data-lucide="trash-2" class="h-4 w-4 mr-2"></i>
                            Supprimer la chambre
                        </button>
                    </div>
                </div>

                <!-- Informations de certification -->
                @if($chamber->state_number)
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <i data-lucide="shield-check" class="h-6 w-6 text-green-600 dark:text-green-400 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-900 dark:text-green-200">Certification</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="font-medium text-green-700 dark:text-green-300">Numéro d'état</label>
                            <p class="text-green-900 dark:text-green-200">{{ $chamber->state_number }}</p>
                        </div>
                        
                        @if($chamber->certification_date)
                        <div>
                            <label class="font-medium text-green-700 dark:text-green-300">Date de certification</label>
                            <p class="text-green-900 dark:text-green-200">{{ $chamber->certification_date->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Informations de suspension -->
                @if($chamber->is_suspended)
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <i data-lucide="pause-circle" class="h-6 w-6 text-red-600 dark:text-red-400 mr-3"></i>
                        <h3 class="text-lg font-semibold text-red-900 dark:text-red-200">Suspension</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        @if($chamber->suspended_at)
                        <div>
                            <label class="font-medium text-red-700 dark:text-red-300">Date de suspension</label>
                            <p class="text-red-900 dark:text-red-200">{{ $chamber->suspended_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @endif
                        
                        @if($chamber->suspension_reason)
                        <div>
                            <label class="font-medium text-red-700 dark:text-red-300">Raison</label>
                            <p class="text-red-900 dark:text-red-200 break-words">{{ $chamber->suspension_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Activité récente -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📈 Activité récente</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Dernière connexion</span>
                            <span class="text-gray-900 dark:text-white">{{ $chamber->updated_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Créée le</span>
                            <span class="text-gray-900 dark:text-white">{{ $chamber->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        @if($chamber->events->count() > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-300">Dernier événement</span>
                            <span class="text-gray-900 dark:text-white">{{ $chamber->events->sortByDesc('created_at')->first()->created_at->diffForHumans() }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Retour -->
        <div class="mt-8">
            <a href="{{ route('super-admin.chambers.index') }}"
                class="text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                Retour à la liste des chambres
            </a>
        </div>
    </div>
</div>

<!-- Modal d'ajout de gestionnaire -->
<div id="addManagerModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeAddManagerModal()"></div>
        
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="addManagerForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="user-plus" class="h-6 w-6 text-purple-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Ajouter un gestionnaire
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    Recherchez un utilisateur pour l'ajouter comme gestionnaire de cette chambre.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label for="user_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Rechercher un utilisateur
                                </label>
                                <div class="mt-1 relative">
                                    <input type="text" id="user_search"
                                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md shadow-sm placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                        placeholder="Tapez le nom ou email de l'utilisateur...">
                                    <input type="hidden" name="user_id" id="selected_user_id">

                                    <!-- Résultats de recherche -->
                                    <div id="search_results"
                                        class="absolute z-20 mt-1 w-full bg-white dark:bg-gray-800 shadow-xl max-h-48 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-y-auto focus:outline-none sm:text-sm hidden border border-gray-200 dark:border-gray-600">
                                        <!-- Les résultats seront ajoutés ici dynamiquement -->
                                    </div>
                                </div>

                                <!-- Utilisateur sélectionné -->
                                <div id="selected_user" class="mt-3 hidden">
                                    <div class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-purple-200 dark:bg-purple-700 flex items-center justify-center">
                                                <span class="text-sm font-medium text-purple-800 dark:text-purple-200" id="selected_user_initial"></span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="selected_user_name"></p>
                                            <p class="text-xs text-gray-600 dark:text-gray-300" id="selected_user_email"></p>
                                        </div>
                                        <button type="button" onclick="clearSelectedUser()"
                                            class="ml-auto text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                            <i data-lucide="x" class="h-4 w-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" id="add_manager_submit_btn" disabled
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm disabled:bg-gray-300 dark:disabled:bg-gray-600 disabled:cursor-not-allowed">
                        Ajouter comme gestionnaire
                    </button>
                    <button type="button" onclick="closeAddManagerModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
    
    // Recherche d'utilisateurs
    const userSearchInput = document.getElementById('user_search');
    if (userSearchInput) {
        userSearchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            const resultsContainer = document.getElementById('search_results');
            
            // Annuler la recherche précédente
            if (window.currentSearchRequest) {
                window.currentSearchRequest.abort();
            }
            
            // Effacer le timeout précédent
            clearTimeout(window.searchTimeout);
            
            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }
            
            // Délai pour éviter trop de requêtes
            window.searchTimeout = setTimeout(() => {
                // Créer une nouvelle requête
                window.currentSearchRequest = new AbortController();
                
                fetch(`/api/users/search?q=${encodeURIComponent(query)}`, {
                    signal: window.currentSearchRequest.signal
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

// Fonctions pour les modals
function openCertificationModal(chamberId) {
    window.location.href = `/super-admin/chambers/${chamberId}/request`;
}

function openSuspendModal(chamberId, chamberName) {
    window.location.href = `/super-admin/chambers?suspend=${chamberId}`;
}

function confirmReactivate(chamberId, chamberName) {
    if (confirm(`Êtes-vous sûr de vouloir réactiver la chambre "${chamberName}" ?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/super-admin/chambers/${chamberId}/reactivate`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function confirmDelete(chamberId, chamberName) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer définitivement la chambre "${chamberName}" ? Cette action est irréversible.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/super-admin/chambers/${chamberId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function openAddManagerModal(chamberSlug) {
    const modal = document.getElementById('addManagerModal');
    const form = document.getElementById('addManagerForm');
    
    form.action = `/admin/chambers/${chamberSlug}/assign-manager`;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
        document.getElementById('user_search').focus();
    }, 100);
}

function closeAddManagerModal() {
    const modal = document.getElementById('addManagerModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    document.getElementById('addManagerForm').reset();
    clearSelectedUser();
}

function displaySearchResults(users) {
    const resultsContainer = document.getElementById('search_results');
    
    if (users.length === 0) {
        resultsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">Aucun utilisateur trouvé</div>';
    } else {
        resultsContainer.innerHTML = users.map(user => `
            <div class="cursor-pointer select-none relative py-3 px-4 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors" onclick="selectUser(${user.id}, '${user.name.replace(/'/g, "\\'")}', '${user.email}')">
                <div class="flex items-center min-w-0">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-600 flex items-center justify-center">
                            <span class="text-sm font-medium text-white">${user.name.charAt(0).toUpperCase()}</span>
                        </div>
                    </div>
                    <div class="ml-3 min-w-0 flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">${user.name}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-300 truncate">${user.email}</div>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    resultsContainer.classList.remove('hidden');
}

function selectUser(userId, userName, userEmail) {
    document.getElementById('selected_user_id').value = userId;
    document.getElementById('selected_user_name').textContent = userName;
    document.getElementById('selected_user_email').textContent = userEmail;
    document.getElementById('selected_user_initial').textContent = userName.charAt(0).toUpperCase();
    
    document.getElementById('search_results').classList.add('hidden');
    document.getElementById('selected_user').classList.remove('hidden');
    document.getElementById('user_search').value = userName;
    document.getElementById('add_manager_submit_btn').disabled = false;
}

function clearSelectedUser() {
    document.getElementById('selected_user_id').value = '';
    document.getElementById('selected_user').classList.add('hidden');
    document.getElementById('user_search').value = '';
    document.getElementById('add_manager_submit_btn').disabled = true;
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAddManagerModal();
    }
});
</script>
@endpush

@endsection