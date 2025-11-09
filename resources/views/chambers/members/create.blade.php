@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Add Member — {{ $chamber->name
            }}</h1>
        <p class="text-sm text-neutral-600">User must already have an account.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erreur lors de l'ajout du membre</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('chambers.members.store', $chamber) }}" method="POST"
        class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        @csrf
        
        <!-- User Search with Autocomplete -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher un utilisateur</label>
            <div class="relative">
                <input type="email" 
                       id="user-search" 
                       name="email" 
                       required
                       placeholder="Tapez l'email ou le nom de l'utilisateur..."
                       class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20"
                       autocomplete="off" />
                
                <!-- Dropdown pour les résultats -->
                <div id="search-results" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden">
                    <!-- Les résultats seront ajoutés ici par JavaScript -->
                </div>
                
                <!-- Indicateur de chargement -->
                <div id="search-loading" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                    <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Utilisateur sélectionné -->
            <div id="selected-user" class="hidden mt-3 p-3 bg-green-50 border border-green-200 rounded-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800" id="selected-user-name"></p>
                        <p class="text-sm text-green-600" id="selected-user-email"></p>
                    </div>
                    <div class="ml-auto">
                        <button type="button" id="clear-selection" class="text-green-600 hover:text-green-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Rôle dans la chambre</label>
            <select name="role" required
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20">
                <option value="member">Membre</option>
                <option value="manager">Gestionnaire</option>
            </select>
            <p class="mt-1 text-xs text-gray-500">
                Les gestionnaires peuvent gérer les membres et le contenu de la chambre.
            </p>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('chamber.show', $chamber) }}"
                class="rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium hover:bg-neutral-50">Annuler</a>
            <button type="submit" id="submit-btn" disabled
                class="rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white cursor-not-allowed">
                Ajouter le membre
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('user-search');
    const searchResults = document.getElementById('search-results');
    const searchLoading = document.getElementById('search-loading');
    const selectedUserDiv = document.getElementById('selected-user');
    const selectedUserName = document.getElementById('selected-user-name');
    const selectedUserEmail = document.getElementById('selected-user-email');
    const clearSelectionBtn = document.getElementById('clear-selection');
    const submitBtn = document.getElementById('submit-btn');
    
    let selectedUser = null;
    let searchTimeout = null;

    // Fonction pour effectuer la recherche
    function searchUsers(query) {
        if (query.length < 2) {
            hideResults();
            return;
        }

        showLoading();
        
        fetch(`{{ route('api.users.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(users => {
                hideLoading();
                displayResults(users);
            })
            .catch(error => {
                console.error('Erreur lors de la recherche:', error);
                hideLoading();
                hideResults();
            });
    }

    // Afficher les résultats
    function displayResults(users) {
        if (users.length === 0) {
            searchResults.innerHTML = `
                <div class="px-4 py-2 text-sm text-gray-500">
                    Aucun utilisateur trouvé
                </div>
            `;
        } else {
            searchResults.innerHTML = users.map(user => `
                <div class="cursor-pointer px-4 py-2 text-sm hover:bg-gray-100 user-result" 
                     data-user='${JSON.stringify(user)}'>
                    <div class="font-medium text-gray-900">${user.name}</div>
                    <div class="text-gray-500">${user.email}</div>
                </div>
            `).join('');
            
            // Ajouter les événements de clic
            document.querySelectorAll('.user-result').forEach(item => {
                item.addEventListener('click', function() {
                    const userData = JSON.parse(this.dataset.user);
                    selectUser(userData);
                });
            });
        }
        
        searchResults.classList.remove('hidden');
    }

    // Sélectionner un utilisateur
    function selectUser(user) {
        selectedUser = user;
        searchInput.value = user.email;
        selectedUserName.textContent = user.name;
        selectedUserEmail.textContent = user.email;
        
        selectedUserDiv.classList.remove('hidden');
        hideResults();
        enableSubmitButton();
    }

    // Effacer la sélection
    function clearSelection() {
        selectedUser = null;
        searchInput.value = '';
        selectedUserDiv.classList.add('hidden');
        hideResults();
        disableSubmitButton();
        searchInput.focus();
    }

    // Afficher/masquer les éléments
    function showLoading() {
        searchLoading.classList.remove('hidden');
    }

    function hideLoading() {
        searchLoading.classList.add('hidden');
    }

    function hideResults() {
        searchResults.classList.add('hidden');
    }

    function enableSubmitButton() {
        submitBtn.disabled = false;
        submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        submitBtn.classList.add('bg-[#073066]', 'hover:bg-[#052347]');
    }

    function disableSubmitButton() {
        submitBtn.disabled = true;
        submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
        submitBtn.classList.remove('bg-[#073066]', 'hover:bg-[#052347]');
    }

    // Événements
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Annuler la recherche précédente
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        // Si l'utilisateur a déjà sélectionné quelqu'un et modifie l'input
        if (selectedUser && query !== selectedUser.email) {
            clearSelection();
        }
        
        // Délai pour éviter trop de requêtes
        searchTimeout = setTimeout(() => {
            searchUsers(query);
        }, 300);
    });

    // Masquer les résultats quand on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            hideResults();
        }
    });

    // Bouton d'effacement
    clearSelectionBtn.addEventListener('click', clearSelection);

    // Gestion du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!selectedUser) {
            e.preventDefault();
            alert('Veuillez sélectionner un utilisateur dans la liste.');
            return;
        }

        // Afficher un indicateur de chargement
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Ajout en cours...
        `;
    });

    // Navigation au clavier dans les résultats
    let selectedIndex = -1;
    
    searchInput.addEventListener('keydown', function(e) {
        const results = document.querySelectorAll('.user-result');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, results.length - 1);
            updateSelection(results);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateSelection(results);
        } else if (e.key === 'Enter' && selectedIndex >= 0) {
            e.preventDefault();
            const userData = JSON.parse(results[selectedIndex].dataset.user);
            selectUser(userData);
        } else if (e.key === 'Escape') {
            hideResults();
            selectedIndex = -1;
        }
    });

    function updateSelection(results) {
        results.forEach((result, index) => {
            if (index === selectedIndex) {
                result.classList.add('bg-gray-100');
            } else {
                result.classList.remove('bg-gray-100');
            }
        });
    }
});
</script>
@endpush

@endsection


