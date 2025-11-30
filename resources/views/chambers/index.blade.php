@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            @auth
            <!-- Card Profil Complet -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/10 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                <!-- Header avec dégradé -->
                <div class="h-20 bg-gradient-to-r from-[#2563eb] to-[#1e40af] relative">
                    <div class="absolute -bottom-10 left-4">
                        @if(Auth::user()->avatar || Auth::user()->profile_photo_path)
                            <div class="relative w-20 h-20 rounded-xl border-4 border-white dark:border-gray-800 shadow-lg overflow-hidden">
                                <img src="{{ asset('storage/' . (Auth::user()->avatar ?? Auth::user()->profile_photo_path)) }}" 
                                     alt="{{ Auth::user()->name }}"
                                     class="w-full h-full object-cover">
                                <!-- Badge online -->
                                <div class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                            </div>
                        @else
                            <div class="relative w-20 h-20 rounded-xl border-4 border-white dark:border-gray-800 shadow-lg bg-gradient-to-br from-[#2563eb] to-[#1e40af] flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                </span>
                                <!-- Badge online -->
                                <div class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contenu du profil -->
                <div class="pt-14 px-4 pb-4">
                    <!-- Nom et info utilisateur -->
                    <div class="mb-4">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white truncate mb-1" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </h2>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-neutral-600 dark:text-gray-400">
                                <i data-lucide="mail" class="h-3.5 w-3.5 flex-shrink-0"></i>
                                <span class="truncate">{{ Auth::user()->email }}</span>
                            </div>
                            @if(Auth::user()->company)
                            <div class="flex items-center gap-2 text-xs text-neutral-600 dark:text-gray-400">
                                <i data-lucide="building-2" class="h-3.5 w-3.5 flex-shrink-0"></i>
                                <span class="truncate">{{ Auth::user()->company }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Séparateur -->
                    <div class="h-px bg-neutral-200 dark:bg-gray-700 mb-4"></div>

                    <!-- Statistiques cliquables -->
                    <div class="space-y-2.5">
                        <a href="{{ route('my-chambers') }}" class="flex items-center justify-between p-3 rounded-lg bg-white/50 dark:bg-gray-700/30 border border-neutral-100 dark:border-gray-600/50 hover:bg-white dark:hover:bg-gray-700/50 hover:border-blue-200 dark:hover:border-blue-500 cursor-pointer group transition-all">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i data-lucide="building" class="h-4 w-4 text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Chambres rejointes</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $userChambersCount ?? 0 }}</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 text-neutral-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('events.my-bookings') }}" class="flex items-center justify-between p-3 rounded-lg bg-white/50 dark:bg-gray-700/30 border border-neutral-100 dark:border-gray-600/50 hover:bg-white dark:hover:bg-gray-700/50 hover:border-green-200 dark:hover:border-green-500 cursor-pointer group transition-all">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/30 dark:to-green-800/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i data-lucide="calendar-check" class="h-4 w-4 text-green-600 dark:text-green-400"></i>
                                </div>
                                <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Événements participés</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent">{{ $participatedEventsCount ?? 0 }}</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 text-neutral-400 dark:text-gray-500 group-hover:text-green-600 dark:group-hover:text-green-400 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @else
            <!-- Section Investir en RDC - Pour les utilisateurs non connectés -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Investir en RDC</h2>
                <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Découvrez les opportunités d'investissement.
                </p>
                <div class="mt-4 space-y-3">
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#073066] text-white flex items-center justify-center text-xs font-semibold">
                            1</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Explorez les chambres de commerce
                            sectorielles pour
                            identifier les opportunités d'investissement</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#fcb357] text-white flex items-center justify-center text-xs font-semibold">
                            2</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Connectez-vous avec des entrepreneurs
                            locaux et des
                            partenaires stratégiques</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#073066] text-white flex items-center justify-center text-xs font-semibold">
                            3</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Participez aux événements et forums
                            d'affaires pour étendre
                            votre réseau</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#fcb357] text-white flex items-center justify-center text-xs font-semibold">
                            4</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Accédez aux informations réglementaires
                            et aux conseils
                            d'experts locaux</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#073066] text-white flex items-center justify-center text-xs font-semibold">
                            5</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Bénéficiez de l'accompagnement
                            personnalisé pour concrétiser
                            vos projets d'investissement</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-neutral-200 dark:border-gray-700">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 w-full justify-center rounded-md bg-[#073066] px-3 py-2 text-xs font-semibold text-white hover:bg-[#052347] transition-colors">
                        <i data-lucide="user-plus" class="h-3 w-3"></i>
                        Rejoindre maintenant
                    </a>
                </div>
            </div>
            @endauth

            <!-- Carrousel des Partenaires -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Nos Partenaires</h2>
                            <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Institutions qui nous font confiance</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-[#073066]/10 dark:bg-[#073066]/20 flex items-center justify-center">
                            <i data-lucide="handshake" class="h-4 w-4 text-[#073066] dark:text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="relative overflow-hidden rounded-lg bg-gradient-to-br from-neutral-50 to-white dark:from-gray-700/30 dark:to-gray-800/30">
                        <div class="carousel-container flex transition-transform duration-500 ease-in-out" id="partners-carousel">
                            @php
                            $partners = [
                                ['name' => 'FPI', 'logo' => 'fpi.png'],
                                ['name' => 'ANAPI', 'logo' => 'anapi.png'],
                                ['name' => 'ANADEC', 'logo' => 'anadec.png'],
                                ['name' => 'BCC', 'logo' => 'bcc.png'],
                                ['name' => 'DGI', 'logo' => 'dgi.png'],
                                ['name' => 'DGDA', 'logo' => 'dgda.jpg'],
                                ['name' => 'Commerce', 'logo' => 'commerce.png'],
                                ['name' => 'SEGUCE', 'logo' => 'seguce.png'],
                                ['name' => 'AZES', 'logo' => 'azes.jpg'],
                                ['name' => 'ZELCAF', 'logo' => 'zelcaf.jpg'],
                            ];
                            @endphp

                            @foreach($partners as $partner)
                            <!-- {{ $partner['name'] }} -->
                            <div class="carousel-slide flex-shrink-0 w-full flex items-center justify-center p-6">
                                <div class="flex flex-col items-center space-y-3 group">
                                    <div class="relative w-24 h-24 rounded-xl bg-white dark:bg-gray-700 border-2 border-neutral-100 dark:border-gray-600 flex items-center justify-center p-3 shadow-sm group-hover:shadow-md group-hover:border-[#073066]/30 dark:group-hover:border-blue-500/30 transition-all duration-300">
                                        <img src="{{ asset('img/partenaires/' . $partner['logo']) }}" 
                                             alt="{{ $partner['name'] }}" 
                                             class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105">
                                        <!-- Shine effect on hover -->
                                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/0 to-transparent group-hover:via-white/10 transition-all duration-300 rounded-xl"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-neutral-700 dark:text-gray-300 group-hover:text-[#073066] dark:group-hover:text-blue-400 transition-colors duration-300">
                                        {{ $partner['name'] }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Navigation Arrows -->
                        <button id="prev-partner" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 shadow-md flex items-center justify-center hover:bg-[#073066] hover:border-[#073066] dark:hover:bg-[#073066] hover:text-white transition-all duration-200 group z-10">
                            <i data-lucide="chevron-left" class="h-4 w-4 text-neutral-600 dark:text-gray-300 group-hover:text-white"></i>
                        </button>
                        <button id="next-partner" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-gray-700 border border-neutral-200 dark:border-gray-600 shadow-md flex items-center justify-center hover:bg-[#073066] hover:border-[#073066] dark:hover:bg-[#073066] hover:text-white transition-all duration-200 group z-10">
                            <i data-lucide="chevron-right" class="h-4 w-4 text-neutral-600 dark:text-gray-300 group-hover:text-white"></i>
                        </button>

                        <!-- Indicateurs de navigation -->
                        <div class="flex justify-center mt-4 space-x-1.5 pb-2">
                            @foreach($partners as $index => $partner)
                            <button class="carousel-dot w-1.5 h-1.5 rounded-full transition-all duration-200 {{ $index === 0 ? 'bg-[#073066] w-6' : 'bg-neutral-300 dark:bg-gray-600 hover:bg-neutral-400 dark:hover:bg-gray-500' }}" data-slide="{{ $index }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:col-span-6 space-y-6">
        <div class="space-y-4">
            <div class="relative">
                <span
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 dark:text-gray-500 dark:text-gray-400">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </span>
                <input type="text" id="search-input"
                    placeholder="Rechercher une chambre par nom, pays ou secteur d'activité..."
                    class="w-full rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-4 py-3 text-sm text-neutral-800 dark:text-gray-100 placeholder:text-neutral-400 dark:text-gray-500 dark:text-gray-400 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-neutral-700 dark:text-gray-300">Filtres rapides:</span>
                <button data-filter="most-active"
                    class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                    <i data-lucide="trending-up" class="h-3 w-3 mr-1"></i>
                    Les plus actives
                </button>
                <button data-filter="recently-created"
                    class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                    <i data-lucide="sparkles" class="h-3 w-3 mr-1"></i>
                    Récemment créées
                </button>
                <button data-filter="upcoming-events"
                    class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                    <i data-lucide="calendar-days" class="h-3 w-3 mr-1"></i>
                    Événements à venir
                </button>
                <button data-filter="certified"
                    class="filter-btn inline-flex items-center rounded-full bg-neutral-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600 transition-colors">
                    <i data-lucide="shield-check" class="h-3 w-3 mr-1"></i>
                    Agréée</button>
                <button data-filter="all" id="clear-filters"
                    class="filter-btn inline-flex items-center rounded-full bg-[#073066] px-3 py-1 text-xs font-medium text-white hover:bg-[#052347] transition-colors"
                    style="display: none;">
                    <i data-lucide="x" class="h-3 w-3 mr-1"></i>
                    Effacer filtres
                </button>
            </div>
        </div>

        <!-- Chambers List -->
        <div class="space-y-3" id="chambers-list">
            @foreach($chambers as $chamber)
            <div class="chamber-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-blue-200 dark:hover:border-blue-800 hover:shadow-md transition-all duration-200 overflow-hidden"
                data-name="{{ strtolower($chamber['name']) }}"
                data-description="{{ strtolower($chamber['description']) }}"
                data-activity-level="{{ $chamber['activity_level'] }}"
                data-events-count="{{ $chamber['upcoming_events'] }}"
                data-members-count="{{ $chamber['members_count'] }}"
                data-certified="{{ $chamber['is_certified'] ? 'true' : 'false' }}"
                data-created="{{ isset($chamber['created_at']) ? $chamber['created_at'] : '2024-01-01' }}">

                <div class="p-5">
                    <div class="flex items-start gap-4">
                        <!-- Logo -->
                        <div class="flex-shrink-0 relative">
                            @auth
                            <a href="{{ route('chamber.show', $chamber['slug']) }}" class="block">
                                @else
                                <button onclick="openModal('signin-modal')" class="block">
                                    @endauth
                                    @if($chamber['logo_path'])
                                    <div
                                        class="relative w-16 h-16 rounded-xl overflow-hidden bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600">
                                        <img src="{{ asset('storage/' . $chamber['logo_path']) }}"
                                            alt="{{ $chamber['name'] }}" class="w-full h-full object-cover">
                                    </div>
                                    @else
                                    <div
                                        class="relative w-16 h-16 rounded-xl bg-blue-600 flex items-center justify-center">
                                        <span class="text-white text-xl font-bold">{{ substr($chamber['code'], 0, 2)
                                            }}</span>
                                    </div>
                                    @endif
                                    @auth
                            </a>
                            @else
                            </button>
                            @endauth
                            @if($chamber['is_certified'])
                            <div
                                class="absolute -bottom-1 -right-1 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center border-2 border-white dark:border-gray-800">
                                <i data-lucide="shield-check" class="h-3 w-3 text-white"></i>
                            </div>
                            @endif
                        </div>

                        <!-- Contenu -->
                        <div class="flex-1 min-w-0">
                            <!-- En-tête -->
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex-1 min-w-0">
                                    @auth
                                    <a href="{{ route('chamber.show', $chamber['slug']) }}"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $chamber['name'] }}
                                        </h3>
                                    </a>
                                    @else
                                    <button onclick="openModal('signin-modal')"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-left w-full">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $chamber['name'] }}
                                        </h3>
                                    </button>
                                    @endauth
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $chamber['code'] }}
                                    </p>
                                </div>

                                <!-- Bouton Adhérer / Badge Membre -->
                                <div class="flex-shrink-0">
                                    @auth
                                    @php
                                    $isMember = auth()->user()->chambers()->where('chambers.id', $chamber['id'] ??
                                    0)->exists();
                                    @endphp

                                    @if(!$isMember)
                                    <form action="{{ route('chambers.members.join', $chamber['slug']) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-4 py-1.5 text-xs font-medium text-white hover:bg-blue-700 transition-all duration-200">
                                            <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                            Adhérer
                                        </button>
                                    </form>
                                    @else
                                    <div
                                        class="inline-flex items-center gap-1.5 rounded-full bg-green-50 dark:bg-green-900/30 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400">
                                        <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                        Membre
                                    </div>
                                    @endif
                                    @else
                                    <button onclick="openModal('signin-modal')"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-4 py-1.5 text-xs font-medium text-white hover:bg-blue-700 transition-all duration-200">
                                        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                        Adhérer
                                    </button>
                                    @endauth
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                                {{ $chamber['description'] }}
                            </p>

                            <!-- Métadonnées -->
                            <div
                                class="flex items-center flex-wrap gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="inline-flex items-center gap-1.5">
                                    <i data-lucide="users" class="h-3.5 w-3.5"></i>
                                    {{ number_format($chamber['members_count']) }} membres
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                                    {{ $chamber['upcoming_events'] }} événements
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                                    {{ $chamber['location'] ?? 'Non spécifiée' }}
                                </span>
                                @if($chamber['is_certified'])
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-orange-50 dark:bg-orange-900/30 px-2 py-0.5 text-xs font-medium text-orange-700 dark:text-orange-400">
                                    <i data-lucide="shield-check" class="h-3 w-3"></i>
                                    Agréée
                                </span>
                                @endif
                                @if($chamber['upcoming_events'] > 0 && $chamber['activity_level'] === 'Très active')
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-400">
                                    Modérée
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Indicateur de chargement -->
        <div id="loading-indicator" class="hidden text-center py-8">
            <div class="inline-flex items-center gap-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-[#073066]"></div>
                <span class="text-sm text-neutral-600 dark:text-gray-400">Chargement des chambres...</span>
            </div>
        </div>

        <!-- Message de fin -->
        <div id="end-message" class="hidden text-center py-8">
            <div class="text-sm text-neutral-500 dark:text-gray-500">
                <i data-lucide="check-circle" class="h-5 w-5 inline mr-2"></i>
                Toutes les chambres ont été chargées
            </div>
        </div>
    </main>

    <!-- Sidebar Droite - Événements du Mois -->
    <aside class="lg:col-span-3">
        <div class="space-y-4">
            <!-- Section Événements du Mois -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Événements du Mois</h2>
                        <span
                            class="inline-flex items-center rounded-full bg-[#073066]/10 px-2 py-1 text-xs font-medium text-[#073066] dark:text-blue-400">
                            {{ now()->format('M Y') }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Les 5 événements les plus populaires</p>
                </div>
                <div class="p-4 space-y-4">
                    @if($monthlyEvents->count() > 0)
                    @foreach($monthlyEvents->take(3) as $event)
                    <div
                        class="group rounded-lg border border-neutral-100 dark:border-gray-600 dark:border-gray-400 p-3 hover:border-[#073066] dark:border-blue-500/20 hover:bg-[#073066]/5 transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                @if($event['type'] === 'forum')
                                <div class="w-8 h-8 rounded-lg bg-[#073066]/10 flex items-center justify-center">
                                    <i data-lucide="users" class="h-4 w-4 text-[#073066] dark:text-blue-400"></i>
                                </div>
                                @elseif($event['type'] === 'atelier')
                                <div class="w-8 h-8 rounded-lg bg-[#fcb357]/10 flex items-center justify-center">
                                    <i data-lucide="wrench" class="h-4 w-4 text-[#fcb357]"></i>
                                </div>
                                @elseif($event['type'] === 'networking')
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                    <i data-lucide="network" class="h-4 w-4 text-green-600"></i>
                                </div>
                                @elseif($event['type'] === 'conference')
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i data-lucide="presentation" class="h-4 w-4 text-purple-600"></i>
                                </div>
                                @else
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i data-lucide="calendar" class="h-4 w-4 text-blue-600"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="text-sm font-medium text-neutral-900 dark:text-white group-hover:text-[#073066] dark:group-hover:text-blue-400 transition-colors">
                                    {{ $event['title'] }}
                                </h4>
                                <div
                                    class="mt-1 flex items-center gap-2 text-xs text-neutral-500 dark:text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="building-2" class="h-3 w-3"></i>
                                        {{ $event['chamber'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="calendar" class="h-3 w-3"></i>
                                        {{ $event['date'] }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-neutral-600 dark:text-gray-400">
                                        <i data-lucide="users" class="h-3 w-3"></i>
                                        {{ $event['participants'] }} participants
                                    </span>
                                    <button
                                        class="text-xs text-[#073066] dark:text-blue-400 hover:text-[#052347] font-medium transition-colors">
                                        Voir plus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-8">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 dark:text-gray-400 mx-auto mb-4">
                            <i data-lucide="calendar-x" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-2">Aucun événement ce mois
                        </h3>
                        <p class="text-xs text-neutral-600 dark:text-gray-400 mb-4">Aucun événement prévu pour {{
                            now()->format('F Y') }}.
                        </p>
                        <a href="{{ route('events') }}"
                            class="inline-flex items-center gap-1 text-xs text-[#073066] dark:text-blue-400 hover:text-[#052347] font-medium transition-colors">
                            <i data-lucide="calendar-plus" class="h-3 w-3"></i>
                            Voir tous les événements
                        </a>
                    </div>
                    @endif
                </div>
                <div class="border-t border-neutral-200 dark:border-gray-700 p-4">
                    <a href="{{ route('events') }}"
                        class="inline-flex items-center gap-2 w-full justify-center rounded-md bg-[#073066] px-3 py-2 text-xs font-semibold text-white hover:bg-[#052347] transition-colors">
                        <i data-lucide="calendar-plus" class="h-3 w-3"></i>
                        Voir tous les événements
                    </a>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        
        // Variables globales
        const searchInput = document.getElementById('search-input');
        const chamberCards = document.querySelectorAll('.chamber-card');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const clearFiltersBtn = document.getElementById('clear-filters');
        let activeFilter = 'all';
        
        // Fonction de recherche
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;
            
            chamberCards.forEach(card => {
                const name = card.dataset.name;
                const description = card.dataset.description;
                
                // Vérifier si la carte correspond à la recherche
                const matchesSearch = searchTerm === '' || 
                    name.includes(searchTerm) || 
                    description.includes(searchTerm);
                
                // Vérifier si la carte correspond au filtre actif
                const matchesFilter = applyFilter(card, activeFilter);
                
                // Afficher/masquer la carte
                const shouldShow = matchesSearch && matchesFilter;
                card.style.display = shouldShow ? 'block' : 'none';
                
                if (shouldShow) visibleCount++;
            });
            
            // Afficher un message si aucun résultat
            showNoResultsMessage(visibleCount === 0);
        }
        
        // Fonction d'application des filtres
        function applyFilter(card, filter) {
            switch (filter) {
                case 'most-active':
                    return card.dataset.activityLevel === 'Très active';
                case 'recently-created':
                    // Simuler les chambres récemment créées (derniers 6 mois)
                    const createdDate = new Date(card.dataset.created);
                    const sixMonthsAgo = new Date();
                    sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);
                    return createdDate > sixMonthsAgo;
                case 'upcoming-events':
                    return parseInt(card.dataset.eventsCount) > 0;
                case 'certified':
                    return card.dataset.certified === 'true';
                case 'all':
                default:
                    return true;
            }
        }
        
        // Fonction pour afficher/masquer le message "Aucun résultat"
        function showNoResultsMessage(show) {
            let noResultsDiv = document.getElementById('no-results-message');
            
            if (show && !noResultsDiv) {
                // Créer le message s'il n'existe pas
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'no-results-message';
                noResultsDiv.className = 'text-center py-12';
                noResultsDiv.innerHTML = `
                    <div class="mx-auto max-w-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 dark:text-gray-400 mx-auto mb-4">
                            <i data-lucide="search" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucune chambre trouvée</h3>
                        <p class="text-sm text-neutral-600 dark:text-gray-400">Essayez de modifier vos critères de recherche ou vos filtres.</p>
                        <button onclick="clearAllFilters()" class="mt-4 inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347] transition-colors">
                            <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                            Réinitialiser
                        </button>
                    </div>
                `;
                document.getElementById('chambers-list').appendChild(noResultsDiv);
                lucide.createIcons();
            } else if (!show && noResultsDiv) {
                noResultsDiv.remove();
            }
        }
        
        // Fonction pour effacer tous les filtres
        window.clearAllFilters = function() {
            searchInput.value = '';
            activeFilter = 'all';
            updateFilterButtons();
            performSearch();
        };
        
        // Fonction pour mettre à jour l'apparence des boutons de filtre
        function updateFilterButtons() {
            filterButtons.forEach(btn => {
                const isActive = btn.dataset.filter === activeFilter;
                
                if (btn.id === 'clear-filters') {
                    btn.style.display = activeFilter !== 'all' || searchInput.value.trim() !== '' ? 'inline-flex' : 'none';
                } else {
                    // Réinitialiser les classes
                    btn.className = btn.className.replace(/bg-\[#[^\]]+\]/g, '').replace(/text-\[#[^\]]+\]/g, '');
                    
                    if (isActive && activeFilter !== 'all') {
                        btn.className += ' bg-[#073066] text-white';
                    } else {
                        btn.className += ' bg-neutral-100 dark:bg-gray-700 text-neutral-700 dark:text-gray-300 hover:bg-neutral-200 dark:hover:bg-gray-600';
                    }
                }
            });
        }
        
        // Event listeners
        searchInput.addEventListener('input', performSearch);
        
        // Gestion des filtres rapides
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;
                
                if (filter === 'all') {
                    clearAllFilters();
                } else {
                    activeFilter = activeFilter === filter ? 'all' : filter;
                    updateFilterButtons();
                    performSearch();
                }
            });
        });
        
        // Initialisation
        updateFilterButtons();
        
        // Fonction de debounce pour optimiser la recherche
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        // Appliquer le debounce à la recherche
        const debouncedSearch = debounce(performSearch, 300);
        searchInput.removeEventListener('input', performSearch);
        searchInput.addEventListener('input', debouncedSearch);
        
        // Animation d'entrée pour les cartes
        function animateCards() {
            chamberCards.forEach((card, index) => {
                if (card.style.display !== 'none') {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 50);
                }
            });
        }
        
        // Animer les cartes au chargement
        setTimeout(animateCards, 100);
        
        // Gestion du carrousel des partenaires
        const carousel = document.getElementById('partners-carousel');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prev-partner');
        const nextBtn = document.getElementById('next-partner');
        let currentSlide = 0;
        const totalSlides = 10; // 10 partenaires
        let carouselInterval;
        
        // Fonction pour aller à une slide spécifique
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            const translateX = -slideIndex * 100;
            carousel.style.transform = `translateX(${translateX}%)`;
            
            // Mettre à jour les indicateurs
            dots.forEach((dot, index) => {
                if (index === slideIndex) {
                    dot.classList.remove('bg-neutral-300', 'dark:bg-gray-600', 'w-1.5');
                    dot.classList.add('bg-[#073066]', 'w-6');
                } else {
                    dot.classList.remove('bg-[#073066]', 'w-6');
                    dot.classList.add('bg-neutral-300', 'dark:bg-gray-600', 'w-1.5');
                }
            });
        }
        
        // Fonction pour aller à la slide suivante
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }
        
        // Fonction pour aller à la slide précédente
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }
        
        // Démarrer le carrousel automatique
        function startCarousel() {
            carouselInterval = setInterval(nextSlide, 3500); // Change toutes les 3.5 secondes
        }
        
        // Arrêter le carrousel automatique
        function stopCarousel() {
            clearInterval(carouselInterval);
        }
        
        // Event listeners pour les indicateurs
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                stopCarousel();
                goToSlide(index);
                setTimeout(startCarousel, 5000); // Redémarre après 5 secondes
            });
        });
        
        // Event listeners pour les boutons de navigation
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopCarousel();
                prevSlide();
                setTimeout(startCarousel, 5000);
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopCarousel();
                nextSlide();
                setTimeout(startCarousel, 5000);
            });
        }
        
        // Pause au survol du carrousel
        const carouselContainer = carousel.parentElement;
        carouselContainer.addEventListener('mouseenter', stopCarousel);
        carouselContainer.addEventListener('mouseleave', startCarousel);
        
        // Démarrer le carrousel
        startCarousel();
    });

    // Variables pour le lazy loading
    let currentPage = 1;
    let isLoading = false;
    let hasMoreChambers = true;

    // Fonction pour charger plus de chambres
    async function loadMoreChambers() {
        if (isLoading || !hasMoreChambers) return;

        isLoading = true;
        document.getElementById('loading-indicator').classList.remove('hidden');

        try {
            const response = await fetch(`{{ route('chambers') }}?page=${currentPage + 1}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Erreur de chargement');

            const data = await response.json();
            
            if (data.chambers && data.chambers.length > 0) {
                // Ajouter les nouvelles chambres au DOM
                const chambersList = document.getElementById('chambers-list');
                
                data.chambers.forEach(chamber => {
                    const chamberHtml = createChamberCard(chamber);
                    chambersList.insertAdjacentHTML('beforeend', chamberHtml);
                });

                currentPage++;
                hasMoreChambers = data.hasMore;

                // Réinitialiser les icônes Lucide pour les nouvelles cartes
                lucide.createIcons();
            } else {
                hasMoreChambers = false;
            }

            if (!hasMoreChambers) {
                document.getElementById('end-message').classList.remove('hidden');
            }

        } catch (error) {
            console.error('Erreur lors du chargement des chambres:', error);
        } finally {
            isLoading = false;
            document.getElementById('loading-indicator').classList.add('hidden');
        }
    }

    // Fonction pour créer le HTML d'une carte de chambre
    function createChamberCard(chamber) {
        const isMember = chamber.is_subscribed;
        const isAuth = {{ auth()->check() ? 'true' : 'false' }};
        
        return `
            <div class="chamber-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-blue-200 dark:hover:border-blue-800 hover:shadow-md transition-all duration-200 overflow-hidden"
                data-name="${chamber.name.toLowerCase()}"
                data-description="${chamber.description.toLowerCase()}"
                data-activity-level="${chamber.activity_level}"
                data-events-count="${chamber.upcoming_events}"
                data-members-count="${chamber.members_count}"
                data-certified="${chamber.is_certified ? 'true' : 'false'}"
                data-created="${chamber.created_at}">
                
                <div class="p-5">
                    <div class="flex items-start gap-4">
                        <!-- Logo -->
                        <div class="flex-shrink-0 relative">
                            ${isAuth ? `<a href="/chamber/${chamber.slug}" class="block">` : `<button onclick="openModal('signin-modal')" class="block">`}
                                ${chamber.logo_path ? `
                                    <div class="relative w-16 h-16 rounded-xl overflow-hidden bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600">
                                        <img src="/storage/${chamber.logo_path}"
                                            alt="${chamber.name}"
                                            class="w-full h-full object-cover">
                                    </div>
                                ` : `
                                    <div class="relative w-16 h-16 rounded-xl bg-blue-600 flex items-center justify-center">
                                        <span class="text-white text-xl font-bold">${chamber.code.substring(0, 2)}</span>
                                    </div>
                                `}
                            ${isAuth ? '</a>' : '</button>'}
                            ${chamber.is_certified ? `
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center border-2 border-white dark:border-gray-800">
                                    <i data-lucide="shield-check" class="h-3 w-3 text-white"></i>
                                </div>
                            ` : ''}
                        </div>

                        <!-- Contenu -->
                        <div class="flex-1 min-w-0">
                            <!-- En-tête -->
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex-1 min-w-0">
                                    ${isAuth ? `
                                        <a href="/chamber/${chamber.slug}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                                ${chamber.name}
                                            </h3>
                                        </a>
                                    ` : `
                                        <button onclick="openModal('signin-modal')" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-left w-full">
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                                ${chamber.name}
                                            </h3>
                                        </button>
                                    `}
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                        ${chamber.code}
                                    </p>
                                </div>

                                <!-- Bouton Adhérer / Badge Membre -->
                                <div class="flex-shrink-0">
                                    ${isAuth ? (
                                        !isMember ? `
                                            <form action="/chambers/${chamber.slug}/join" method="POST" class="inline">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-4 py-1.5 text-xs font-medium text-white hover:bg-blue-700 transition-all duration-200">
                                                    <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                                    Adhérer
                                                </button>
                                            </form>
                                        ` : `
                                            <div class="inline-flex items-center gap-1.5 rounded-full bg-green-50 dark:bg-green-900/30 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400">
                                                <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                                Membre
                                            </div>
                                        `
                                    ) : `
                                        <button onclick="openModal('signin-modal')"
                                            class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-4 py-1.5 text-xs font-medium text-white hover:bg-blue-700 transition-all duration-200">
                                            <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                            Adhérer
                                        </button>
                                    `}
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                                ${chamber.description}
                            </p>

                            <!-- Métadonnées -->
                            <div class="flex items-center flex-wrap gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="inline-flex items-center gap-1.5">
                                    <i data-lucide="users" class="h-3.5 w-3.5"></i>
                                    ${chamber.members_count.toLocaleString()} membres
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                                    ${chamber.upcoming_events} événements
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                                    ${chamber.location || 'Non spécifiée'}
                                </span>
                                ${chamber.is_certified ? `
                                    <span class="inline-flex items-center gap-1 rounded-full bg-orange-50 dark:bg-orange-900/30 px-2 py-0.5 text-xs font-medium text-orange-700 dark:text-orange-400">
                                        <i data-lucide="shield-check" class="h-3 w-3"></i>
                                        Agréée
                                    </span>
                                ` : ''}
                                ${chamber.upcoming_events > 0 && chamber.activity_level === 'Très active' ? `
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-400">
                                        Modérée
                                    </span>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Observer pour détecter quand l'utilisateur arrive en bas de page
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && hasMoreChambers && !isLoading) {
                loadMoreChambers();
            }
        });
    }, {
        rootMargin: '100px' // Commencer à charger 100px avant d'atteindre le bas
    });

    // Observer le dernier élément de la liste
    document.addEventListener('DOMContentLoaded', function() {
        const chambersList = document.getElementById('chambers-list');
        if (chambersList.children.length > 0) {
            observer.observe(chambersList.lastElementChild);
        }

        // Réobserver le dernier élément après chaque chargement
        const originalLoadMore = loadMoreChambers;
        loadMoreChambers = async function() {
            await originalLoadMore();
            
            // Observer le nouveau dernier élément
            const newLastElement = chambersList.lastElementChild;
            if (newLastElement && hasMoreChambers) {
                observer.observe(newLastElement);
            }
        };
    });
</script>
@endpush
@endsection

