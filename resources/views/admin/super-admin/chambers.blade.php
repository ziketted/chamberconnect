@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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

        <!-- Barre de recherche et filtres améliorée -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form method="GET" action="{{ route('super-admin.chambers.index') }}" class="space-y-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
                    <!-- Recherche -->
                    <div class="flex-1 max-w-2xl">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="chamber-search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
                                placeholder="Rechercher par nom, localisation, numéro d'état...">
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="flex flex-wrap items-center gap-3">
                        <select name="filter_status" id="status-filter"
                            class="px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Tous les statuts</option>
                            <option value="certified" {{ request('filter_status') == 'certified' ? 'selected' : '' }}>Certifiées</option>
                            <option value="verified" {{ request('filter_status') == 'verified' ? 'selected' : '' }}>Vérifiées</option>
                            <option value="pending" {{ request('filter_status') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="suspended" {{ request('filter_status') == 'suspended' ? 'selected' : '' }}>Suspendues</option>
                            <option value="active" {{ request('filter_status') == 'active' ? 'selected' : '' }}>Actives</option>
                        </select>

                        <select name="sort" id="sort-filter"
                            class="px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Plus récentes</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom A-Z</option>
                            <option value="members_count" {{ request('sort') == 'members_count' ? 'selected' : '' }}>Plus de membres</option>
                            <option value="location" {{ request('sort') == 'location' ? 'selected' : '' }}>Localisation</option>
                        </select>

                        <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors flex items-center gap-2 text-sm font-medium">
                            <i data-lucide="search" class="h-4 w-4"></i>
                            Rechercher
                        </button>

                        @if(request()->hasAny(['search', 'filter_status', 'sort']))
                        <a href="{{ route('super-admin.chambers.index') }}" 
                            class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg transition-colors flex items-center gap-2 text-sm">
                            <i data-lucide="x" class="h-4 w-4"></i>
                            Effacer
                        </a>
                        @endif
                    </div>
                </div>
            </form>
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
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['certified'] ?? 0 }}</dd>
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
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['pending'] ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="pause-circle" class="h-8 w-8 text-red-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Suspendues</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['suspended'] ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des chambres - Vue tableau moderne -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @forelse($chambers as $chamber)
            @if($loop->first)
            <!-- En-tête du tableau -->
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-12 gap-4 items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    <div class="col-span-4">Chambre</div>
                    <div class="col-span-2 text-center">Statut</div>
                    <div class="col-span-2 text-center">Gestionnaires</div>
                    <div class="col-span-2 text-center">Membres</div>
                    <div class="col-span-2 text-center">Actions</div>
                </div>
            </div>
            @endif

            <!-- Ligne de chambre -->
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors duration-200 cursor-pointer"
                onclick="window.location.href='{{ route('super-admin.chambers.show-request', $chamber->id) }}'">
                <div class="grid grid-cols-12 gap-4 items-center">
                    
                    <!-- Informations de la chambre -->
                    <div class="col-span-4 flex items-center space-x-4">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            @if($chamber->logo_path)
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" 
                                     src="{{ asset('storage/' . $chamber->logo_path) }}" 
                                     alt="{{ $chamber->name }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center border-2 border-gray-200 dark:border-gray-600">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($chamber->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Détails -->
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $chamber->name }}</h3>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <i data-lucide="map-pin" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                                <span class="truncate">{{ $chamber->location ?? 'Non définie' }}</span>
                            </div>
                            @if($chamber->state_number)
                                <div class="flex items-center text-xs text-gray-400 mt-1">
                                    <i data-lucide="hash" class="h-3 w-3 mr-1 flex-shrink-0"></i>
                                    <span>{{ $chamber->state_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="col-span-2 text-center">
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
                    </div>

                    <!-- Gestionnaires -->
                    <div class="col-span-2 text-center">
                        <div class="flex items-center justify-center space-x-1">
                            <i data-lucide="users" class="h-4 w-4 text-purple-500"></i>
                            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                {{ $chamber->members->where('pivot.role', 'manager')->count() }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Gestionnaires</div>
                    </div>

                    <!-- Membres -->
                    <div class="col-span-2 text-center">
                        <div class="flex items-center justify-center space-x-1">
                            <i data-lucide="user-check" class="h-4 w-4 text-blue-500"></i>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                {{ $chamber->members->count() }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Membres</div>
                    </div>

                    <!-- Actions -->
                    <div class="col-span-2">
                        <div class="flex items-center justify-center space-x-2">
                            <!-- Voir demande -->
                            <button onclick="event.stopPropagation(); window.location.href='{{ route('super-admin.chambers.show-request', $chamber->id) }}'"
                                class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                title="Voir la demande">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                            </button>

                            <!-- Certifier (si pas encore certifiée) -->
                            @if(!$chamber->verified || !$chamber->state_number)
                            <button onclick="event.stopPropagation(); openCertificationModal('{{ $chamber->id }}')"
                                class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                                title="Certifier la chambre">
                                <i data-lucide="shield-check" class="h-4 w-4"></i>
                            </button>
                            @endif

                            <!-- Suspendre/Réactiver -->
                            @if($chamber->is_suspended)
                                <button onclick="event.stopPropagation(); confirmReactivate('{{ $chamber->id }}', '{{ $chamber->name }}')"
                                    class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                                    title="Réactiver la chambre">
                                    <i data-lucide="play-circle" class="h-4 w-4"></i>
                                </button>
                            @else
                                <button onclick="event.stopPropagation(); openSuspendModal('{{ $chamber->id }}', '{{ $chamber->name }}')"
                                    class="p-2 text-orange-600 hover:text-orange-800 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-lg transition-colors"
                                    title="Suspendre la chambre">
                                    <i data-lucide="pause-circle" class="h-4 w-4"></i>
                                </button>
                            @endif

                            <!-- Gérer -->
                            @if(Route::has('admin.chambers.manage'))
                            <button onclick="event.stopPropagation(); window.location.href='{{ route('admin.chambers.manage', $chamber) }}'"
                                class="p-2 text-purple-600 hover:text-purple-800 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors"
                                title="Gérer la chambre">
                                <i data-lucide="settings" class="h-4 w-4"></i>
                            </button>
                            @endif

                            <!-- Supprimer -->
                            <button onclick="event.stopPropagation(); confirmDelete('{{ $chamber->id }}', '{{ $chamber->name }}')"
                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                title="Supprimer la chambre">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- État vide -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i data-lucide="building" class="h-full w-full"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune chambre trouvée</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    @if(request()->hasAny(['search', 'filter_status']))
                        Aucune chambre ne correspond à vos critères de recherche.
                    @else
                        Commencez par créer une nouvelle chambre de commerce.
                    @endif
                </p>
                <div class="flex justify-center space-x-4">
                    @if(request()->hasAny(['search', 'filter_status']))
                        <a href="{{ route('super-admin.chambers.index') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i data-lucide="refresh-cw" class="h-4 w-4 mr-2"></i>
                            Voir toutes les chambres
                        </a>
                    @endif
                    <a href="{{ route('chambers.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-[#073066] hover:bg-[#052347]">
                        <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                        Créer une chambre
                    </a>
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
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeCertificationModal()"></div>

        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="certificationForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="shield-check" class="h-6 w-6 text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Certifier la chambre
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="state_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Numéro d'État *
                                    </label>
                                    <input type="text" name="state_number" id="state_number" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md shadow-sm placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        placeholder="Ex: CC-2024-001">
                                </div>

                                <div>
                                    <label for="certification_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Date de certification *
                                    </label>
                                    <input type="date" name="certification_date" id="certification_date" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Notes (optionnel)
                                    </label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md shadow-sm placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm resize-none"
                                        placeholder="Notes sur la certification..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Certifier
                    </button>
                    <button type="button" onclick="closeCertificationModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeDeleteModal()"></div>
        
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Confirmer la suppression
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Êtes-vous sûr de vouloir supprimer la chambre "<span id="deleteChamberName" class="font-semibold"></span>" ?
                                Cette action est irréversible et supprimera toutes les données associées.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmDeleteBtn"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Supprimer
                </button>
                <button type="button" onclick="closeDeleteModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
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
function openCertificationModal(chamberId) {
    const modal = document.getElementById('certificationModal');
    const form = document.getElementById('certificationForm');
    
    // Définir l'action du formulaire avec l'ID de la chambre
    form.action = `/super-admin/chambers/${chamberId}/certify`;
    
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

// Fonction pour confirmer la suppression
function confirmDelete(chamberId, chamberName) {
    const modal = document.getElementById('deleteModal');
    const nameSpan = document.getElementById('deleteChamberName');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    // Mettre à jour le nom de la chambre
    nameSpan.textContent = chamberName;
    
    // Configurer le bouton de confirmation
    confirmBtn.onclick = function() {
        // Créer un formulaire pour la suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/super-admin/chambers/${chamberId}`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Ajouter la méthode DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Soumettre le formulaire
        document.body.appendChild(form);
        form.submit();
    };
    
    // Afficher le modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Fonction pour fermer le modal de suppression
function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer les modals avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertificationModal();
        closeDeleteModal();
    }
});
</script>
@endpush

@endsection
<!-- Modal 
de suspension -->
<div id="suspendModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeSuspendModal()"></div>
        
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="suspendForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="pause-circle" class="h-6 w-6 text-orange-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Suspendre la chambre
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Vous êtes sur le point de suspendre la chambre "<span id="suspendChamberName" class="font-semibold"></span>".
                                    Cette action rendra la chambre invisible pour les utilisateurs.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label for="suspension_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Raison de la suspension *
                                </label>
                                <textarea name="suspension_reason" id="suspension_reason" rows="4" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md shadow-sm placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 sm:text-sm resize-none"
                                    placeholder="Expliquez la raison de la suspension (minimum 10 caractères)..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Suspendre
                    </button>
                    <button type="button" onclick="closeSuspendModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de réactivation -->
<div id="reactivateModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeReactivateModal()"></div>
        
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i data-lucide="play-circle" class="h-6 w-6 text-green-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Réactiver la chambre
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Êtes-vous sûr de vouloir réactiver la chambre "<span id="reactivateChamberName" class="font-semibold"></span>" ?
                                Cette action rendra la chambre à nouveau visible et accessible aux utilisateurs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmReactivateBtn"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Réactiver
                </button>
                <button type="button" onclick="closeReactivateModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fonction pour ouvrir le modal de suspension
function openSuspendModal(chamberId, chamberName) {
    const modal = document.getElementById('suspendModal');
    const form = document.getElementById('suspendForm');
    const nameSpan = document.getElementById('suspendChamberName');
    
    // Mettre à jour le nom de la chambre
    nameSpan.textContent = chamberName;
    
    // Définir l'action du formulaire
    form.action = `/super-admin/chambers/${chamberId}/suspend`;
    
    // Afficher le modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus sur le champ de raison
    setTimeout(() => {
        document.getElementById('suspension_reason').focus();
    }, 100);
}

// Fonction pour fermer le modal de suspension
function closeSuspendModal() {
    const modal = document.getElementById('suspendModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Réinitialiser le formulaire
    document.getElementById('suspendForm').reset();
}

// Fonction pour confirmer la réactivation
function confirmReactivate(chamberId, chamberName) {
    const modal = document.getElementById('reactivateModal');
    const nameSpan = document.getElementById('reactivateChamberName');
    const confirmBtn = document.getElementById('confirmReactivateBtn');
    
    // Mettre à jour le nom de la chambre
    nameSpan.textContent = chamberName;
    
    // Configurer le bouton de confirmation
    confirmBtn.onclick = function() {
        // Créer un formulaire pour la réactivation
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/super-admin/chambers/${chamberId}/reactivate`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Soumettre le formulaire
        document.body.appendChild(form);
        form.submit();
    };
    
    // Afficher le modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Fonction pour fermer le modal de réactivation
function closeReactivateModal() {
    const modal = document.getElementById('reactivateModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Mettre à jour la fonction de fermeture avec Escape pour inclure les nouveaux modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertificationModal();
        closeDeleteModal();
        closeSuspendModal();
        closeReactivateModal();
    }
});
</script>
@endpush