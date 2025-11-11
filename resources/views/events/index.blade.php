@extends('layouts.app')

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
                    class="px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'for-you' ? 'text-[#073066] dark:text-blue-400 border-b-2 border-[#073066] dark:border-blue-500' : 'text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    For you
                    @if(isset($stats['for_you_count']) && $stats['for_you_count'] > 0)
                    <span
                        class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-medium bg-[#073066] text-white rounded-full">{{
                        $stats['for_you_count'] }}</span>
                    @endif
                </a>
                <a href="{{ route('events', ['tab' => 'following']) }}"
                    class="px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'following' ? 'text-[#073066] dark:text-blue-400 border-b-2 border-[#073066] dark:border-blue-500' : 'text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    Following
                    @if(isset($stats['following_count']) && $stats['following_count'] > 0)
                    <span
                        class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-medium bg-green-600 text-white rounded-full">{{
                        $stats['following_count'] }}</span>
                    @endif
                </a>
                <a href="{{ route('events', ['tab' => 'events']) }}"
                    class="px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'events' ? 'text-[#073066] dark:text-blue-400 border-b-2 border-[#073066] dark:border-blue-500' : 'text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white' }}">
                    Events
                    @if(isset($stats['events_count']) && $stats['events_count'] > 0)
                    <span
                        class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-medium bg-neutral-600 text-white rounded-full">{{
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
                            class="h-48 sm:h-full bg-gradient-to-br from-[#073066] to-[#052347] flex items-center justify-center">
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
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm">
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
                            <div class="flex items-center gap-3">
                                <button onclick="toggleLike(this)" data-likes="{{ rand(10, 50) }}"
                                    class="like-btn inline-flex items-center justify-center w-9 h-9 rounded-full text-neutral-400 dark:text-gray-500 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                                    <i data-lucide="heart" class="h-4 w-4"></i>
                                </button>

                                @auth
                                @if($event->is_booked)
                                <!-- Utilisateur déjà inscrit -->
                                <div class="flex items-center gap-2">
                                    @if($event->booking_status === 'reserved')
                                    <form action="{{ route('events.confirm', $event) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 transition-colors shadow-sm">
                                            <i data-lucide="check" class="h-4 w-4"></i>
                                            Confirmer
                                        </button>
                                    </form>
                                    @endif

                                    @if($event->mode === 'online' && $event->lien_live && $event->booking_status ===
                                    'confirmed')
                                    <a href="{{ $event->lien_live }}" target="_blank"
                                        class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition-colors shadow-sm">
                                        <i data-lucide="external-link" class="h-4 w-4"></i>
                                        Rejoindre
                                    </a>
                                    @endif

                                    <form action="{{ route('events.cancel', $event) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-md border border-red-200 dark:border-red-800 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <i data-lucide="x" class="h-4 w-4"></i>
                                            Annuler
                                        </button>
                                    </form>
                                </div>
                                @else
                                <!-- Utilisateur non inscrit -->
                                @if($event->status === 'full')
                                <button disabled
                                    class="inline-flex items-center gap-2 rounded-md bg-gray-400 px-4 py-2.5 text-sm font-medium text-white cursor-not-allowed">
                                    <i data-lucide="users-x" class="h-4 w-4"></i>
                                    Fin réservations
                                </button>
                                @else
                                <form action="{{ route('events.book', $event) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors shadow-sm">
                                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                        Réserver place
                                    </button>
                                </form>
                                @endif
                                @endif
                                @else
                                <button onclick="openModal('signin-modal')"
                                    class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors shadow-sm">
                                    <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                    Réserver place
                                </button>
                                @endauth

                                <button onclick="incrementViews(this)" data-views="{{ rand(50, 200) }}"
                                    class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-50 dark:hover:bg-gray-700 hover:border-neutral-300 transition-colors">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    Voir plus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
                        class="inline-flex items-center gap-2 rounded-lg bg-[#073066] px-4 py-2 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
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
                    <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Pourquoi participer aux
                        événements ?</h2>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Les avantages clés pour votre entreprise
                    </p>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#073066]/10 text-[#073066] dark:text-blue-400 flex items-center justify-center">
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
                            class="inline-flex items-center gap-2 w-full justify-center rounded-md bg-[#073066] px-3 py-2 text-xs font-semibold text-white hover:bg-[#052347] transition-colors">
                            <i data-lucide="user-plus" class="h-3 w-3"></i>
                            Rejoindre maintenant
                        </a>
                    </div>
                    @endguest
                </div>
            </div>

            <!-- Carrousel des Sponsors Tech -->
            <div
                class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Nos Sponsors Tech</h2>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Leaders technologiques qui soutiennent
                        l'innovation</p>
                </div>
                <div class="p-4">
                    <div class="relative overflow-hidden">
                        <div class="sponsors-carousel flex transition-transform duration-500 ease-in-out"
                            id="sponsors-carousel">
                            <!-- Sponsor 1 - Microsoft -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.4 24H0V12.6h11.4V24zM24 24H12.6V12.6H24V24zM11.4 11.4H0V0h11.4v11.4zM24 11.4H12.6V0H24v11.4z" />
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Microsoft</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">Cloud & IA</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 2 - Google -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-red-500 via-yellow-500 to-blue-500 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-2xl">G</span>
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Google</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">Search & Ads</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 3 - Amazon AWS -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M.045 18.02c.072-.116.187-.124.348-.022 3.636 2.11 7.594 3.166 11.87 3.166 2.852 0 5.668-.533 8.447-1.595l.315-.14c.138-.06.234-.1.293-.13.226-.088.39-.046.525.13.12.174.09.336-.12.48-.256.19-.6.41-1.006.654-1.244.743-2.64 1.316-4.185 1.726-1.548.41-3.156.615-4.83.615-2.424 0-4.73-.315-6.914-.946-2.185-.63-4.17-1.54-5.955-2.73-.195-.13-.285-.285-.225-.465l.437-.743z" />
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Amazon
                                            AWS</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">Cloud Computing</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 4 - Meta -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-2xl">M</span>
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Meta</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">Social & VR</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 5 - Apple -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Apple</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">Innovation Tech</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 6 - IBM -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-700 to-blue-800 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">IBM</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">IBM</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">AI & Analytics</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 7 - Oracle -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-sm">ORACLE</span>
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Oracle</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">Database & Cloud</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsor 8 - Salesforce -->
                            <div class="sponsor-slide flex-shrink-0 w-full flex items-center justify-center p-4">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-medium text-neutral-700 dark:text-gray-300">Salesforce</span>
                                        <p class="text-xs text-neutral-500 dark:text-gray-500 mt-1">CRM & Sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Indicateurs de navigation -->
                        <div class="flex justify-center mt-4 space-x-2">
                            <button class="sponsor-dot w-2 h-2 rounded-full bg-[#073066] transition-all duration-200"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
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
                        <button onclick="eventFilters.clearAllFilters()" class="mt-4 inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347] transition-colors">
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

    // Carrousel des sponsors
    const sponsorsCarousel = {
        currentSlide: 0,
        totalSlides: 8, // Nombre total de sponsors
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
                    dot.classList.add('bg-[#073066]');
                } else {
                    dot.classList.remove('bg-[#073066]');
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
</script>
@endpush

@endsection