@extends('layouts.app')

@push('styles')
<style>
/* Animations fluides pour les boutons d'action */
.like-btn,
.inline-flex {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Animation scale fluide */
.scale-95 {
    transform: scale(0.95);
}

.scale-110 {
    animation: pulse-scale 0.3s ease-in-out;
}

@keyframes pulse-scale {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

/* Effet glassmorphism sur les boutons */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Hover effect professionnel */
.like-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.like-btn:active {
    transform: translateY(0);
}

/* Animation pour le compteur de likes */
.likes-count {
    transition: all 0.2s ease;
}

/* Style du cœur */
.like-btn i[data-lucide="heart"] {
    transition: all 0.3s ease;
}

.like-btn i[data-lucide="heart"].fill-current {
    fill: currentColor;
}

/* Effet hover sur les icônes */
.group:hover i {
    transform: scale(1.1);
}

/* Bordures fluides */
.event-card {
    transition: all 0.3s ease;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Séparateur élégant */
.h-10.w-px {
    background: linear-gradient(to bottom, transparent, currentColor 20%, currentColor 80%, transparent);
}

/* Animation d'entrée pour les événements */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.event-card {
    animation: fadeInUp 0.5s ease-out;
}

/* Responsive touch feedback sur mobile */
@media (hover: none) and (pointer: coarse) {
    .like-btn:active {
        transform: scale(0.95);
    }
}
</style>
@endpush

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Main Content -->
    <main class="lg:col-span-9">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-semibold">Upcoming Events</h1>
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
            <button data-filter="mode" data-value="online"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="monitor" class="h-3 w-3 mr-1"></i>
                En ligne
            </button>
            <button data-filter="mode" data-value="presentiel"
                class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                <i data-lucide="map-pin" class="h-3 w-3 mr-1"></i>
                Présentiel
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

        <div class="border-b border-neutral-200 dark:border-gray-700 mb-6">
            <nav class="flex gap-1">
                <a href="{{ route('events', ['tab' => 'for-you']) }}"
                    class="px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'for-you' ? 'text-[#2563eb] dark:text-blue-400 border-b-2 border-[#2563eb] dark:border-blue-500' : 'text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    For you
                    @if(isset($stats['for_you_count']) && $stats['for_you_count'] > 0)
                    <span
                        class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-medium bg-[#2563eb] text-white rounded-full">{{
                        $stats['for_you_count'] }}</span>
                    @endif
                </a>
                <a href="{{ route('events', ['tab' => 'following']) }}"
                    class="px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'following' ? 'text-[#2563eb] dark:text-blue-400 border-b-2 border-[#2563eb] dark:border-blue-500' : 'text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    Following
                    @if(isset($stats['following_count']) && $stats['following_count'] > 0)
                    <span
                        class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-medium bg-[#2563eb] text-white rounded-full">{{
                        $stats['following_count'] }}</span>
                    @endif
                </a>
                <a href="{{ route('events', ['tab' => 'events']) }}"
                    class="px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'events' ? 'text-[#2563eb] dark:text-blue-400 border-b-2 border-[#2563eb] dark:border-blue-500' : 'text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    Events
                    @if(isset($stats['events_count']) && $stats['events_count'] > 0)
                    <span
                        class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-medium bg-[#2563eb] text-white rounded-full">{{
                        $stats['events_count'] }}</span>
                    @endif
                </a>
            </nav>
        </div>

        <!-- Description de l'onglet actuel -->
        <div
            class="mb-6 p-4 rounded-lg bg-neutral-50 dark:bg-gray-800/50 border border-neutral-200 dark:border-gray-700">
            @if($tab === 'for-you')
            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                <i data-lucide="home" class="h-4 w-4"></i>
                <span>Événements des chambres dont vous êtes membre</span>
            </div>
            @elseif($tab === 'following')
            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                <i data-lucide="heart" class="h-4 w-4"></i>
                <span>Événements que vous avez confirmés</span>
            </div>
            @elseif($tab === 'events')
            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                <i data-lucide="calendar" class="h-4 w-4"></i>
                <span>Découvrez de nouveaux événements d'autres chambres</span>
            </div>
            @endif
        </div>

        <div class="space-y-8">
            <div class="space-y-6">
                @foreach($upcoming_events as $event)
                @if($event->chamber)
                <div class="event-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden hover:shadow-sm transition-all duration-200"
                    data-type="{{ $event->type }}" data-mode="{{ $event->mode }}"
                    data-location="{{ strtolower($event->city ?? 'online') }}"
                    data-verified="{{ $event->chamber->verified ? 'true' : 'false' }}"
                    data-available="{{ $event->status !== 'full' ? 'true' : 'false' }}"
                    data-title="{{ strtolower($event->title) }}"
                    data-description="{{ strtolower($event->description ?? '') }}"
                    data-chamber="{{ strtolower($event->chamber->name) }}"
                    data-is-booked="{{ $event->is_booked ? 'true' : 'false' }}"
                    data-booking-status="{{ $event->booking_status ?? '' }}"
                    data-date="{{ $event->date->format('Y-m-d') }}" data-participants="{{ $event->participants_count }}"
                    data-max-participants="{{ $event->max_participants ?? 0 }}">

                    <div class="grid sm:grid-cols-3 gap-0">
                        @if($event->cover_image_path)
                        <img src="{{ asset('storage/' . $event->cover_image_path) }}" alt="{{ $event->title }}"
                            class="h-48 w-full object-cover sm:h-full">
                        @else
                        <div
                            class="h-48 sm:h-full bg-gradient-to-br from-[#1e40af] to-[#2563eb] flex items-center justify-center">
                            <div class="text-center text-white">
                                @if($event->type === 'forum')
                                <i data-lucide="users" class="h-12 w-12 mx-auto mb-2"></i>
                                @elseif($event->type === 'networking')
                                <i data-lucide="network" class="h-12 w-12 mx-auto mb-2"></i>
                                @elseif($event->type === 'conference')
                                <i data-lucide="presentation" class="h-12 w-12 mx-auto mb-2"></i>
                                @elseif($event->type === 'meeting')
                                <i data-lucide="calendar" class="h-12 w-12 mx-auto mb-2"></i>
                                @else
                                <i data-lucide="calendar-check" class="h-12 w-12 mx-auto mb-2"></i>
                                @endif
                                <p class="text-sm font-medium">{{ ucfirst($event->type) }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="sm:col-span-2 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    @if($event->chamber->logo_path)
                                    <img src="{{ asset('storage/' . $event->chamber->logo_path) }}"
                                        alt="{{ $event->chamber->name }}"
                                        class="h-10 w-10 rounded-lg object-cover shadow-sm">
                                    @else
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#1e40af] to-[#2563eb] text-white shadow-sm">
                                        <span class="text-sm font-medium">{{ strtoupper(substr($event->chamber->name, 0,
                                            2)) }}</span>
                                    </div>
                                    @endif
                                    <div>
                                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{
                                            $event->chamber->name }}</span>
                                        @if($event->chamber->verified)
                                        <div class="flex items-center gap-1 mt-0.5">
                                            <i data-lucide="shield-check" class="h-3 w-3 text-[#fcb357]"></i>
                                            <span class="text-xs text-[#fcb357]">Agréée</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Statut de l'événement -->
                                <div class="flex flex-col items-end gap-1">
                                    @if($event->status === 'full')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-red-100 dark:bg-red-900/30 px-2 py-1 text-xs font-medium text-red-800 dark:text-red-400">
                                        <i data-lucide="users-x" class="h-3 w-3"></i>
                                        Complet
                                    </span>
                                    @elseif($event->max_participants && $event->available_spots <= 5) <span
                                        class="inline-flex items-center gap-1 rounded-full bg-orange-100 dark:bg-orange-900/30 px-2 py-1 text-xs font-medium text-orange-800 dark:text-orange-400">
                                        <i data-lucide="clock" class="h-3 w-3"></i>
                                        {{ $event->available_spots }} places restantes
                                        </span>
                                        @endif

                                        @if($event->is_booked)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-800 dark:text-green-400">
                                            <i data-lucide="check-circle" class="h-3 w-3"></i>
                                            {{ $event->booking_status === 'confirmed' ? 'Confirmé' : 'Réservé' }}
                                        </span>
                                        @endif
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold mb-2 text-neutral-900 dark:text-white">{{ $event->title }}
                            </h3>

                            <!-- Informations de l'événement -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="calendar" class="h-4 w-4"></i>
                                    {{ $event->date->format('d M Y') }} à {{ $event->time }}
                                </div>
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                    @if($event->mode === 'online')
                                    <i data-lucide="monitor" class="h-4 w-4"></i>
                                    En ligne
                                    @elseif($event->mode === 'presentiel')
                                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                                    {{ $event->city }}, {{ $event->country }}
                                    @else
                                    <i data-lucide="globe" class="h-4 w-4"></i>
                                    Hybride
                                    @endif
                                </div>
                                @if($event->max_participants)
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="users" class="h-4 w-4"></i>
                                    {{ $event->participants_count }}/{{ $event->max_participants }} participants
                                </div>
                                @else
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="users" class="h-4 w-4"></i>
                                    {{ $event->participants_count }} participants
                                </div>
                                @endif
                                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="tag" class="h-4 w-4"></i>
                                    {{ ucfirst($event->type) }}
                                </div>
                            </div>

                            @if($event->description)
                            <p class="text-sm text-neutral-600 dark:text-gray-400 mb-4">{{
                                Str::limit($event->description, 120) }}</p>
                            @endif

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                {{-- Bouton J'aime avec compteur --}}
                                @auth
                                <button onclick="toggleEventLike(this, {{ $event->id }})" 
                                        data-event-id="{{ $event->id }}"
                                        data-liked="{{ $event->is_liked ?? false ? 'true' : 'false' }}"
                                        data-likes-count="{{ $event->likes_count ?? 0 }}"
                                        class="like-btn inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm transition-all duration-200 hover:bg-neutral-50 dark:hover:bg-gray-700/50 hover:border-neutral-300 dark:hover:border-gray-600 group">
                                    <i data-lucide="heart" class="h-4 w-4 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform {{ ($event->is_liked ?? false) ? 'fill-current' : '' }}"></i>
                                    <span class="likes-count text-sm font-medium text-neutral-700 dark:text-gray-300">{{ $event->likes_count ?? 0 }}</span>
                                </button>
                                @else
                                <button onclick="openModal('signin-modal')" 
                                        class="like-btn inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm transition-all duration-200 hover:bg-neutral-50 dark:hover:bg-gray-700/50 hover:border-neutral-300 dark:hover:border-gray-600 group">
                                    <i data-lucide="heart" class="h-4 w-4 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform"></i>
                                    <span class="likes-count text-sm font-medium text-neutral-700 dark:text-gray-300">{{ $event->likes_count ?? 0 }}</span>
                                </button>
                                @endauth
                                
                                {{-- Bouton Partager --}}
                                <button onclick="shareEvent({{ $event->id }})"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm transition-all duration-200 hover:bg-neutral-50 dark:hover:bg-gray-700/50 hover:border-neutral-300 dark:hover:border-gray-600">
                                    <i data-lucide="share-2" class="h-4 w-4 text-neutral-600 dark:text-gray-400"></i>
                                </button>
                                
                                {{-- Bouton Vues --}}
                                <button onclick="viewEvent({{ $event->id }})"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm transition-all duration-200 hover:bg-neutral-50 dark:hover:bg-gray-700/50 hover:border-neutral-300 dark:hover:border-gray-600">
                                    <i data-lucide="eye" class="h-4 w-4 text-neutral-600 dark:text-gray-400"></i>
                                </button>

                                {{-- Séparateur visuel --}}
                                <div class="h-10 w-px bg-neutral-200 dark:bg-gray-700"></div>
                                
                                @auth
                                @if($event->is_booked)
                                <!-- Utilisateur déjà inscrit -->
                                <div class="flex items-center gap-2">
                                    @if($event->booking_status === 'reserved')
                                    <form action="{{ route('events.confirm', $event) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] px-5 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                            <i data-lucide="check-circle" class="h-4 w-4"></i>
                                            Confirmer participation
                                        </button>
                                    </form>
                                    @endif

                                    @if($event->mode === 'online' && $event->lien_live && $event->booking_status ===
                                    'confirmed')
                                    <a href="{{ $event->lien_live }}" target="_blank"
                                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                        <i data-lucide="video" class="h-4 w-4"></i>
                                        Rejoindre en ligne
                                    </a>
                                    @endif

                                    {{-- Bouton d'annulation - Désactivé si confirmé --}}
                                    @if($event->booking_status === 'confirmed')
                                    <button type="button" 
                                            disabled
                                            title="Vous ne pouvez pas annuler un événement confirmé. Contactez l'organisateur."
                                            class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-neutral-50 dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-neutral-400 dark:text-gray-500 cursor-not-allowed opacity-50">
                                        <i data-lucide="ban" class="h-4 w-4"></i>
                                        <span class="text-xs">Confirmé</span>
                                    </button>
                                    @else
                                    <button type="button" 
                                            onclick="openCancelModal({{ $event->id }}, '{{ $event->title }}')"
                                            class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm px-4 py-2.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-50 dark:hover:bg-gray-700/50 hover:border-neutral-300 dark:hover:border-gray-600 transition-all duration-200">
                                        <i data-lucide="x-circle" class="h-4 w-4"></i>
                                        Annuler réservation
                                    </button>
                                    
                                    <!-- Formulaire caché pour l'annulation -->
                                    <form id="cancel-form-{{ $event->id }}" action="{{ route('events.cancel', $event) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </div>
                                @else
                                <!-- Utilisateur non inscrit -->
                                @if($event->status === 'full')
                                <button disabled
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-neutral-100 dark:bg-gray-800 px-5 py-2.5 text-sm font-medium text-neutral-400 dark:text-gray-500 cursor-not-allowed opacity-60">
                                    <i data-lucide="users-x" class="h-4 w-4"></i>
                                    Complet
                                </button>
                                @else
                                <form action="{{ route('events.book', $event) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] px-5 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                        <i data-lucide="calendar-check" class="h-4 w-4"></i>
                                        Réserver une place
                                    </button>
                                </form>
                                @endif
                                @endif
                                @else
                                <button onclick="openModal('signin-modal')"
                                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] px-5 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                    <i data-lucide="log-in" class="h-4 w-4"></i>
                                    Se connecter pour réserver
                                </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

                <!-- Message si aucun événement -->
                @if($upcoming_events->count() === 0)
                <div class="text-center py-12">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
                        <i data-lucide="calendar-x" class="h-8 w-8"></i>
                    </div>
                    <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun événement à venir</h3>
                    <p class="text-sm text-neutral-600 dark:text-gray-400 mb-6">Il n'y a actuellement aucun événement
                        programmé.</p>
                    @auth
                    @if(auth()->user()->hasAdminPrivileges())
                    <a href="{{ route('chambers.events.create', auth()->user()->chambers()->first() ?? 1) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#2563eb] px-4 py-2 text-sm font-medium text-white hover:bg-[#1e40af] transition-colors">
                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                        Créer un événement
                    </a>
                    @endif
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Sidebar - Filtres -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Section Avantages Entrepreneurs -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <h2 class="text-sm font-semibold text-[#2563eb] dark:text-blue-400">Pourquoi participer aux
                        événements ?</h2>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Les avantages clés pour votre entreprise
                    </p>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#2563eb]/10 text-[#2563eb] dark:text-blue-400 flex items-center justify-center">
                                <i data-lucide="users" class="h-4 w-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Networking Stratégique
                                </h3>
                                <p class="text-xs text-neutral-600 dark:text-gray-400 mt-1">Rencontrez des partenaires,
                                    investisseurs et clients potentiels dans votre secteur</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#fcb357]/10 text-[#fcb357] flex items-center justify-center">
                                <i data-lucide="lightbulb" class="h-4 w-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Innovation & Tendances
                                </h3>
                                <p class="text-xs text-neutral-600 dark:text-gray-400 mt-1">Découvrez les dernières
                                    innovations et tendances de votre marché</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center">
                                <i data-lucide="trending-up" class="h-4 w-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Opportunités d'Affaires
                                </h3>
                                <p class="text-xs text-neutral-600 dark:text-gray-400 mt-1">Identifiez de nouveaux
                                    marchés et opportunités de croissance</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Formation Continue</h3>
                                <p class="text-xs text-neutral-600 dark:text-gray-400 mt-1">Développez vos compétences
                                    avec des experts reconnus</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                <i data-lucide="handshake" class="h-4 w-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Partenariats
                                    Stratégiques</h3>
                                <p class="text-xs text-neutral-600 dark:text-gray-400 mt-1">Créez des alliances durables
                                    pour développer votre activité</p>
                            </div>
                        </div>
                    </div>

                    @guest
                    <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-gray-700">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 w-full justify-center rounded-md bg-[#2563eb] px-3 py-2 text-xs font-semibold text-white hover:bg-[#1e40af] transition-colors">
                            <i data-lucide="user-plus" class="h-3 w-3"></i>
                            Rejoindre maintenant
                        </a>
                    </div>
                    @endguest
                </div>
            </div>

            <!-- Carrousel des Partenaires -->
            <div
                class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <h2 class="text-sm font-semibold text-[#2563eb] dark:text-blue-400">Nos Partenaires</h2>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Institutions qui soutiennent notre
                        écosystème</p>
                </div>
                <div class="p-4">
                    <div class="relative overflow-hidden">
                        <div class="sponsors-carousel flex transition-transform duration-500 ease-in-out"
                            id="sponsors-carousel">
                            <!-- Partenaire 1 - SEGUCE -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/seguce.png') }}" alt="SEGUCE"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">SEGUCE</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 2 - Commerce -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/commerce.png') }}" alt="Commerce"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Commerce</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 3 - DGDA -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/dgda.jpg') }}" alt="DGDA"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">DGDA</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 4 - DGI -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/dgi.png') }}" alt="DGI"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">DGI</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 5 - AZES -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/azes.jpg') }}" alt="AZES"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">AZES</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 6 - ZELCAF -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/zelcaf.jpg') }}" alt="ZELCAF"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">ZELCAF</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 7 - BCC -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/bcc.png') }}" alt="BCC"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">BCC</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 8 - ANADEC -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/anadec.png') }}" alt="ANADEC"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">ANADEC</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 9 - ANAPI -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/anapi.png') }}" alt="ANAPI"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">ANAPI</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Partenaire 10 - FPI -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 flex items-center justify-center p-2 shadow-sm">
                                        <img src="{{ asset('img/partenaires/fpi.png') }}" alt="FPI"
                                            class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">FPI</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Indicateurs de navigation -->
                        <div class="flex justify-center mt-4 space-x-2">
                            <button class="sponsor-dot w-2 h-2 rounded-full bg-[#2563eb] transition-all duration-200"
                                data-slide="0"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="1"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="2"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="3"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="4"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="5"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="6"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="7"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="8"></button>
                            <button
                                class="sponsor-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="9"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
