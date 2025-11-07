@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec navigation -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.chambers.manage', $chamber) }}"
                class="text-gray-500 hover:text-gray-700 flex items-center">
                <i data-lucide="arrow-left" class="h-5 w-5 mr-2"></i>
                Retour à la gestion
            </a>
            <div class="h-6 border-l border-gray-300"></div>
            <h1 class="text-3xl font-bold text-gray-900">Assigner un gestionnaire</h1>
        </div>
        <p class="mt-2 text-gray-600">Chambre : <span class="font-medium">{{ $chamber->name }}</span></p>
    </div>

    <!-- Messages de succès/erreur -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="h-5 w-5 mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <div class="flex items-center mb-2">
            <i data-lucide="alert-circle" class="h-5 w-5 mr-2"></i>
            <span class="font-medium">Erreurs de validation :</span>
        </div>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulaire d'assignation -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i data-lucide="user-plus" class="h-6 w-6 text-purple-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-medium text-gray-900">Rechercher et assigner un gestionnaire</h2>
                <p class="text-sm text-gray-500">Tapez le nom ou l'email de l'utilisateur à promouvoir</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.chambers.assign-manager', $chamber) }}" id="assignManagerForm">
            @csrf

            <div class="space-y-6">
                <!-- Recherche d'utilisateur -->
                <div>
                    <label for="user_search" class="block text-sm font-medium text-gray-700 mb-2">
                        Rechercher un utilisateur
                    </label>
                    <div class="relative">
                        <input type="text" id="user_search"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                            placeholder="Tapez le nom ou email de l'utilisateur..." autocomplete="off">
                        <input type="hidden" name="user_id" id="selected_user_id" required>

                        <!-- Résultats de recherche -->
                        <div id="search_results"
                            class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden">
                            <!-- Les résultats seront ajoutés ici dynamiquement -->
                        </div>
                    </div>

                    <!-- Utilisateur sélectionné -->
                    <div id="selected_user" class="mt-4 hidden">
                        <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-purple-200 flex items-center justify-center">
                                    <span class="text-sm font-medium text-purple-800" id="selected_user_initial"></span>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900" id="selected_user_name"></p>
                                <p class="text-xs text-gray-500" id="selected_user_email"></p>
                            </div>
                            <button type="button" onclick="clearSelectedUser()"
                                class="ml-4 text-purple-600 hover:text-purple-800 p-1">
                                <i data-lucide="x" class="h-5 w-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Informations sur le rôle -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i data-lucide="info" class="h-5 w-5 text-blue-600 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-900">À propos du rôle de gestionnaire</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Le gestionnaire pourra gérer les membres de cette chambre</li>
                                    <li>Il aura accès au tableau de bord gestionnaire</li>
                                    <li>Il pourra approuver/rejeter les demandes d'adhésion</li>
                                    <li>Il pourra créer des événements et du contenu pour la chambre</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.chambers.manage', $chamber) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Annuler
                    </a>
                    <button type="button" id="assign_submit_btn" disabled onclick="showConfirmationModal()"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:bg-gray-300 disabled:cursor-not-allowed">
                        <i data-lucide="user-plus" class="h-4 w-4 mr-2"></i>
                        Assigner comme gestionnaire
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Gestionnaires actuels -->
    @if($chamber->members->where('pivot.role', 'manager')->count() > 0)
    <div class="mt-8 bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Gestionnaires actuels</h3>
        <div class="space-y-3">
            @foreach($chamber->members->where('pivot.role', 'manager') as $manager)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-purple-200 flex items-center justify-center">
                        <span class="text-xs font-medium text-purple-800">{{ strtoupper(substr($manager->name, 0, 1))
                            }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $manager->name }}</p>
                        <p class="text-xs text-gray-500">{{ $manager->email }}</p>
                    </div>
                </div>
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    <i data-lucide="crown" class="h-3 w-3 mr-1"></i>
                    Gestionnaire
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modal de confirmation -->
<div id="confirmationModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay sombre -->
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hideConfirmationModal()"></div>

        <!-- Centrage du modal -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Contenu du modal -->
        <div class="inline-block align-bottom bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 border border-gray-700">
            <div class="sm:flex sm:items-start">
                <!-- Icône -->
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-900 bg-opacity-50 sm:mx-0 sm:h-10 sm:w-10">
                    <i data-lucide="user-check" class="h-6 w-6 text-purple-400"></i>
                </div>
                
                <!-- Contenu -->
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                        Confirmer l'assignation
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-300">
                            Êtes-vous sûr de vouloir assigner <span id="modal-user-name" class="font-semibold text-purple-400"></span> comme gestionnaire de la chambre <span class="font-semibold text-purple-400">{{ $chamber->name }}</span> ?
                        </p>
                        <div class="mt-3 p-3 bg-gray-700 rounded-lg border border-gray-600">
                            <p class="text-xs text-gray-400 mb-2">Cette action donnera à l'utilisateur les privilèges suivants :</p>
                            <ul class="text-xs text-gray-300 space-y-1">
                                <li class="flex items-center">
                                    <i data-lucide="check" class="h-3 w-3 text-green-400 mr-2"></i>
                                    Gestion des membres de la chambre
                                </li>
                                <li class="flex items-center">
                                    <i data-lucide="check" class="h-3 w-3 text-green-400 mr-2"></i>
                                    Accès au tableau de bord gestionnaire
                                </li>
                                <li class="flex items-center">
                                    <i data-lucide="check" class="h-3 w-3 text-green-400 mr-2"></i>
                                    Création d'événements et de contenu
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="confirmAssignment()" 
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                    <i data-lucide="check" class="h-4 w-4 mr-2"></i>
                    Confirmer
                </button>
                <button type="button" onclick="hideConfirmationModal()" 
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors duration-200">
                    <i data-lucide="x" class="h-4 w-4 mr-2"></i>
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});

