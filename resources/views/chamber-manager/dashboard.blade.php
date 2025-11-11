@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                    Tableau de bord gestionnaire
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gérez vos chambres de commerce et leurs membres
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('chambers.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#073066] hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]">
                    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                    Nouvelle chambre
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Chambres -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-[#073066] rounded-md flex items-center justify-center">
                            <i data-lucide="building" class="h-5 w-5 text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Chambres gérées</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_chambers'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Membres -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-[#fcb357] rounded-md flex items-center justify-center">
                            <i data-lucide="users" class="h-5 w-5 text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total membres</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_members'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Événements -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-[#b81010] rounded-md flex items-center justify-center">
                            <i data-lucide="calendar" class="h-5 w-5 text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Événements</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_events'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-[#fcb357] rounded-md flex items-center justify-center">
                            <i data-lucide="file-text" class="h-5 w-5 text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Publications</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['total_posts'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Mes Chambres -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Mes chambres</h3>

                    @forelse($managedChambers as $chamber)
                    <div class="border border-gray-200 rounded-lg p-4 mb-4 last:mb-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $chamber->logo_path ?? 'https://ui-avatars.com/api/?name=' . urlencode($chamber->name) . '&background=073066&color=fff' }}"
                                    alt="{{ $chamber->name }}" class="h-12 w-12 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $chamber->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $chamber->location ?? 'Localisation non définie'
                                        }}</p>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            <i data-lucide="users" class="inline h-3 w-3 mr-1"></i>
                                            {{ $chamber->members_count }} membres
                                        </span>
                                        @if($chamber->verified)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#fcb357]/10 text-[#fcb357]">
                                            <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                                            Vérifiée
                                        </span>
                                        @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#b81010]/10 text-[#b81010]">
                                            <i data-lucide="clock" class="mr-1 h-3 w-3"></i>
                                            En attente
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('chambers.manage-members', $chamber) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]">
                                    <i data-lucide="users" class="mr-1 h-3 w-3"></i>
                                    Gérer
                                </a>
                                <a href="{{ route('chamber.show', $chamber) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-[#073066] hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]">
                                    <i data-lucide="eye" class="mr-1 h-3 w-3"></i>
                                    Voir
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                            <i data-lucide="building" class="h-6 w-6 text-gray-400"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Aucune chambre gérée</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Vous ne gérez actuellement aucune chambre de commerce.</p>
                        <a href="{{ route('chambers.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#073066] hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]">
                            <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                            Créer une chambre
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Membres en attente -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                        Demandes d'adhésion
                        @if($pendingMembers->count() > 0)
                        <span
                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#b81010]/10 text-[#b81010]">
                            {{ $pendingMembers->count() }}
                        </span>
                        @endif
                    </h3>

                    @forelse($pendingMembers as $member)
                    <div class="border border-gray-200 rounded-lg p-3 mb-3 last:mb-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=073066&color=fff"
                                    alt="{{ $member->name }}" class="h-8 w-8 rounded-full">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $member->chamber_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <form action="{{ route('chambers.members.approve', [$member->chamber_slug, $member->id]) }}"
                                method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-[#fcb357] hover:bg-[#f5a742] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#fcb357]">
                                    <i data-lucide="check" class="mr-1 h-3 w-3"></i>
                                    Approuver
                                </button>
                            </form>
                            <form action="{{ route('chambers.members.reject', [$member->chamber_slug, $member->id]) }}"
                                method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-2 py-1 border border-gray-300 dark:border-gray-600 dark:border-gray-400 text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#073066]">
                                    <i data-lucide="x" class="mr-1 h-3 w-3"></i>
                                    Rejeter
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <div class="mx-auto h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">
                            <i data-lucide="user-check" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Aucune demande en attente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
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
</script>
@endpush
@endsection