// Fonction pour gérer les likes d'événements
function toggleEventLike(button, eventId) {
    // Vérifier si l'utilisateur est connecté
    @guest
    openModal('signin-modal');
    return;
    @endguest
    
    const isLiked = button.getAttribute('data-liked') === 'true';
    const likesCountSpan = button.querySelector('.likes-count');
    const heartIcon = button.querySelector('i[data-lucide="heart"]');
    let currentCount = parseInt(button.getAttribute('data-likes-count') || '0');
    
    // Désactiver le bouton temporairement
    button.disabled = true;
    
    // Animation optimiste
    button.classList.add('scale-95');
    setTimeout(() => {
        button.classList.remove('scale-95');
    }, 150);
    
    // Appel AJAX
    fetch(`/events/${eventId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour l'état
        button.setAttribute('data-liked', data.liked ? 'true' : 'false');
        button.setAttribute('data-likes-count', data.likes_count);
        
        // Mettre à jour le compteur avec animation
        if (likesCountSpan) {
            likesCountSpan.classList.add('scale-110');
            likesCountSpan.textContent = data.likes_count;
            setTimeout(() => {
                likesCountSpan.classList.remove('scale-110');
            }, 200);
        }
        
        // Animer le cœur
        if (heartIcon) {
            if (data.liked) {
                heartIcon.classList.add('fill-current', 'scale-110');
                setTimeout(() => {
                    heartIcon.classList.remove('scale-110');
                }, 200);
            } else {
                heartIcon.classList.remove('fill-current');
            }
        }
        
        // Réinitialiser les icônes
        lucide.createIcons();
    })
    .catch(error => {
        console.error('Erreur lors du like:', error);
        showNotification('Une erreur s\'est produite', 'error');
    })
    .finally(() => {
        // Réactiver le bouton
        button.disabled = false;
    });
}

// Fonction pour partager un événement
function shareEvent(eventId) {
    if (navigator.share) {
        navigator.share({
            title: 'Événement ChamberConnect',
            text: 'Découvrez cet événement intéressant !',
            url: window.location.href
        }).catch(err => console.log('Erreur de partage:', err));
    } else {
        // Copier l'URL dans le presse-papiers
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('Lien copié dans le presse-papiers !', 'success');
        });
    }
}

// Fonction pour voir un événement
function viewEvent(eventId) {
    window.location.href = `/events/${eventId}`;
}

// Fonction de notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${type === 'error' ? 'bg-red-600' : 'bg-green-600'} text-white`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

    document.addEventListener('DOMContentLoaded', function() {
    // Initialiser Lucide
    lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
    
    // Système de filtres pour les événements
    const eventFilters = {
        activeFilters: {
            type: null,
            mode: null,
            verified: null,
            available: null,
            search: ''
        },
        
        init() {
            console.log('Initializing event filters...');
            this.attachEvents();
            this.applyFilters();
            console.log('Event filters initialized');
        },
        
        attachEvents() {
            // Boutons de filtre
            document.querySelectorAll('[data-filter]:not([data-filter="clear"])').forEach(button => {
                button.addEventListener('click', (e) => this.handleFilterClick(e));
            });
            
            // Bouton effacer filtres
            const clearBtn = document.getElementById('clear-filters');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => this.clearAllFilters());
            }
            
            // Recherche textuelle
            const searchInput = document.getElementById('events-search');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    this.activeFilters.search = e.target.value.toLowerCase();
                    this.applyFilters();
                });
            }
        },
        
        handleFilterClick(event) {
            const button = event.currentTarget;
            const filterType = button.getAttribute('data-filter');
            const filterValue = button.getAttribute('data-value');
            
            console.log('Filter clicked:', filterType, filterValue);
            
            // Basculer le filtre
            if (this.activeFilters[filterType] === filterValue) {
                // Désactiver le filtre
                this.activeFilters[filterType] = null;
                this.resetButtonStyle(button);
            } else {
                // Désactiver les autres filtres du même type
                document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(btn => {
                    if (btn !== button) {
                        this.resetButtonStyle(btn);
                    }
                });
                
                // Activer ce filtre
                this.activeFilters[filterType] = filterValue;
                this.activateButtonStyle(button, filterType);
            }
            
            this.applyFilters();
        },
        
        resetButtonStyle(button) {
            button.classList.remove('bg-blue-600', 'bg-green-600', 'bg-purple-600', 'text-white');
            button.classList.add('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
        },
        
        activateButtonStyle(button, filterType) {
            button.classList.remove('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
            
            switch (filterType) {
                case 'type':
                    button.classList.add('bg-blue-600', 'text-white');
                    break;
                case 'mode':
                    button.classList.add('bg-green-600', 'text-white');
                    break;
                case 'verified':
                case 'available':
                    button.classList.add('bg-purple-600', 'text-white');
                    break;
            }
        },
        
        applyFilters() {
            const eventCards = document.querySelectorAll('.event-card');
            let visibleCount = 0;
            
            console.log('Applying filters:', this.activeFilters);
            console.log('Event cards found:', eventCards.length);
            
            eventCards.forEach((card, index) => {
                const shouldShow = this.cardMatchesFilters(card);
                
                if (shouldShow) {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            console.log('Visible cards:', visibleCount);
            
            // Gérer le bouton "Effacer filtres"
            this.updateClearButton();
            
            // Afficher message si aucun résultat
            this.showNoResultsMessage(visibleCount === 0);
        },
        
        cardMatchesFilters(card) {
            // Récupérer les attributs de la carte
            const cardType = card.getAttribute('data-type');
            const cardMode = card.getAttribute('data-mode');
            const cardVerified = card.getAttribute('data-verified');
            const cardAvailable = card.getAttribute('data-available');
            const cardTitle = (card.getAttribute('data-title') || '').toLowerCase();
            const cardDescription = (card.getAttribute('data-description') || '').toLowerCase();
            const cardChamber = (card.getAttribute('data-chamber') || '').toLowerCase();
            
            // Tests de correspondance
            const matchesType = !this.activeFilters.type || cardType === this.activeFilters.type;
            const matchesMode = !this.activeFilters.mode || cardMode === this.activeFilters.mode;
            const matchesVerified = !this.activeFilters.verified || cardVerified === this.activeFilters.verified;
            const matchesAvailable = !this.activeFilters.available || cardAvailable === this.activeFilters.available;
            
            // Recherche textuelle
            const searchTerm = this.activeFilters.search;
            const matchesSearch = !searchTerm || 
                cardTitle.includes(searchTerm) ||
                cardDescription.includes(searchTerm) ||
                cardChamber.includes(searchTerm);
            
            return matchesType && matchesMode && matchesVerified && matchesAvailable && matchesSearch;
        },
        
        updateClearButton() {
            const clearBtn = document.getElementById('clear-filters');
            if (!clearBtn) return;
            
            const hasActiveFilters = Object.values(this.activeFilters).some(value => value !== null && value !== '');
            clearBtn.style.display = hasActiveFilters ? 'inline-flex' : 'none';
        },
        
        clearAllFilters() {
            console.log('Clearing all filters');
            
            // Réinitialiser les filtres
            this.activeFilters = {
                type: null,
                mode: null,
                verified: null,
                available: null,
                search: ''
            };
            
            // Réinitialiser l'apparence des boutons
            document.querySelectorAll('[data-filter]:not([data-filter="clear"])').forEach(button => {
                this.resetButtonStyle(button);
            });
            
            // Vider la recherche
            const searchInput = document.getElementById('events-search');
            if (searchInput) {
                searchInput.value = '';
            }
            
            // Appliquer les filtres
            this.applyFilters();
        },
        
        showNoResultsMessage(show) {
            let noResultsDiv = document.getElementById('no-results-events');
            
            if (show && !noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'no-results-events';
                noResultsDiv.className = 'text-center py-12';
                noResultsDiv.innerHTML = `
                    <div class="mx-auto max-w-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
                            <i data-lucide="calendar-x" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun événement trouvé</h3>
                        <p class="text-sm text-neutral-600 dark:text-gray-400">Essayez de modifier vos critères de recherche ou vos filtres.</p>
                        <button onclick="eventFilters.clearAllFilters()" class="mt-4 inline-flex items-center gap-2 rounded-md bg-[#2563eb] px-4 py-2 text-sm font-semibold text-white hover:bg-[#1e40af] transition-colors">
                            <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                            Réinitialiser les filtres
                        </button>
                    </div>
                `;
                
                const eventsContainer = document.querySelector('.space-y-6');
                if (eventsContainer) {
                    eventsContainer.appendChild(noResultsDiv);
                    lucide.createIcons();
                }
            } else if (!show && noResultsDiv) {
                noResultsDiv.remove();
            }
        }
    };
    
    // Initialiser les filtres
    eventFilters.init();
    
    // Rendre disponible globalement
    window.eventFilters = eventFilters;
    
    // Fonction globale pour compatibilité
    window.clearAllEventFilters = function() {
        eventFilters.clearAllFilters();
    };

    // Carrousel des partenaires
    const sponsorsCarousel = {
        currentSlide: 0,
        totalSlides: 10, // Nombre total de partenaires
        autoPlayInterval: null,
        
        init() {
            this.setupCarousel();
            this.startAutoPlay();
        },
        
        setupCarousel() {
            const carousel = document.getElementById('sponsors-carousel');
            const dots = document.querySelectorAll('.sponsor-dot');
            
            if (!carousel || dots.length === 0) return;
            
            // Attacher les événements aux dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    this.goToSlide(index);
                });
            });
            
            // Pause auto-play au survol
            carousel.addEventListener('mouseenter', () => this.stopAutoPlay());
            carousel.addEventListener('mouseleave', () => this.startAutoPlay());
        },
        
        goToSlide(slideIndex) {
            const carousel = document.getElementById('sponsors-carousel');
            const dots = document.querySelectorAll('.sponsor-dot');
            
            if (!carousel || !dots.length) return;
            
            this.currentSlide = slideIndex;
            
            // Déplacer le carrousel
            const translateX = -slideIndex * 100;
            carousel.style.transform = `translateX(${translateX}%)`;
            
            // Mettre à jour les dots
            dots.forEach((dot, index) => {
                if (index === slideIndex) {
                    dot.classList.remove('bg-neutral-300');
                    dot.classList.add('bg-[#2563eb]');
                } else {
                    dot.classList.remove('bg-[#2563eb]');
                    dot.classList.add('bg-neutral-300');
                }
            });
        },
        
        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.totalSlides;
            this.goToSlide(nextIndex);
        },
        
        startAutoPlay() {
            this.stopAutoPlay(); // Éviter les doublons
            this.autoPlayInterval = setInterval(() => {
                this.nextSlide();
            }, 4000); // Change toutes les 4 secondes
        },
        
        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }
    };
    
    // Initialiser le carrousel des sponsors
    sponsorsCarousel.init();
});

