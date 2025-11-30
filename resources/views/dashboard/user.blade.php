@extends('layouts.app')

@push('styles')
<style>
/* Animation du card profil */
.profile-card-animation {
    animation: slideInDown 0.6s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Effet hover sur les statistiques */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Bordure dégradée pour le header */
.profile-header {
    position: relative;
}

.profile-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
}

/* Badge de status pour la photo de profil */
.profile-avatar {
    position: relative;
    transition: transform 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
}

.profile-avatar::after {
    content: '';
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border: 3px solid white;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

/* Animation des icônes */
.stat-icon {
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Effet glassmorphism sur les stats */
.stat-glass {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Animation du séparateur */
.separator-animated {
    background: linear-gradient(90deg, transparent, currentColor 20%, currentColor 80%, transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0%, 100% {
        opacity: 0.5;
    }
    50% {
        opacity: 1;
    }
}

/* Effet pulse sur le bouton */
@keyframes pulse-shadow {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(37, 99, 235, 0);
    }
}

.profile-edit-btn:hover {
    animation: pulse-shadow 1.5s infinite;
}

/* Responsive text truncate avec tooltip */
.truncate-with-tooltip {
    position: relative;
}

.truncate-with-tooltip:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 0;
    background: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    white-space: nowrap;
    z-index: 10;
}
</style>
@endpush

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar Gauche - Mes Chambres -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Card Profil & Statistiques -->
            <div class="profile-card-animation rounded-xl border border-neutral-200 dark:border-gray-700 bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/10 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                <!-- Header avec dégradé -->
                <div class="profile-header h-20 bg-gradient-to-r from-[#2563eb] to-[#1e40af] relative">
                    <div class="absolute -bottom-10 left-4">
                        @if($user->avatar || $user->profile_photo_path)
                            <div class="profile-avatar">
                                <img src="{{ asset('storage/' . ($user->avatar ?? $user->profile_photo_path)) }}" 
                                     alt="{{ $user->name }}"
                                     class="w-20 h-20 rounded-full border-4 border-white dark:border-gray-800 object-cover shadow-lg">
                            </div>
                        @else
                            <div class="profile-avatar w-20 h-20 rounded-full border-4 border-white dark:border-gray-800 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">
                                    {{ substr($user->name, 0, 1) }}{{ substr(explode(' ', $user->name)[1] ?? $user->name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Informations utilisateur -->
                <div class="pt-12 px-4 pb-4">
                    <div class="mb-4">
                        <h2 class="text-base font-semibold text-gray-900 dark:text-white truncate" title="{{ $user->name }}">
                            {{ $user->name }}
                        </h2>
                        <div class="flex items-center gap-1.5 text-xs text-neutral-600 dark:text-gray-400 mt-1.5 group">
                            <i data-lucide="mail" class="h-3.5 w-3.5 flex-shrink-0 group-hover:text-blue-500 transition-colors"></i>
                            <span class="truncate" title="{{ $user->email }}">{{ $user->email }}</span>
                        </div>
                        @if($user->company)
                        <div class="flex items-center gap-1.5 text-xs text-neutral-600 dark:text-gray-400 mt-1.5 group">
                            <i data-lucide="building-2" class="h-3.5 w-3.5 flex-shrink-0 group-hover:text-blue-500 transition-colors"></i>
                            <span class="truncate" title="{{ $user->company }}">{{ $user->company }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Séparateur animé -->
                    <div class="h-px separator-animated bg-gradient-to-r from-transparent via-neutral-300 dark:via-gray-600 to-transparent mb-4"></div>
                    
                    <!-- Statistiques avec animation -->
                    <div class="space-y-2.5">
                        <a href="{{ route('my-chambers') }}" class="stat-card stat-glass flex items-center justify-between p-3 rounded-lg bg-white/50 dark:bg-gray-700/30 border border-neutral-100 dark:border-gray-600/50 hover:bg-white dark:hover:bg-gray-700/50 hover:border-blue-200 dark:hover:border-blue-500 cursor-pointer group">
                            <div class="flex items-center gap-2.5">
                                <div class="stat-icon w-9 h-9 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center group-hover:scale-110">
                                    <i data-lucide="building" class="h-4 w-4 text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Chambres rejointes</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $userChambersCount }}</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 text-neutral-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('events.my-bookings') }}" class="stat-card stat-glass flex items-center justify-between p-3 rounded-lg bg-white/50 dark:bg-gray-700/30 border border-neutral-100 dark:border-gray-600/50 hover:bg-white dark:hover:bg-gray-700/50 hover:border-green-200 dark:hover:border-green-500 cursor-pointer group">
                            <div class="flex items-center gap-2.5">
                                <div class="stat-icon w-9 h-9 rounded-lg bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/30 dark:to-green-800/20 flex items-center justify-center group-hover:scale-110">
                                    <i data-lucide="calendar-check" class="h-4 w-4 text-green-600 dark:text-green-400"></i>
                                </div>
                                <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Événements participés</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent">{{ $participatedEventsCount }}</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 text-neutral-400 dark:text-gray-500 group-hover:text-green-600 dark:group-hover:text-green-400 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Taux de Change -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Taux de Change</h2>
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xs text-neutral-600 dark:text-gray-400 mb-4">Devises vers CDF</p>

                <div id="exchange-rates-loading" class="space-y-3">
                    <div class="animate-pulse">
                        <div class="h-10 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    </div>
                    <div class="animate-pulse">
                        <div class="h-10 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    </div>
                </div>

                <div id="exchange-rates-content" class="space-y-3 hidden">
                    <!-- USD -->
                    <div
                        class="flex items-center justify-between p-3 rounded-lg bg-neutral-50 dark:bg-gray-700/50 border border-neutral-100 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <span class="text-xs font-bold text-green-600 dark:text-green-400">$</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">1 USD</span>
                        </div>
                        <span id="rate-usd" class="text-sm font-semibold text-gray-900 dark:text-white">-</span>
                    </div>

                    <!-- EUR -->
                    <div
                        class="flex items-center justify-between p-3 rounded-lg bg-neutral-50 dark:bg-gray-700/50 border border-neutral-100 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <span class="text-xs font-bold text-blue-600 dark:text-blue-400">€</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">1 EUR</span>
                        </div>
                        <span id="rate-eur" class="text-sm font-semibold text-gray-900 dark:text-white">-</span>
                    </div>
                </div>

                <div id="exchange-rates-error" class="hidden text-center py-3">
                    <p class="text-xs text-red-500 dark:text-red-400">Erreur de chargement</p>
                </div>

                <div class="mt-3 pt-3 border-t border-neutral-200 dark:border-gray-700">
                    <p class="text-xs text-neutral-500 dark:text-gray-500 text-center" id="last-update">
                        Mise à jour en cours...
                    </p>
                </div>
            </div>

        </div>
    </aside>

    <!-- Contenu Principal -->
    <main class="lg:col-span-6">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-semibold">Mes Événements</h1>
                </div>
            </div>
            <div class="relative">
                <span
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 dark:text-gray-500 dark:text-gray-400">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </span>
                <input type="text" id="events-search"
                    placeholder="Rechercher des événements, chambres, organisateurs..."
                    class="w-full rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-4 py-3 text-sm text-neutral-800 dark:text-gray-100 placeholder:text-neutral-400 dark:text-gray-500 dark:text-gray-400 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
            </div>
        </div>

        <!-- Filtres rapides -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <span class="text-sm font-medium text-neutral-700 dark:text-gray-300">Filtres rapides:</span>
            <button data-filter="type" data-value="forum"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="users" class="h-3 w-3 mr-1"></i>
                Forum
            </button>
            <button data-filter="type" data-value="networking"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="network" class="h-3 w-3 mr-1"></i>
                Networking
            </button>
            <button data-filter="type" data-value="conference"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="presentation" class="h-3 w-3 mr-1"></i>
                Conférence
            </button>
            <button data-filter="type" data-value="meeting"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="calendar" class="h-3 w-3 mr-1"></i>
                Meeting
            </button>
            <button data-filter="verified" data-value="true"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="shield-check" class="h-3 w-3 mr-1"></i>
                Chambres agréées
            </button>
            <button data-filter="available" data-value="true"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="calendar-check" class="h-3 w-3 mr-1"></i>
                Places disponibles
            </button>
            <button id="clear-filters" data-filter="clear"
                class="filter-btn inline-flex items-center rounded-full bg-red-100 dark:bg-red-900/30 px-3 py-1 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                style="display: none;">
                <i data-lucide="x" class="h-3 w-3 mr-1"></i>
                Effacer filtres
            </button>
        </div>

        <!-- Skeleton loading pour les événements -->
        <div id="events-skeleton" class="space-y-4" style="display: none;">
            @for($i = 0; $i
            < 3; $i++) <x-skeleton.event-card />
            @endfor
        </div>

        <div id="events-container" class="space-y-4">
            @foreach($allEvents->take(6) as $event)
            <x-event-card :event="$event" />
            @endforeach

            @if(false) {{-- Code ancien conservé pour référence --}}
            @foreach($allEvents->take(6) as $eventOld)
            <div class="event-card group rounded-2xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden hover:shadow-lg hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300"
                data-type="{{ $event['type'] }}" data-verified="{{ $event['is_user_chamber'] ? 'true' : 'false' }}"
                data-available="{{ $event['status'] !== 'complet' ? 'true' : 'false' }}"
                data-title="{{ strtolower($event['title']) }}"
                data-description="{{ strtolower($event['description'] ?? '') }}"
                data-chamber="{{ strtolower($event['chamber_name']) }}"
                data-date="{{ $event['full_date']->format('Y-m-d') }}" data-participants="{{ $event['participants'] }}"
                data-max-participants="{{ $event['max_participants'] ?? 0 }}">

                <div class="p-6">
                    <!-- En-tête avec chambre et badge -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg">
                                <span class="text-sm font-bold text-white">{{ strtoupper(substr($event['chamber_name'],
                                    0, 2)) }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{
                                    $event['chamber_name'] }}</span>
                                @if($event['is_user_chamber'])
                                <div class="flex items-center gap-1 mt-0.5">
                                    <i data-lucide="star" class="h-3 w-3 text-amber-500"></i>
                                    <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Ma
                                        chambre</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Badge de statut -->
                        @if($event['status'] === 'complet')
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-500/20 text-red-300 text-xs font-medium border border-red-500/30">
                            <i data-lucide="users-x" class="h-3 w-3"></i>
                            Complet
                        </span>
                        @elseif($event['max_participants'] && ($event['max_participants'] - $event['participants']) <=
                            5) <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-orange-500/20 text-orange-300 text-xs font-medium border border-orange-500/30">
                            <i data-lucide="clock" class="h-3 w-3"></i>
                            {{ $event['max_participants'] - $event['participants'] }} places
                            </span>
                            @endif
                    </div>

                    <!-- Titre de l'événement -->
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">{{ $event['title'] }}
                    </h3>

                    <!-- Informations en grille -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <i data-lucide="calendar" class="h-4 w-4 text-blue-500 dark:text-blue-400"></i>
                            <span>{{ $event['date'] }} à {{ $event['time'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <i data-lucide="map-pin" class="h-4 w-4 text-blue-500 dark:text-blue-400"></i>
                            <span>{{ $event['location'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <i data-lucide="users" class="h-4 w-4 text-blue-500 dark:text-blue-400"></i>
                            <span>{{ $event['participants'] }}/{{ $event['max_participants'] }} participants</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <i data-lucide="tag" class="h-4 w-4 text-blue-500 dark:text-blue-400"></i>
                            <span>{{ ucfirst($event['type']) }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($event['description'])
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">{{
                        Str::limit($event['description'], 120) }}
                    </p>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <!-- Bouton like -->

                            <span class="text-xs font-medium like-count">Event: Sponsorisé</span>

                        </div>

                        <div class="flex items-center gap-3">
                            @if($event['status'] === 'complet')
                            <button disabled
                                class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 text-sm font-medium cursor-not-allowed border border-gray-300 dark:border-gray-600">
                                <i data-lucide="users-x" class="h-4 w-4 mr-2 inline"></i>
                                Complet
                            </button>
                            @else
                            @auth
                            @if(isset($event['is_booked']) && $event['is_booked'])
                            <!-- Utilisateur déjà inscrit -->
                            <div class="flex items-center gap-2">
                                @if(isset($event['booking_status']) && $event['booking_status'] === 'reserved')
                                <form action="{{ route('events.confirm', $event['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors shadow-lg">
                                        <i data-lucide="check" class="h-4 w-4 mr-2 inline"></i>
                                        Confirmer
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('events.cancel', $event['id']) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg border border-red-300 dark:border-red-600 bg-white dark:bg-gray-800 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 text-sm font-medium transition-colors">
                                        <i data-lucide="x" class="h-4 w-4 mr-2 inline"></i>
                                        Annuler
                                    </button>
                                </form>
                            </div>
                            @else
                            <!-- Utilisateur non inscrit -->
                            <form action="{{ route('events.book', $event['id']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors shadow-lg">
                                    <i data-lucide="calendar-plus" class="h-4 w-4 mr-2 inline"></i>
                                    Réserver place
                                </button>
                            </form>
                            @endif
                            @else
                            <button onclick="alert('Veuillez vous connecter pour réserver une place')"
                                class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors shadow-lg">
                                <i data-lucide="calendar-plus" class="h-4 w-4 mr-2 inline"></i>
                                Réserver place
                            </button>
                            @endauth
                            @endif

                            <button onclick="viewEventDetails('{{ $event['id'] }}')"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm font-medium transition-colors">
                                <i data-lucide="eye" class="h-4 w-4 mr-2 inline"></i>
                                Voir plus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif {{-- Fin du code ancien --}}

            <!-- Message si aucun événement -->
            @if($allEvents->isEmpty())
            <div class="text-center py-12">
                <div
                    class="flex h-16 w-16 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
                    <i data-lucide="calendar-x" class="h-8 w-8"></i>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun événement disponible</h3>
                <p class="text-sm text-neutral-600 dark:text-gray-400 mb-6">Rejoignez des chambres de commerce pour
                    découvrir des événements exclusifs.</p>
                <a href="{{ route('chambers') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#073066] px-4 py-2 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
                    <i data-lucide="building" class="h-4 w-4"></i>
                    Découvrir les chambres
                </a>
            </div>
            @endif
        </div>

        <!-- Bouton Charger plus -->
        @if($allEvents->count() > 6)
        <div class="text-center mt-8">
            <button id="load-more-events"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-lg"
                data-page="2">
                <i data-lucide="plus-circle" class="h-5 w-5"></i>
                <span>Charger plus d'événements</span>
            </button>
        </div>
        @endif

        <!-- Loading spinner pour le lazy loading -->
        <div id="loading-spinner" class="text-center mt-8" style="display: none;">
            <div
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-medium rounded-lg">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                <span>Chargement...</span>
            </div>
        </div>
    </main>

    <!-- Sidebar Droite -->
    <aside class="lg:col-span-3">
        <div class="space-y-4">
            <!-- Section Chambres Suggérées -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-green-600 dark:text-green-400">Chambres Suggérées</h2>
                        <span
                            class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-600 dark:text-green-400">
                            {{ $suggestedChambers->count() }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Chambres dont vous n'êtes pas encore
                        membre</p>
                </div>
                <div class="p-4 space-y-4">
                    @if($suggestedChambers->count() > 0)
                    @foreach($suggestedChambers->take(3) as $chamber)
                    <div
                        class="group relative rounded-xl border border-neutral-100 dark:border-gray-600 p-4 hover:border-green-200 dark:hover:border-green-500 hover:shadow-md transition-all duration-200 bg-gradient-to-br from-white to-green-50/30 dark:from-gray-800 dark:to-green-900/10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="flex-shrink-0">
                                @if($chamber->logo_path)
                                <img src="{{ asset('storage/' . $chamber->logo_path) }}" alt="{{ $chamber->name }}"
                                    class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                @else
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                    {{ strtoupper(substr($chamber->name, 0, 2)) }}
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors truncate">
                                    {{ $chamber->name }}
                                </h4>
                                @if($chamber->location)
                                <p class="text-xs text-neutral-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="h-3 w-3"></i>
                                    {{ Str::limit($chamber->location, 20) }}
                                </p>
                                @endif
                            </div>
                            @if($chamber->verified)
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-medium">
                                    <i data-lucide="shield-check" class="h-3 w-3"></i>
                                </span>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span
                                class="inline-flex items-center gap-1 text-xs text-neutral-600 dark:text-gray-400 bg-white dark:bg-gray-700 px-2 py-1 rounded-full">
                                <i data-lucide="users" class="h-3 w-3"></i>
                                {{ $chamber->members_count }}
                            </span>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('chambers.members.join', $chamber) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition-colors shadow-sm">
                                        <i data-lucide="plus" class="h-3 w-3"></i>
                                        Rejoindre
                                    </button>
                                </form>
                                <a href="{{ route('chamber.show', $chamber) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 text-xs font-medium transition-colors">
                                    <i data-lucide="eye" class="h-3 w-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($suggestedChambers->count() > 3)
                    <div class="text-center py-2">
                        <p class="text-xs text-neutral-500 dark:text-gray-400">
                            +{{ $suggestedChambers->count() - 3 }} autres chambres disponibles
                        </p>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-8">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
                            <i data-lucide="building-2" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Toutes les chambres rejointes
                        </h3>
                        <p class="text-xs text-neutral-600 dark:text-gray-400 mb-4">Vous êtes membre de toutes les
                            chambres disponibles.</p>
                    </div>
                    @endif

                    <div class="pt-3 border-t border-neutral-200 dark:border-gray-700">
                        <a href="{{ route('chambers') }}"
                            class="inline-flex items-center gap-2 w-full justify-center rounded-md bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700 transition-colors">
                            <i data-lucide="building-2" class="h-3 w-3"></i>
                            Voir toutes les chambres
                        </a>
                    </div>
                </div>
            </div>

            <!-- Section Investir en RDC -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <h2 class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $investmentInfo['title'] }}
                    </h2>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">{{ $investmentInfo['description'] }}</p>
                </div>
                <div class="p-4 space-y-4">
                    @foreach($investmentInfo['steps'] as $step)
                    <div class="flex items-start gap-3">
                        <div
                            class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-semibold">
                            {{ $step['number'] }}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $step['title'] }}</h4>
                            <p class="text-xs text-neutral-600 dark:text-gray-400 mt-1">{{ $step['description'] }}</p>
                        </div>
                    </div>
                    @endforeach

                    <div class="pt-3 border-t border-neutral-200 dark:border-gray-700">
                        <a href="{{ route('opportunities') }}"
                            class="inline-flex items-center gap-2 w-full justify-center rounded-md border border-blue-600 px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                            <i data-lucide="external-link" class="h-3 w-3"></i>
                            Découvrir les opportunités
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </aside>

</div>

<!-- Modal pour les détails de l'événement -->
<div id="event-details-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80 transition-opacity"
            aria-hidden="true" onclick="closeEventModal()"></div>

        <!-- Centrage du modal -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Contenu du modal -->
        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Header avec image de couverture -->
            <div class="relative h-64 sm:h-80 overflow-hidden">
                <img id="modal-cover-image" src="" alt="" class="w-full h-full object-cover">
                <div id="modal-default-cover"
                    class="hidden w-full h-full relative bg-gradient-to-r from-slate-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <!-- Contenu centré -->
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <div id="modal-chamber-logo"
                                class="w-20 h-20 mx-auto mb-4 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg">
                                <span id="modal-chamber-initials" class="text-2xl font-bold text-white"></span>
                            </div>
                            <h3 id="modal-chamber-name" class="text-xl font-semibold text-gray-900 dark:text-white">
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Événement professionnel</p>
                        </div>
                    </div>
                </div>

                <!-- Bouton fermer -->
                <button onclick="closeEventModal()"
                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/50 hover:bg-black/70 text-white flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>

                <!-- Badge de statut -->
                <div id="modal-status-badge" class="absolute top-4 left-4"></div>
            </div>

            <!-- Contenu principal -->
            <div class="px-6 py-6">
                <!-- En-tête avec chambre -->
                <div class="flex items-center gap-4 mb-6">
                    <div id="modal-chamber-avatar"
                        class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center">
                        <span id="modal-chamber-avatar-text" class="text-white font-semibold text-sm"></span>
                    </div>
                    <div>
                        <h4 id="modal-chamber-title" class="font-semibold text-gray-900 dark:text-white"></h4>
                        <div id="modal-chamber-verified" class="hidden flex items-center gap-1 mt-1">
                            <i data-lucide="shield-check" class="h-3 w-3 text-amber-500"></i>
                            <span class="text-xs text-amber-600 dark:text-amber-400">Chambre vérifiée</span>
                        </div>
                    </div>
                </div>

                <!-- Titre de l'événement -->
                <h2 id="modal-event-title" class="text-2xl font-bold text-gray-900 dark:text-white mb-4"></h2>

                <!-- Informations principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i data-lucide="calendar" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Date et heure</p>
                                <p id="modal-event-datetime" class="font-semibold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i data-lucide="map-pin" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Lieu</p>
                                <p id="modal-event-location" class="font-semibold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i data-lucide="tag" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Type d'événement</p>
                                <p id="modal-event-type" class="font-semibold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i data-lucide="users" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Participants</p>
                                <p id="modal-event-participants" class="font-semibold text-gray-900 dark:text-white">
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i data-lucide="dollar-sign" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Prix</p>
                                <p id="modal-event-price" class="font-semibold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>

                        <div id="modal-event-mode-container" class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i id="modal-event-mode-icon" data-lucide="monitor"
                                    class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Mode</p>
                                <p id="modal-event-mode" class="font-semibold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Description</h3>
                    <div id="modal-event-description"
                        class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300"></div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <button id="modal-like-btn" onclick="toggleModalLike()"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                            <i data-lucide="heart" class="h-4 w-4"></i>
                            <span class="text-sm font-medium">J'aime</span>
                            <span id="modal-likes-count"
                                class="text-xs bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full ml-1 font-medium">0</span>
                        </button>

                        <button onclick="shareEvent()"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                            <i data-lucide="share-2" class="h-4 w-4"></i>
                            <span class="text-sm font-medium">Partager</span>
                        </button>
                    </div>

                    <div id="modal-event-actions" class="flex items-center gap-3">
                        <!-- Les boutons d'action seront ajoutés dynamiquement -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Style pour les boutons like */
    .like-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    /* Style par défaut - gris */
    .like-btn {
        color: #6b7280 !important;
        border-color: #d1d5db !important;
        background-color: transparent !important;
    }

    /* Style au hover - rouge */
    .like-btn:hover {
        color: #ef4444 !important;
        border-color: #f87171 !important;
        background-color: rgba(254, 226, 226, 0.5) !important;
    }

    /* Style quand liké - rouge permanent mais plus subtil */
    .like-btn.liked {
        color: #dc2626 !important;
        border-color: #dc2626 !important;
        background-color: rgba(254, 226, 226, 0.3) !important;
    }

    .like-btn.liked:hover {
        color: #ef4444 !important;
        border-color: #f87171 !important;
        background-color: rgba(254, 226, 226, 0.6) !important;
    }

    /* Animation pour le bouton like */
    .like-btn:active {
        transform: scale(0.95);
    }

    /* Style pour le modal */
    #modal-like-btn {
        transition: all 0.2s ease;
    }

    #modal-like-btn:hover {
        background-color: rgba(254, 226, 226, 0.5) !important;
        color: #ef4444 !important;
    }

    /* Dark mode adjustments */
    .dark .like-btn {
        color: #9ca3af !important;
        border-color: #4b5563 !important;
    }

    .dark .like-btn:hover {
        color: #ef4444 !important;
        border-color: #f87171 !important;
        background-color: rgba(127, 29, 29, 0.3) !important;
    }

    .dark .like-btn.liked {
        color: #f87171 !important;
        border-color: #f87171 !important;
        background-color: rgba(127, 29, 29, 0.2) !important;
    }

    .dark .like-btn.liked:hover {
        background-color: rgba(127, 29, 29, 0.4) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const eventsSearch = document.getElementById('events-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const eventCards = document.querySelectorAll('.event-card');
    let activeFilters = {};

    // Fonction de recherche d'événements
    if (eventsSearch) {
        eventsSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            filterEvents();
        });
    }

    // Gestion des filtres rapides
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterType = this.dataset.filter;
            const filterValue = this.dataset.value;

            if (filterType === 'clear') {
                // Effacer tous les filtres
                activeFilters = {};
                eventsSearch.value = '';
                updateFilterButtons();
                filterEvents();
                return;
            }

            // Toggle du filtre
            if (activeFilters[filterType] === filterValue) {
                delete activeFilters[filterType];
            } else {
                activeFilters[filterType] = filterValue;
            }

            updateFilterButtons();
            filterEvents();
        });
    });

    // Mise à jour de l'apparence des boutons de filtre
    function updateFilterButtons() {
        filterButtons.forEach(button => {
            const filterType = button.dataset.filter;
            const filterValue = button.dataset.value;

            if (filterType === 'clear') return;

            if (activeFilters[filterType] === filterValue) {
                button.classList.remove('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
                button.classList.add('bg-blue-600', 'text-white');
            } else {
                button.classList.remove('bg-blue-600', 'text-white');
                button.classList.add('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
            }
        });

        // Afficher/masquer le bouton "Effacer filtres"
        const hasActiveFilters = Object.keys(activeFilters).length > 0 || eventsSearch.value.trim() !== '';
        clearFiltersBtn.style.display = hasActiveFilters ? 'inline-flex' : 'none';
    }

    // Fonction de filtrage des événements
    function filterEvents() {
        const searchTerm = eventsSearch ? eventsSearch.value.toLowerCase().trim() : '';
        let visibleCount = 0;

        eventCards.forEach(card => {
            let isVisible = true;

            // Filtre de recherche textuelle
            if (searchTerm) {
                const title = card.dataset.title || '';
                const description = card.dataset.description || '';
                const chamber = card.dataset.chamber || '';

                const matchesSearch = title.includes(searchTerm) ||
                                    description.includes(searchTerm) ||
                                    chamber.includes(searchTerm);

                if (!matchesSearch) {
                    isVisible = false;
                }
            }

            // Filtres par type
            if (activeFilters.type && card.dataset.type !== activeFilters.type) {
                isVisible = false;
            }

            // Filtre chambres vérifiées
            if (activeFilters.verified === 'true' && card.dataset.verified !== 'true') {
                isVisible = false;
            }

            // Filtre places disponibles
            if (activeFilters.available === 'true' && card.dataset.available !== 'true') {
                isVisible = false;
            }

            // Appliquer la visibilité
            card.style.display = isVisible ? 'block' : 'none';
            if (isVisible) visibleCount++;
        });

        // Afficher un message si aucun résultat
        showNoResultsMessage(visibleCount === 0 && (searchTerm || Object.keys(activeFilters).length > 0));
    }

    // Afficher/masquer le message "aucun résultat"
    function showNoResultsMessage(show) {
        let noResultsDiv = document.getElementById('no-results-message');

        if (show && !noResultsDiv) {
            noResultsDiv = document.createElement('div');
            noResultsDiv.id = 'no-results-message';
            noResultsDiv.className = 'text-center py-12';
            noResultsDiv.innerHTML = `
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
                    <i data-lucide="search-x" class="h-8 w-8"></i>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun événement trouvé</h3>
                <p class="text-sm text-neutral-600 dark:text-gray-400">Essayez de modifier vos critères de recherche ou filtres.</p>
            `;

            const eventsContainer = document.getElementById('events-container');
            if (eventsContainer) {
                eventsContainer.appendChild(noResultsDiv);
            }
        } else if (!show && noResultsDiv) {
            noResultsDiv.remove();
        }
    }

    // Initialiser l'état des filtres
    updateFilterButtons();
});

// Fonction pour le bouton "J'aime"
function toggleLike(button, eventId) {
    const icon = button.querySelector('i[data-lucide="heart"]');
    const likeCountElement = button.querySelector('.like-count');
    const isLiked = button.classList.contains('liked');

    // Désactiver le bouton temporairement
    button.disabled = true;

    // Faire l'appel AJAX
    fetch(`/events/${eventId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour l'interface
        if (data.liked) {
            button.classList.add('liked');
            icon.classList.add('fill-current');
            icon.style.fill = 'currentColor';
        } else {
            button.classList.remove('liked');
            icon.classList.remove('fill-current');
            icon.style.fill = '';
        }

        // Mettre à jour le compteur
        if (likeCountElement) {
            likeCountElement.textContent = data.likes_count;
        }

        // Animation du bouton
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 150);

        // Réinitialiser les icônes Lucide
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    })
    .catch(error => {
        console.error('Erreur lors du like:', error);
        showNotification('Erreur lors de l\'action. Veuillez réessayer.', 'error');
    })
    .finally(() => {
        // Réactiver le bouton
        button.disabled = false;
    });
}

// Fonction pour voir les détails d'un événement
function viewEventDetails(eventId) {
    // Trouver l'événement dans la liste
    const eventCard = document.querySelector(`[onclick="viewEventDetails('${eventId}')"]`).closest('.event-card');

    if (!eventCard) return;

    // Extraire les données de l'événement
    const likeButton = eventCard.querySelector('.like-btn');
    const likesCount = likeButton ? likeButton.querySelector('.like-count').textContent.trim() : '0';
    const isLiked = likeButton ? likeButton.classList.contains('liked') : false;

    const eventData = {
        id: eventId,
        title: eventCard.querySelector('h3').textContent.trim(),
        type: eventCard.dataset.type,
        chamber_name: eventCard.querySelector('.text-sm.font-semibold').textContent.trim(),
        chamber_initials: eventCard.querySelector('.w-10.h-10 span').textContent.trim(),
        is_user_chamber: eventCard.dataset.verified === 'true',
        date: eventCard.querySelector('[data-lucide="calendar"]').nextElementSibling.textContent.trim(),
        location: eventCard.querySelector('[data-lucide="map-pin"]').nextElementSibling.textContent.trim(),
        participants: eventCard.querySelector('[data-lucide="users"]').nextElementSibling.textContent.trim(),
        description: eventCard.querySelector('p.text-sm.text-gray-600')?.textContent.trim() || 'Aucune description disponible.',
        status: eventCard.dataset.available === 'true' ? 'ouvert' : 'complet',
        cover_image: null, // Sera géré par le backend plus tard
        likes_count: likesCount,
        is_liked: isLiked
    };

    openEventModal(eventData);
}

// Fonction pour ouvrir le modal avec les détails de l'événement
function openEventModal(eventData) {
    const modal = document.getElementById('event-details-modal');

    // Remplir les données du modal
    document.getElementById('modal-event-title').textContent = eventData.title;
    document.getElementById('modal-chamber-title').textContent = eventData.chamber_name;
    document.getElementById('modal-chamber-name').textContent = eventData.chamber_name;
    document.getElementById('modal-chamber-initials').textContent = eventData.chamber_initials;
    document.getElementById('modal-chamber-avatar-text').textContent = eventData.chamber_initials;
    document.getElementById('modal-event-datetime').textContent = eventData.date;
    document.getElementById('modal-event-location').textContent = eventData.location;
    document.getElementById('modal-event-participants').textContent = eventData.participants;
    document.getElementById('modal-event-type').textContent = eventData.type.charAt(0).toUpperCase() + eventData.type.slice(1);
    document.getElementById('modal-event-description').textContent = eventData.description;
    document.getElementById('modal-event-price').textContent = 'Gratuit'; // Par défaut
    document.getElementById('modal-event-mode').textContent = 'Présentiel'; // Par défaut

    // Utiliser les vraies données de likes
    document.getElementById('modal-likes-count').textContent = eventData.likes_count;

    // Configurer l'état du bouton J'aime avec les vraies données
    const likeButton = document.getElementById('modal-like-btn');
    likeButton.dataset.liked = eventData.is_liked ? 'true' : 'false';
    likeButton.dataset.eventId = eventData.id;

    if (eventData.is_liked) {
        likeButton.className = 'flex items-center gap-2 px-4 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-all duration-200';
        const heartIcon = likeButton.querySelector('i[data-lucide="heart"]');
        if (heartIcon) {
            heartIcon.style.fill = 'currentColor';
        }
    } else {
        likeButton.className = 'flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200';
        const heartIcon = likeButton.querySelector('i[data-lucide="heart"]');
        if (heartIcon) {
            heartIcon.style.fill = '';
        }
    }

    // Gérer l'image de couverture
    const coverImage = document.getElementById('modal-cover-image');
    const defaultCover = document.getElementById('modal-default-cover');

    if (eventData.cover_image) {
        coverImage.src = eventData.cover_image;
        coverImage.classList.remove('hidden');
        defaultCover.classList.add('hidden');
    } else {
        coverImage.classList.add('hidden');
        defaultCover.classList.remove('hidden');
    }

    // Badge de statut
    const statusBadge = document.getElementById('modal-status-badge');
    if (eventData.status === 'complet') {
        statusBadge.innerHTML = `
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-500/20 text-red-300 text-xs font-medium border border-red-500/30">
                <i data-lucide="users-x" class="h-3 w-3"></i>
                Complet
            </span>
        `;
    } else {
        statusBadge.innerHTML = `
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-500/20 text-green-300 text-xs font-medium border border-green-500/30">
                <i data-lucide="calendar-check" class="h-3 w-3"></i>
                Places disponibles
            </span>
        `;
    }

    // Vérification de chambre
    const verifiedBadge = document.getElementById('modal-chamber-verified');
    if (eventData.is_user_chamber) {
        verifiedBadge.classList.remove('hidden');
    } else {
        verifiedBadge.classList.add('hidden');
    }

    // Actions du modal
    const actionsContainer = document.getElementById('modal-event-actions');
    if (eventData.status === 'complet') {
        actionsContainer.innerHTML = `
            <button disabled class="px-6 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 text-sm font-medium cursor-not-allowed border border-gray-300 dark:border-gray-600">
                <i data-lucide="users-x" class="h-4 w-4 mr-2 inline"></i>
                Événement complet
            </button>
        `;
    } else {
        actionsContainer.innerHTML = `
            <form action="/events/${eventData.id}/book" method="POST" class="inline">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}">
                <button type="submit" class="px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors shadow-lg">
                    <i data-lucide="calendar-plus" class="h-4 w-4 mr-2 inline"></i>
                    Réserver ma place
                </button>
            </form>
        `;
    }

    // Afficher le modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Réinitialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// Fonction pour fermer le modal
function closeEventModal() {
    const modal = document.getElementById('event-details-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fonction pour le bouton J'aime dans le modal
function toggleModalLike() {
    const button = document.getElementById('modal-like-btn');
    const likesCountElement = document.getElementById('modal-likes-count');
    const eventId = button.dataset.eventId;

    if (!button || !likesCountElement || !eventId) return;

    const isLiked = button.dataset.liked === 'true';

    // Désactiver le bouton temporairement
    button.disabled = true;

    // Faire l'appel AJAX
    fetch(`/events/${eventId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour l'interface du modal
        if (data.liked) {
            button.dataset.liked = 'true';
            button.className = 'flex items-center gap-2 px-4 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-all duration-200';
            likesCountElement.className = 'text-xs bg-red-200 dark:bg-red-800/50 text-red-700 dark:text-red-300 px-2 py-1 rounded-full ml-1 font-medium';
            const heartIcon = button.querySelector('i[data-lucide="heart"]');
            if (heartIcon) {
                heartIcon.style.fill = 'currentColor';
            }
        } else {
            button.dataset.liked = 'false';
            button.className = 'flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200';
            likesCountElement.className = 'text-xs bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full ml-1 font-medium';
            const heartIcon = button.querySelector('i[data-lucide="heart"]');
            if (heartIcon) {
                heartIcon.style.fill = '';
            }
        }

        // Mettre à jour le compteur
        likesCountElement.textContent = data.likes_count;

        // Mettre à jour aussi le bouton like dans la liste des événements
        const eventCard = document.querySelector(`[data-event-id="${eventId}"].like-btn`);
        if (eventCard) {
            const eventLikeCount = eventCard.querySelector('.like-count');
            if (eventLikeCount) {
                eventLikeCount.textContent = data.likes_count;
            }

            if (data.liked) {
                eventCard.classList.add('liked');
                eventCard.style.color = '#ef4444';
                eventCard.style.borderColor = '#f87171';
                eventCard.style.backgroundColor = 'rgba(254, 226, 226, 0.5)';
                const heartIcon = eventCard.querySelector('i[data-lucide="heart"]');
                if (heartIcon) {
                    heartIcon.style.fill = 'currentColor';
                }
            } else {
                eventCard.classList.remove('liked');
                eventCard.style.color = '';
                eventCard.style.borderColor = '';
                eventCard.style.backgroundColor = '';
                const heartIcon = eventCard.querySelector('i[data-lucide="heart"]');
                if (heartIcon) {
                    heartIcon.style.fill = '';
                }
            }
        }

        // Animation du bouton
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 150);

        // Réinitialiser les icônes Lucide
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    })
    .catch(error => {
        console.error('Erreur lors du like:', error);
        showNotification('Erreur lors de l\'action. Veuillez réessayer.', 'error');
    })
    .finally(() => {
        // Réactiver le bouton
        button.disabled = false;
    });
}

