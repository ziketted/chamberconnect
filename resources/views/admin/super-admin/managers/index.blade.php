@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                    Gestion des Gestionnaires
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Promouvoir et gérer les accès des gestionnaires de chambres
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <button onclick="openPromoteModal()"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <i data-lucide="user-plus" class="h-4 w-4 mr-2"></i>
                    Promouvoir un gestionnaire
                </button>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
            <!-- Gestionnaires -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border-l-4 border-green-500">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Gestionnaires Actifs
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-green-600 dark:text-green-400">
                        {{ $stats['total_managers'] }}
                    </dd>
                </div>
            </div>

            <!-- Utilisateurs -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border-l-4 border-blue-500">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Utilisateurs Normaux
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-blue-600 dark:text-blue-400">
                        {{ $stats['total_users'] }}
                    </dd>
                </div>
            </div>

            <!-- Super Admins -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border-l-4 border-purple-500">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Super Administrateurs
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-purple-600 dark:text-purple-400">
                        {{ $stats['total_super_admins'] }}
                    </dd>
                </div>
            </div>
        </div>

        <!-- Filtres et Recherche -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" class="space-y-4 md:space-y-0 md:grid md:grid-cols-12 md:gap-x-4 md:gap-y-4 items-end">
                    
                    <!-- Recherche -->
                    <div class="md:col-span-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rechercher</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" 
                                class="focus:ring-green-500 focus:border-green-500 block w-full pl-10 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400" 
                                placeholder="Nom, email..." 
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Statut Email -->
                    <div class="md:col-span-2">
                        <label for="email_verified" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut Email</label>
                        <select name="email_verified" id="email_verified" 
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Tous</option>
                            <option value="verified" {{ request('email_verified') == 'verified' ? 'selected' : '' }}>Vérifié</option>
                            <option value="unverified" {{ request('email_verified') == 'unverified' ? 'selected' : '' }}>Non vérifié</option>
                        </select>
                    </div>

                    <!-- Chambres -->
                    <div class="md:col-span-2">
                        <label for="chambers_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Chambres</label>
                        <select name="chambers_count" id="chambers_count" 
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Toutes</option>
                            <option value="none" {{ request('chambers_count') == 'none' ? 'selected' : '' }}>Aucune</option>
                            <option value="one" {{ request('chambers_count') == 'one' ? 'selected' : '' }}>1 chambre</option>
                            <option value="multiple" {{ request('chambers_count') == 'multiple' ? 'selected' : '' }}>Plusieurs</option>
                        </select>
                    </div>

                    <!-- Tri -->
                    <div class="md:col-span-2">
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trier par</label>
                        <div class="flex space-x-2">
                            <select name="sort_by" id="sort_by" 
                                class="block w-full pl-3 pr-8 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nom</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date</option>
                            </select>
                            <button type="submit" name="sort_order" value="{{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                @if(request('sort_order') == 'desc')
                                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                                @else
                                    <i data-lucide="arrow-up" class="h-4 w-4"></i>
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="md:col-span-2 flex space-x-2">
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <i data-lucide="filter" class="h-4 w-4 mr-2"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('super-admin.managers.index') }}"
                            class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                            title="Réinitialiser">
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des gestionnaires -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Liste des Gestionnaires
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        {{ $managers->total() }}
                    </span>
                </h3>
            </div>
            
            @if($managers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Chambres Gérées
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date d'inscription
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($managers as $manager)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-sm">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($manager->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $manager->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $manager->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 w-fit">
                                        Gestionnaire
                                    </span>
                                    @if($manager->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 w-fit">
                                            <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i>
                                            Vérifié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 w-fit">
                                            <i data-lucide="alert-circle" class="h-3 w-3 mr-1"></i>
                                            Non vérifié
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white font-medium mb-1">
                                    {{ $manager->chambers->where('pivot.role', 'manager')->count() }} chambre(s)
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($manager->chambers->where('pivot.role', 'manager')->take(2) as $chamber)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ Str::limit($chamber->name, 20) }}
                                        </span>
                                    @endforeach
                                    @if($manager->chambers->where('pivot.role', 'manager')->count() > 2)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                            +{{ $manager->chambers->where('pivot.role', 'manager')->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $manager->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <button onclick="openUserDetailsModal({{ $manager->id }})" 
                                        class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" 
                                        title="Voir les détails">
                                        <i data-lucide="eye" class="h-5 w-5"></i>
                                    </button>
                                    <button onclick="openDemoteModal({{ $manager->id }}, '{{ addslashes($manager->name) }}')" 
                                        class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors" 
                                        title="Rétrograder">
                                        <i data-lucide="user-minus" class="h-5 w-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($managers->hasPages())
            <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $managers->links() }}
            </div>
            @endif

            @else
            <!-- État vide -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <i data-lucide="users" class="h-6 w-6 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun gestionnaire trouvé</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Essayez de modifier vos filtres ou ajoutez un nouveau gestionnaire.</p>
                <div class="mt-6">
                    <button onclick="openPromoteModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                        Promouvoir un gestionnaire
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de promotion -->
<div id="promoteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closePromoteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 sm:mx-0 sm:h-10 sm:w-10">
                        <i data-lucide="user-plus" class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Promouvoir un gestionnaire
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                Sélectionnez un utilisateur et une chambre pour lui attribuer les droits de gestion.
                            </p>
                            <form id="promoteForm" method="POST" action="{{ route('super-admin.managers.promote') }}">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Utilisateur
                                        </label>
                                        <select name="user_id" required
                                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                            <option value="">Sélectionner un utilisateur</option>
                                            @foreach(\App\Models\User::where('is_admin', \App\Models\User::ROLE_USER)->orderBy('name')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Chambre
                                        </label>
                                        <select name="chamber_id" required
                                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                            <option value="">Sélectionner une chambre</option>
                                            @if(isset($availableChambers))
                                                @foreach($availableChambers as $chamber)
                                                <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Chamber::where('verified', true)->orderBy('name')->get() as $chamber)
                                                <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" form="promoteForm"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Promouvoir
                </button>
                <button type="button" onclick="closePromoteModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails -->