// Variables pour la recherche d'utilisateurs
let searchTimeout;
let currentSearchRequest;

// Recherche d'utilisateurs
document.getElementById('user_search').addEventListener('input', function(e) {
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
                resultsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-red-500">Erreur lors de la recherche</div>';
                resultsContainer.classList.remove('hidden');
            }
        });
    }, 300);
});

// Afficher les résultats de recherche
function displaySearchResults(users) {
    const resultsContainer = document.getElementById('search_results');
    
    if (users.length === 0) {
        resultsContainer.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">Aucun utilisateur trouvé</div>';
    } else {
        resultsContainer.innerHTML = users.map(user => `
            <div class="cursor-pointer select-none relative py-3 pl-4 pr-9 hover:bg-purple-50" onclick="selectUser(${user.id}, '${user.name.replace(/'/g, "\\'")}', '${user.email}')">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-xs font-medium text-gray-700">${user.name.charAt(0).toUpperCase()}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900">${user.name}</div>
                        <div class="text-xs text-gray-500">${user.email}</div>
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
    
    // Réinitialiser les icônes
    lucide.createIcons();
}

// Effacer la sélection d'utilisateur
function clearSelectedUser() {
    document.getElementById('selected_user_id').value = '';
    document.getElementById('user_search').value = '';
    document.getElementById('selected_user').classList.add('hidden');
    document.getElementById('assign_submit_btn').disabled = true;
}

// Fermer les résultats de recherche en cliquant ailleurs
document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('user_search');
    const resultsContainer = document.getElementById('search_results');
    
    if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
        resultsContainer.classList.add('hidden');
    }
});

// Fonctions pour le modal de confirmation
function showConfirmationModal() {
    const userName = document.getElementById('selected_user_name').textContent;
    const modal = document.getElementById('confirmationModal');
    const modalUserName = document.getElementById('modal-user-name');
    
    // Mettre à jour le nom de l'utilisateur dans le modal
    modalUserName.textContent = userName;
    
    // Afficher le modal
    modal.classList.remove('hidden');
    setTimeout(() => {
        lucide.createIcons(); // Réinitialiser les icônes
    }, 10);
    
    // Empêcher le scroll du body
    document.body.style.overflow = 'hidden';
}

function hideConfirmationModal() {
    const modal = document.getElementById('confirmationModal');
    
    // Cacher le modal
    modal.classList.add('hidden');
    
    // Restaurer le scroll du body
    document.body.style.overflow = 'auto';
}

function confirmAssignment() {
    // Soumettre le formulaire
    document.getElementById('assignManagerForm').submit();
}

// Fermer le modal avec la touche Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('confirmationModal');
        if (!modal.classList.contains('hidden')) {
            hideConfirmationModal();
        }
    }
});

// Validation du formulaire (garde pour la sécurité)
document.getElementById('assignManagerForm').addEventListener('submit', function(e) {
    const userId = document.getElementById('selected_user_id').value;
    if (!userId) {
        e.preventDefault();
        alert('Veuillez sélectionner un utilisateur à promouvoir gestionnaire.');
        return false;
    }
});
</script>
@endpush

@endsection