// Variables pour le modal d'annulation
let currentEventId = null;

function openCancelModal(eventId, eventTitle) {
    currentEventId = eventId;
    document.getElementById('eventTitle').textContent = eventTitle;
    document.getElementById('cancelModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Animation d'entrée
    setTimeout(() => {
        document.getElementById('cancelModal').classList.add('opacity-100');
    }, 10);
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentEventId = null;
}

function confirmCancel() {
    if (currentEventId) {
        // Soumettre le formulaire d'annulation
        document.getElementById(`cancel-form-${currentEventId}`).submit();
    }
}

// Fermer le modal avec la touche Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('cancelModal').classList.contains('hidden')) {
        closeCancelModal();
    }
});
</script>
@endpush

<!-- Modal de confirmation d'annulation -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeCancelModal()"></div>
    
    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-xl transition-all">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-900/30">
                        <i data-lucide="alert-triangle" class="h-5 w-5 text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Confirmer l'annulation</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Cette action est irréversible</p>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-4">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Êtes-vous sûr de vouloir annuler votre réservation pour :
                </p>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-4">
                    <p class="font-medium text-gray-900 dark:text-white" id="eventTitle">
                        <!-- Le titre sera inséré ici par JavaScript -->
                    </p>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800/50 rounded-lg p-3">
                    <div class="flex items-start gap-2">
                        <i data-lucide="info" class="h-4 w-4 text-orange-600 dark:text-orange-400 mt-0.5 flex-shrink-0"></i>
                        <p class="text-xs text-orange-700 dark:text-orange-300">
                            Une fois annulée, vous devrez vous réinscrire si vous souhaitez participer à cet événement.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-end gap-3">
                <button type="button" 
                        onclick="closeCancelModal()"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Garder ma réservation
                </button>
                <button type="button" 
                        onclick="confirmCancel()"
                        class="inline-flex items-center gap-2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white hover:bg-orange-700 transition-colors">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    Annuler la réservation
                </button>
            </div>
        </div>
    </div>
</div>

@endsection