<div id="userDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeUserDetailsModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6">
                <div class="flex justify-between items-start mb-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Détails du gestionnaire</h3>
                    <button onclick="closeUserDetailsModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i data-lucide="x" class="h-6 w-6"></i>
                    </button>
                </div>
                
                <div id="userDetailsContent" class="space-y-6">
                    <!-- Header Profile -->
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl" id="userDetailInitial">U</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white" id="userDetailName">Nom</h4>
                            <p class="text-gray-500 dark:text-gray-400" id="userDetailEmail">email@example.com</p>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200" id="userDetailRole">
                                    Gestionnaire
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="text-center">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Chambres gérées</dt>
                            <dd class="mt-1 text-2xl font-semibold text-blue-600 dark:text-blue-400" id="statChambers">0</dd>
                        </div>
                        <div class="text-center">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Membres totaux</dt>
                            <dd class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400" id="statMembers">0</dd>
                        </div>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500 dark:text-gray-400">Membre depuis</span>
                            <span class="block font-medium text-gray-900 dark:text-white" id="userDetailJoined">-</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 dark:text-gray-400">Dernière connexion</span>
                            <span class="block font-medium text-gray-900 dark:text-white" id="userDetailLastLogin">-</span>
                        </div>
                    </div>

                    <!-- Managed Chambers -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Chambres gérées</h4>
                        <div id="userDetailChambers" class="flex flex-wrap gap-2">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rétrogradation -->
<div id="demoteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDemoteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                        <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Rétrograder le gestionnaire
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Êtes-vous sûr de vouloir retirer les droits de gestionnaire à <strong id="demoteModalName" class="text-gray-900 dark:text-white"></strong> ?
                                <br><br>
                                Cette action est immédiate et l'utilisateur perdra l'accès à la gestion de ses chambres.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="demoteForm" method="POST" class="w-full sm:w-auto sm:ml-3">
                    @csrf
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                        Rétrograder
                    </button>
                </form>
                <button type="button" onclick="closeDemoteModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialisation des icônes Lucide
    lucide.createIcons();

    // Gestion des Modals
    function openPromoteModal() {
        document.getElementById('promoteModal').classList.remove('hidden');
    }

    function closePromoteModal() {
        document.getElementById('promoteModal').classList.add('hidden');
    }

    function openDemoteModal(userId, userName) {
        document.getElementById('demoteModal').classList.remove('hidden');
        document.getElementById('demoteModalName').textContent = userName;
        document.getElementById('demoteForm').action = `/super-admin/managers/${userId}/demote`;
    }

    function closeDemoteModal() {
        document.getElementById('demoteModal').classList.add('hidden');
    }

    function openUserDetailsModal(userId) {
        // Afficher un état de chargement si nécessaire
        
        fetch(`/super-admin/managers/${userId}/details`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateUserDetailsModal(data.user);
                    document.getElementById('userDetailsModal').classList.remove('hidden');
                }
            })
            .catch(error => console.error('Erreur:', error));
    }

    function closeUserDetailsModal() {
        document.getElementById('userDetailsModal').classList.add('hidden');
    }

    function populateUserDetailsModal(user) {
        document.getElementById('userDetailInitial').textContent = user.name.charAt(0).toUpperCase();
        document.getElementById('userDetailName').textContent = user.name;
        document.getElementById('userDetailEmail').textContent = user.email;
        document.getElementById('userDetailRole').textContent = user.role_text;
        document.getElementById('userDetailJoined').textContent = new Date(user.created_at).toLocaleDateString('fr-FR');
        document.getElementById('userDetailLastLogin').textContent = user.last_login ? 
            new Date(user.last_login).toLocaleDateString('fr-FR') : 'Jamais connecté';
        
        document.getElementById('statChambers').textContent = user.managed_chambers_count || 0;
        document.getElementById('statMembers').textContent = user.total_members || 0;

        const chambersContainer = document.getElementById('userDetailChambers');
        if (user.managed_chambers && user.managed_chambers.length > 0) {
            chambersContainer.innerHTML = user.managed_chambers.map(chamber => `
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    ${chamber.name}
                </span>
            `).join('');
        } else {
            chambersContainer.innerHTML = '<span class="text-gray-500 dark:text-gray-400 text-sm italic">Aucune chambre gérée</span>';
        }
    }

    // Fermeture des modals avec Echap
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closePromoteModal();
            closeDemoteModal();
            closeUserDetailsModal();
        }
    });
</script>
@endsection