// Fonction pour partager l'événement
function shareEvent() {
    const eventTitle = document.getElementById('modal-event-title').textContent;
    const eventDate = document.getElementById('modal-event-datetime').textContent;
    const chamberName = document.getElementById('modal-chamber-title').textContent;

    const shareText = `🎉 Événement: ${eventTitle}\n📅 ${eventDate}\n🏢 Organisé par ${chamberName}\n\nRejoignez-nous !`;

    if (navigator.share) {
        navigator.share({
            title: eventTitle,
            text: shareText,
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback: copier dans le presse-papiers
        navigator.clipboard.writeText(shareText).then(() => {
            showNotification('Détails de l\'événement copiés dans le presse-papiers !', 'success');
        }).catch(() => {
            showNotification('Impossible de copier les détails', 'error');
        });
    }
}

// Fermer le modal avec la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEventModal();
    }
});

// Fonction pour récupérer les taux de change
function fetchExchangeRates() {
    const loadingDiv = document.getElementById('exchange-rates-loading');
    const contentDiv = document.getElementById('exchange-rates-content');
    const errorDiv = document.getElementById('exchange-rates-error');
    const lastUpdateElement = document.getElementById('last-update');

    // API gratuite pour les taux de change (USD et EUR vers CDF)
    fetch('https://api.exchangerate-api.com/v4/latest/USD')
        .then(response => response.json())
        .then(data => {
            if (data && data.rates && data.rates.CDF) {
                // Calculer 1 USD = X CDF et 1 EUR = X CDF
                const usdToCdf = data.rates.CDF;

                // Pour EUR vers CDF, on fait: (CDF/USD) * (USD/EUR) = CDF/EUR
                const eurToUsd = data.rates.EUR;
                const eurToCdf = usdToCdf / eurToUsd;

                // Afficher les taux
                document.getElementById('rate-usd').textContent = usdToCdf.toFixed(2) + ' CDF';
                document.getElementById('rate-eur').textContent = eurToCdf.toFixed(2) + ' CDF';

                // Mettre à jour la date
                const now = new Date();
                lastUpdateElement.textContent = `Mis à jour: ${now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;

                // Afficher le contenu
                loadingDiv.classList.add('hidden');
                contentDiv.classList.remove('hidden');
                errorDiv.classList.add('hidden');
            } else {
                throw new Error('Format de données invalide');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des taux:', error);
            loadingDiv.classList.add('hidden');
            errorDiv.classList.remove('hidden');
            lastUpdateElement.textContent = 'Échec de la mise à jour';
        });
}

// Charger les taux au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    fetchExchangeRates();

    // Actualiser toutes les 5 minutes
    setInterval(fetchExchangeRates, 5 * 60 * 1000);
});

// Fonction pour afficher des notifications
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

    // Styles selon le type
    switch (type) {
        case 'success':
            notification.classList.add('bg-green-600', 'text-white');
            break;
        case 'error':
            notification.classList.add('bg-red-600', 'text-white');
            break;
        case 'info':
        default:
            notification.classList.add('bg-blue-600', 'text-white');
            break;
    }

    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info'}" class="h-4 w-4"></i>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;

    // Ajouter au DOM
    document.body.appendChild(notification);

    // Réinitialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Animation d'entrée
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Suppression automatique après 4 secondes
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 4000);
}
</script>
@endpush
@endsection