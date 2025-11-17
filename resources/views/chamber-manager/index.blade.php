@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Gestion des chambres</h1>
            <p class="text-sm text-neutral-600 dark:text-gray-400">Sélectionnez une chambre pour entrer en mode gestion.
            </p>
        </div>
    </div>

    <!-- Global stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Chambres</p>
            <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">{{ $globalStats['total_chambers'] }}
            </p>
        </div>
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Membres</p>
            <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">{{ $globalStats['total_members'] }}
            </p>
        </div>
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Demandes en attente</p>
            <p class="mt-1 text-2xl font-semibold text-amber-600 dark:text-amber-400">{{ $globalStats['total_pending']
                }}</p>
        </div>
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Événements à venir</p>
            <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">{{
                $globalStats['total_upcoming_events'] }}</p>
        </div>
    </div>

    @if($managedChambers->isEmpty())
    <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
        <p class="text-neutral-700 dark:text-gray-300">Aucune chambre à gérer pour le moment.</p>
    </div>
    @else
    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="p-4 border-b border-neutral-200 dark:border-gray-700 flex items-center justify-between">
            <div class="relative w-full max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i data-lucide="search" class="h-4 w-4 text-neutral-400"></i>
                </div>
                <input id="cm-search" type="text" placeholder="Rechercher une chambre (nom, localisation)..."
                    class="block w-full rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 pl-9 pr-3 py-2 text-sm text-neutral-900 dark:text-gray-100 placeholder:text-neutral-400 focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20 dark:focus:border-blue-500 dark:focus:ring-blue-500/20">
            </div>
        </div>
        <div class="p-0 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-gray-700 text-neutral-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">
                            <i data-lucide="image" class="h-4 w-4" title="Logo"></i>
                            <span class="sr-only">Logo</span>
                        </th>
                        <th class="px-4 py-3 text-left font-medium">
                            <i data-lucide="building-2" class="h-4 w-4" title="Nom"></i>
                            <span class="sr-only">Nom</span>
                        </th>
                        <th class="px-4 py-3 text-left font-medium">
                            <i data-lucide="map-pin" class="h-4 w-4" title="Localisation"></i>
                            <span class="sr-only">Localisation</span>
                        </th>
                        <th class="px-4 py-3 text-left font-medium">
                            <i data-lucide="users" class="h-4 w-4" title="Membres"></i>
                            <span class="sr-only">Membres</span>
                        </th>
                        <th class="px-4 py-3 text-left font-medium">
                            <i data-lucide="clock" class="h-4 w-4" title="En attente"></i>
                            <span class="sr-only">En attente</span>
                        </th>
                        <th class="px-4 py-3 text-left font-medium">
                            <i data-lucide="calendar" class="h-4 w-4" title="Événements"></i>
                            <span class="sr-only">Événements</span>
                        </th>
                        <th class="px-4 py-3 text-left font-medium w-80">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-gray-700 text-neutral-900 dark:text-gray-100">
                    @foreach($managedChambers as $c)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-gray-700/50" data-name="{{ Str::lower($c['name']) }}"
                        data-location="{{ Str::lower($c['location'] ?? '') }}">
                        <td class="px-4 py-3">
                            @if($c['logo_path'])
                            <img src="{{ Storage::url($c['logo_path']) }}" alt="{{ $c['name'] }}"
                                class="h-10 w-10 rounded-md object-cover">
                            @else
                            <div
                                class="h-10 w-10 rounded-md bg-[#073066] text-white flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($c['name'],0,1)) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $c['name'] }}</span>
                                <span class="text-xs text-neutral-500">{{ $c['slug'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $c['location'] ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $c['members_count'] }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                {{ $c['pending_members_count'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $c['events_count'] }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a href="{{ route('chamber-manager.dashboard', $c['slug']) }}"
                                    class="inline-flex h-8 items-center gap-1 rounded-md bg-[#073066] px-3 text-xs font-medium text-white hover:bg-[#052347]">
                                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('chambers.manage-members', $c['slug']) }}"
                                    class="inline-flex h-8 items-center gap-1 rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 text-xs font-medium text-neutral-800 dark:text-gray-200 hover:bg-neutral-100 dark:hover:bg-gray-700">
                                    <i data-lucide="users" class="h-4 w-4"></i>
                                    Membres
                                </a>
                                <a href="{{ route('chambers.events.create', $c['slug']) }}"
                                    class="inline-flex h-8 items-center gap-1 rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 text-xs font-medium text-neutral-800 dark:text-gray-200 hover:bg-neutral-100 dark:hover:bg-gray-700">
                                    <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                    Événement
                                </a>
                                <a href="{{ route('chambers.edit', $c['slug']) }}"
                                    class="inline-flex h-8 items-center gap-1 rounded-md bg-neutral-100 dark:bg-gray-700 px-3 text-xs font-medium text-neutral-800 dark:text-gray-200 hover:bg-neutral-200 dark:hover:bg-gray-600">
                                    <i data-lucide="settings" class="h-4 w-4"></i>
                                    Paramètres
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        const input = document.getElementById('cm-search');
        const rows = Array.from(document.querySelectorAll('tbody tr'));
        if (!input) return;
        input.addEventListener('input', () => {
            const q = input.value.trim().toLowerCase();
            rows.forEach(row => {
                const name = row.dataset.name || '';
                const loc = row.dataset.location || '';
                const show = q === '' || name.includes(q) || loc.includes(q);
                row.style.display = show ? '' : 'none';
            });
        });
    });
</script>
@endpush
{{--

@section('title', 'Gestion des chambres')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header avec style Facebook Pages -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h1 class="text-xl font-semibold text-gray-900">Gestion des chambres</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Mode gestionnaire activé</span>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Retour au profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques globales -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Chambres gérées</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $globalStats['total_chambers'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total membres</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $globalStats['total_members'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Demandes en attente</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $globalStats['total_pending'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Événements à venir</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $globalStats['total_upcoming_events']
                                    }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des chambres gérées -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Mes chambres</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Cliquez sur une chambre pour accéder aux outils de
                    gestion</p>
            </div>

            @if($managedChambers->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($managedChambers as $chamber)
                <li class="hover:bg-gray-50 transition-colors duration-150">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Logo de la chambre -->
                                <div class="flex-shrink-0 h-16 w-16">
                                    @if($chamber['logo_path'])
                                    <img class="h-16 w-16 rounded-lg object-cover"
                                        src="{{ Storage::url($chamber['logo_path']) }}" alt="{{ $chamber['name'] }}">
                                    @else
                                    <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- Informations de la chambre -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-medium text-gray-900 truncate">{{ $chamber['name'] }}</h4>
                                    <p class="text-sm text-gray-500 truncate">{{ $chamber['location'] ?? 'Localisation
                                        non spécifiée' }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            {{ $chamber['members_count'] }} membres
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $chamber['events_count'] }} événements
                                        </span>
                                        @if($chamber['pending_members_count'] > 0)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ $chamber['pending_members_count'] }} en attente
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('chamber-manager.dashboard', $chamber['slug']) }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    Tableau de bord
                                </a>

                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" type="button"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                        <div class="py-1">
                                            <a href="{{ route('chambers.manage-members', $chamber['slug']) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                Gérer les membres
                                            </a>
                                            <a href="{{ route('chambers.events.create', $chamber['slug']) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Créer un événement
                                            </a>
                                            <a href="{{ route('chambers.edit', $chamber['slug']) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Paramètres
                                            </a>
                                        </div>
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
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune chambre gérée</h3>
                <p class="mt-1 text-sm text-gray-500">Vous n'êtes gestionnaire d'aucune chambre pour le moment.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection
--}}