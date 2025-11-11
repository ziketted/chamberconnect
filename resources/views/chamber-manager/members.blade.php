@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('chamber-manager.dashboard') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-400">
                        <i data-lucide="home" class="flex-shrink-0 h-5 w-5"></i>
                        <span class="sr-only">Tableau de bord</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400">Gestion des membres</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="mt-4 md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                    Membres - {{ $chamber->name }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gérez les membres et leurs rôles dans cette chambre
                </p>
            </div>
            <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
                <a href="{{ route('chambers.members.create', $chamber) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#073066] hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]">
                    <i data-lucide="user-plus" class="mr-2 h-4 w-4"></i>
                    Ajouter un membre
                </a>
            </div>
        </div>
    </div>

    <!-- Messages de succès/erreur -->
    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Demandes en attente -->
    @if($pendingMembers->count() > 0)
    <div class="mb-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="clock" class="h-5 w-5 text-yellow-400"></i>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-yellow-800">
                    {{ $pendingMembers->count() }} demande(s) d'adhésion en attente
                </h3>
                <div class="mt-4 space-y-3">
                    @foreach($pendingMembers as $member)
                    <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-md p-3">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=E71D36&color=fff" 
                                 alt="{{ $member->name }}" 
                                 class="h-8 w-8 rounded-full">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $member->email }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <form action="{{ route('chambers.members.approve', [$chamber, $member]) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700">
                                    <i data-lucide="check" class="mr-1 h-3 w-3"></i>
                                    Approuver
                                </button>
                            </form>
                            <form action="{{ route('chambers.members.reject', [$chamber, $member]) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 dark:border-gray-400 text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:bg-gray-800">
                                    <i data-lucide="x" class="mr-1 h-3 w-3"></i>
                                    Rejeter
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Liste des membres -->
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                Membres actifs ({{ $members->where('pivot.status', 'approved')->count() }})
            </h3>
        </div>
        
        @if($members->where('pivot.status', 'approved')->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($members->where('pivot.status', 'approved') as $member)
            <li class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=E71D36&color=fff" 
                             alt="{{ $member->name }}" 
                             class="h-10 w-10 rounded-full">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email }}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                @if($member->pivot->role === 'manager')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        <i data-lucide="briefcase" class="mr-1 h-3 w-3"></i>
                                        Gestionnaire
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        <i data-lucide="user" class="mr-1 h-3 w-3"></i>
                                        Membre
                                    </span>
                                @endif
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Membre depuis {{ \Carbon\Carbon::parse($member->pivot->created_at)->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <!-- Dropdown pour changer le rôle -->
                        <div class="relative inline-block text-left">
                            <button type="button" 
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]"
                                    onclick="toggleDropdown('role-{{ $member->id }}')">
                                <i data-lucide="settings" class="mr-1 h-3 w-3"></i>
                                Actions
                                <i data-lucide="chevron-down" class="ml-1 h-3 w-3"></i>
                            </button>
                            
                            <div id="role-{{ $member->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-10">
                                <div class="py-1">
                                    @if($member->pivot->role !== 'manager')
                                    <form action="{{ route('chambers.members.change-role', [$chamber, $member]) }}" method="POST" class="block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="manager">
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:bg-gray-700">
                                            <i data-lucide="arrow-up" class="inline mr-2 h-3 w-3"></i>
                                            Promouvoir gestionnaire
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('chambers.members.change-role', [$chamber, $member]) }}" method="POST" class="block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="member">
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:bg-gray-700">
                                            <i data-lucide="arrow-down" class="inline mr-2 h-3 w-3"></i>
                                            Rétrograder membre
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('chambers.members.remove', [$chamber, $member]) }}" method="POST" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?')"
                                                class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                            <i data-lucide="user-minus" class="inline mr-2 h-3 w-3"></i>
                                            Retirer de la chambre
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="text-center py-12">
            <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                <i data-lucide="users" class="h-6 w-6 text-gray-400"></i>
            </div>
            <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Aucun membre actif</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Cette chambre n'a pas encore de membres approuvés.</p>
            <a href="{{ route('chambers.members.create', $chamber) }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#073066] hover:bg-[#052347]">
                <i data-lucide="user-plus" class="mr-2 h-4 w-4"></i>
                Ajouter le premier membre
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser les icônes Lucide
    lucide.createIcons({
        attrs: {
            'stroke-width': 1.5
        }
    });
});

// Fonction pour toggle les dropdowns
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const isHidden = dropdown.classList.contains('hidden');
    
    // Fermer tous les autres dropdowns
    document.querySelectorAll('[id^="role-"]').forEach(el => {
        if (el.id !== id) {
            el.classList.add('hidden');
        }
    });
    
    // Toggle le dropdown actuel
    if (isHidden) {
        dropdown.classList.remove('hidden');
    } else {
        dropdown.classList.add('hidden');
    }
}

// Fermer les dropdowns en cliquant ailleurs
document.addEventListener('click', function(e) {
    if (!e.target.closest('[onclick^="toggleDropdown"]') && !e.target.closest('[id^="role-"]')) {
        document.querySelectorAll('[id^="role-"]').forEach(el => {
            el.classList.add('hidden');
        });
    }
});
</script>
@endpush
@endsection
