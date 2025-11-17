@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            @auth
            <!-- Section Mon rôle - Seulement pour les utilisateurs connectés -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Mon rôle</h2>
                <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Contrôlez la portée et les actions.</p>
                <div class="mt-3">
                    @if(Auth::user()->isSuperAdmin())
                    <span
                        class="inline-flex items-center rounded-md bg-[#b81010]/10 px-2 py-1 text-xs font-medium text-[#b81010]">Super
                        admin</span>
                    @elseif(Auth::user()->isChamberManager())
                    <span
                        class="inline-flex items-center rounded-md bg-[#fcb357]/10 px-2 py-1 text-xs font-medium text-[#fcb357]">Gestionnaire</span>
                    @else
                    <span
                        class="inline-flex items-center rounded-md bg-[#073066]/10 px-2 py-1 text-xs font-medium text-[#073066] dark:text-blue-400">Utilisateur</span>
                    @endif
                </div>
                <div class="mt-2">
                    <span class="text-xs text-neutral-600 dark:text-gray-400">
                        @if(Auth::user()->isSuperAdmin())
                        Accès global aux chambres
                        @elseif(Auth::user()->isChamberManager())
                        Gestion des chambres assignées
                        @else
                        Membre des chambres
                        @endif
                    </span>
                </div>
            </div>
            @else
            <!-- Section Investir en RDC - Pour les utilisateurs non connectés -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Investir en RDC</h2>
                <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Découvrez les opportunités d'investissement.</p>
                <div class="mt-4 space-y-3">
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#073066] text-white flex items-center justify-center text-xs font-semibold">
                            1</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Explorez les chambres de commerce sectorielles pour
                            identifier les opportunités d'investissement</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#fcb357] text-white flex items-center justify-center text-xs font-semibold">
                            2</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Connectez-vous avec des entrepreneurs locaux et des
                            partenaires stratégiques</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#073066] text-white flex items-center justify-center text-xs font-semibold">
                            3</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Participez aux événements et forums d'affaires pour étendre
                            votre réseau</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#fcb357] text-white flex items-center justify-center text-xs font-semibold">
                            4</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Accédez aux informations réglementaires et aux conseils
                            d'experts locaux</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#073066] text-white flex items-center justify-center text-xs font-semibold">
                            5</div>
                        <p class="text-xs text-neutral-700 dark:text-gray-300">Bénéficiez de l'accompagnement personnalisé pour concrétiser
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
                    <h2 class="text-sm font-semibold text-[#073066] dark:text-blue-400">Nos Partenaires</h2>
                    <p class="mt-1 text-xs text-neutral-600 dark:text-gray-400">Grandes marques qui nous font confiance</p>
                </div>
                <div class="p-4">
                    <div class="relative overflow-hidden">
                        <div class="carousel-container flex transition-transform duration-500 ease-in-out"
                            id="partners-carousel">
                            <!-- Logo 1 - Microsoft -->
                            <div class="carousel-slide flex-shrink-0 w-full flex items-center justify-center p-6">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.4 24H0V12.6h11.4V24zM24 24H12.6V12.6H24V24zM11.4 11.4H0V0h11.4v11.4zM24 11.4H12.6V0H24v11.4z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Microsoft</span>
                                </div>
                            </div>

                            <!-- Logo 2 - Google -->
                            <div class="carousel-slide flex-shrink-0 w-full flex items-center justify-center p-6">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-red-500 via-yellow-500 to-blue-500 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">G</span>
                                    </div>
                                    <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Google</span>
                                </div>
                            </div>

                            <!-- Logo 3 - Amazon -->
                            <div class="carousel-slide flex-shrink-0 w-full flex items-center justify-center p-6">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M.045 18.02c.072-.116.187-.124.348-.022 3.636 2.11 7.594 3.166 11.87 3.166 2.852 0 5.668-.533 8.447-1.595l.315-.14c.138-.06.234-.1.293-.13.226-.088.39-.046.525.13.12.174.09.336-.12.48-.256.19-.6.41-1.006.654-1.244.743-2.64 1.316-4.185 1.726-1.548.41-3.156.615-4.83.615-2.424 0-4.73-.315-6.914-.946-2.185-.63-4.17-1.54-5.955-2.73-.195-.13-.285-.285-.225-.465l.437-.743z" />
                                            <path
                                                d="M18.78 16.826c-.885-.442-2.942-.21-4.067.066-.344.084-.398-.258-.043-.473 1.988-1.4 5.248-1.004 5.63-.53.382.472-.1 3.74-1.963 5.3-.32.267-.625.125-.483-.23.465-1.16 1.51-3.75.926-4.133z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Amazon</span>
                                </div>
                            </div>

                            <!-- Logo 4 - Apple -->
                            <div class="carousel-slide flex-shrink-0 w-full flex items-center justify-center p-6">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Apple</span>
                                </div>
                            </div>

                            <!-- Logo 5 - Meta -->
                            <div class="carousel-slide flex-shrink-0 w-full flex items-center justify-center p-6">
                                <div class="flex flex-col items-center space-y-3">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">M</span>
                                    </div>
                                    <span class="text-xs font-medium text-neutral-700 dark:text-gray-300">Meta</span>
                                </div>
                            </div>
                        </div>

                        <!-- Indicateurs de navigation -->
                        <div class="flex justify-center mt-4 space-x-2">
                            <button class="carousel-dot w-2 h-2 rounded-full bg-[#073066] transition-all duration-200"
                                data-slide="0"></button>
                            <button
                                class="carousel-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="1"></button>
                            <button
                                class="carousel-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="2"></button>
                            <button
                                class="carousel-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="3"></button>
                            <button
                                class="carousel-dot w-2 h-2 rounded-full bg-neutral-300 hover:bg-neutral-400 transition-all duration-200"
                                data-slide="4"></button>
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
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 dark:text-gray-500 dark:text-gray-400">
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
        <div class="space-y-4" id="chambers-list">
            @foreach($chambers as $chamber)
            <div class="chamber-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 hover:shadow-sm transition-all duration-200 relative"
                data-name="{{ strtolower($chamber['name']) }}"
                data-description="{{ strtolower($chamber['description']) }}"
                data-activity-level="{{ $chamber['activity_level'] }}"
                data-events-count="{{ $chamber['upcoming_events'] }}"
                data-members-count="{{ $chamber['members_count'] }}"
                data-certified="{{ $chamber['is_certified'] ? 'true' : 'false' }}"
                data-created="{{ isset($chamber['created_at']) ? $chamber['created_at'] : '2024-01-01' }}">
                
                <!-- Statut d'adhésion dans le coin supérieur droit -->
                <div class="absolute top-4 right-4">
                    @auth
                        @php
                            // Vérifier si l'utilisateur est déjà membre de cette chambre
                            $isMember = auth()->user()->chambers()->where('chambers.id', $chamber['id'] ?? 0)->exists();
                        @endphp
                        
                        @if(!$isMember)
                            <!-- Bouton Adhérer discret -->
                            <form action="{{ route('chambers.members.join', $chamber['slug']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#073066] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-all duration-200 shadow-sm hover:shadow-md"
                                    title="Adhérer à cette chambre">
                                    <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                    Adhérer
                                </button>
                            </form>
                        @else
                            <!-- Badge membre discret -->
                            <div class="inline-flex items-center gap-1.5 rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800">
                                <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                Membre
                            </div>
                        @endif
                    @else
                        <!-- Bouton pour utilisateurs non connectés -->
                        <button onclick="openModal('signin-modal')"
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#073066] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-all duration-200 shadow-sm hover:shadow-md">
                            <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                            Adhérer
                        </button>
                    @endauth
                </div>

                <div class="flex items-start gap-4 flex-1 pr-20">
                        <div class="relative">
                            @auth
                            <a href="{{ route('chamber.show', $chamber['slug']) }}" class="block">
                                @else
                                <button onclick="openModal('signin-modal')" class="block">
                                    @endauth
                                    @if($chamber['logo_path'])
                                    <img src="{{ asset('storage/' . $chamber['logo_path']) }}"
                                        alt="{{ $chamber['name'] }}"
                                        class="h-14 w-14 rounded-lg object-cover shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                    @else
                                    <div
                                        class="relative flex h-14 w-14 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                        <div class="flex flex-col items-center text-sm font-semibold leading-none">
                                            <span>{{ substr($chamber['code'], 0, 2) }}</span>
                                            <span class="mt-0.5 text-white/80">{{ substr($chamber['code'], -2) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($chamber['is_certified'])
                                    <div class="absolute -right-1 -top-1 rounded-full bg-white dark:bg-gray-800 p-0.5 shadow-sm">
                                        <div
                                            class="flex h-5 w-5 items-center justify-center rounded-full bg-[#fcb357] text-white">
                                            <i data-lucide="shield-check" class="h-3 w-3"></i>
                                        </div>
                                    </div>
                                    @endif
                                    @auth
                            </a>
                            @else
                            </button>
                            @endauth
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                @auth
                                <a href="{{ route('chamber.show', $chamber['slug']) }}"
                                    class="hover:text-[#073066] dark:hover:text-blue-400 transition-colors">
                                    <h3 class="text-base font-medium cursor-pointer">{{ $chamber['name'] }}</h3>
                                </a>
                                @else
                                <button onclick="openModal('signin-modal')"
                                    class="hover:text-[#073066] dark:hover:text-blue-400 transition-colors">
                                    <h3 class="text-base font-medium cursor-pointer">{{ $chamber['name'] }}</h3>
                                </button>
                                @endauth
                                @if($chamber['is_certified'])
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-[#fcb357]/10 px-2 py-0.5 text-xs font-medium text-[#fcb357]"><i
                                        data-lucide="shield-check" class="h-3.5 w-3.5"></i> Agréée</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400 text-justify break-all line-clamp-2 max-h-12 overflow-hidden">
                                {{ Str::limit($chamber['description'], 150, '...') }}
                            </p>
                            <div class="mt-3 space-y-2">
                                <!-- Première ligne : Membres et Événements -->
                                <div class="flex items-center flex-wrap gap-4">
                                    <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                        <i data-lucide="users" class="h-4 w-4 text-neutral-400 dark:text-gray-500 dark:text-gray-400"></i>
                                        {{ number_format($chamber['members_count']) }} membres
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                        <i data-lucide="calendar" class="h-4 w-4 text-neutral-400 dark:text-gray-500 dark:text-gray-400"></i>
                                        {{ $chamber['upcoming_events'] }} événements
                                    </span>
                                    @if($chamber['upcoming_events'] > 0)
                                    <div
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#fcb357]/10 px-2.5 py-1 text-xs font-medium text-[#fcb357]">
                                        <i data-lucide="calendar-clock" class="h-3.5 w-3.5"></i>
                                        {{ $chamber['activity_level'] }}
                                    </div>
                                    @endif
                                </div>

                                <!-- Deuxième ligne : Date de création et Localisation -->
                                <div class="flex items-center flex-wrap gap-4">
                                    <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-500 dark:text-gray-400">
                                        <i data-lucide="calendar-plus" class="h-4 w-4 text-neutral-400 dark:text-gray-500 dark:text-gray-400"></i>
                                        Fondée en
                                        @if($chamber['certification_date'])
                                        {{ \Carbon\Carbon::parse($chamber['certification_date'])->format('Y') }}
                                        @else
                                        {{ \Carbon\Carbon::parse($chamber['created_at'])->format('Y') }}
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-500 dark:text-gray-400">
                                        <i data-lucide="map-pin" class="h-4 w-4 text-neutral-400 dark:text-gray-500 dark:text-gray-400"></i>
                                        {{ $chamber['location'] ?? 'Non spécifiée' }}
                                    </span>
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
                                <div class="mt-1 flex items-center gap-2 text-xs text-neutral-500 dark:text-gray-500 dark:text-gray-400">
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
                                    <span class="inline-flex items-center gap-1 text-xs text-neutral-600 dark:text-gray-400">
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
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-2">Aucun événement ce mois</h3>
                        <p class="text-xs text-neutral-600 dark:text-gray-400 mb-4">Aucun événement prévu pour {{ now()->format('F Y') }}.
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
        let currentSlide = 0;
        const totalSlides = 5;
        let carouselInterval;
        
        // Fonction pour aller à une slide spécifique
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            const translateX = -slideIndex * 100;
            carousel.style.transform = `translateX(${translateX}%)`;
            
            // Mettre à jour les indicateurs
            dots.forEach((dot, index) => {
                if (index === slideIndex) {
                    dot.classList.remove('bg-neutral-300');
                    dot.classList.add('bg-[#073066]');
                } else {
                    dot.classList.remove('bg-[#073066]');
                    dot.classList.add('bg-neutral-300');
                }
            });
        }
        
        // Fonction pour aller à la slide suivante
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }
        
        // Démarrer le carrousel automatique
        function startCarousel() {
            carouselInterval = setInterval(nextSlide, 3000); // Change toutes les 3 secondes
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
            <div class="chamber-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 hover:shadow-sm transition-all duration-200 relative"
                data-name="${chamber.name.toLowerCase()}"
                data-description="${chamber.description.toLowerCase()}"
                data-activity-level="${chamber.activity_level}"
                data-events-count="${chamber.upcoming_events}"
                data-members-count="${chamber.members_count}"
                data-certified="${chamber.is_certified ? 'true' : 'false'}"
                data-created="${chamber.created_at}">
                
                <!-- Statut d'adhésion dans le coin supérieur droit -->
                <div class="absolute top-4 right-4">
                    ${isAuth ? (
                        !isMember ? `
                            <form action="/chambers/${chamber.slug}/join" method="POST" class="inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#073066] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-all duration-200 shadow-sm hover:shadow-md"
                                    title="Adhérer à cette chambre">
                                    <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                    Adhérer
                                </button>
                            </form>
                        ` : `
                            <div class="inline-flex items-center gap-1.5 rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800">
                                <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                Membre
                            </div>
                        `
                    ) : `
                        <button onclick="openModal('signin-modal')"
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#073066] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-all duration-200 shadow-sm hover:shadow-md">
                            <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                            Adhérer
                        </button>
                    `}
                </div>

                <div class="flex items-start gap-4 flex-1 pr-20">
                    <div class="relative">
                        ${isAuth ? `<a href="/chamber/${chamber.slug}" class="block">` : `<button onclick="openModal('signin-modal')" class="block">`}
                            ${chamber.logo_path ? `
                                <img src="/storage/${chamber.logo_path}"
                                    alt="${chamber.name}"
                                    class="h-14 w-14 rounded-lg object-cover shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                            ` : `
                                <div class="relative flex h-14 w-14 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                    <div class="flex flex-col items-center text-sm font-semibold leading-none">
                                        <span>${chamber.code.substring(0, 2)}</span>
                                        <span class="mt-0.5 text-white/80">${chamber.code.substring(chamber.code.length - 2)}</span>
                                    </div>
                                </div>
                            `}
                            ${chamber.is_certified ? `
                                <div class="absolute -right-1 -top-1 rounded-full bg-white dark:bg-gray-800 p-0.5 shadow-sm">
                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-[#fcb357] text-white">
                                        <i data-lucide="shield-check" class="h-3 w-3"></i>
                                    </div>
                                </div>
                            ` : ''}
                        ${isAuth ? '</a>' : '</button>'}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            ${isAuth ? `
                                <a href="/chamber/${chamber.slug}" class="hover:text-[#073066] dark:hover:text-blue-400 transition-colors">
                                    <h3 class="text-base font-medium cursor-pointer">${chamber.name}</h3>
                                </a>
                            ` : `
                                <button onclick="openModal('signin-modal')" class="hover:text-[#073066] dark:hover:text-blue-400 transition-colors">
                                    <h3 class="text-base font-medium cursor-pointer">${chamber.name}</h3>
                                </button>
                            `}
                            ${chamber.is_certified ? `
                                <span class="inline-flex items-center gap-1 rounded-full bg-[#fcb357]/10 px-2 py-0.5 text-xs font-medium text-[#fcb357]">
                                    <i data-lucide="shield-check" class="h-3.5 w-3.5"></i> Agréée
                                </span>
                            ` : ''}
                        </div>
                        <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400 text-justify break-all line-clamp-2 max-h-12 overflow-hidden">
                            ${chamber.description.length > 150 ? chamber.description.substring(0, 150) + '...' : chamber.description}
                        </p>
                        <div class="mt-3 space-y-2">
                            <div class="flex items-center flex-wrap gap-4">
                                <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="users" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                    ${chamber.members_count.toLocaleString()} membres
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="calendar" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                    ${chamber.upcoming_events} événements
                                </span>
                                ${chamber.upcoming_events > 0 ? `
                                    <div class="inline-flex items-center gap-1.5 rounded-full bg-[#fcb357]/10 px-2.5 py-1 text-xs font-medium text-[#fcb357]">
                                        <i data-lucide="calendar-clock" class="h-3.5 w-3.5"></i>
                                        ${chamber.activity_level}
                                    </div>
                                ` : ''}
                            </div>
                            <div class="flex items-center flex-wrap gap-4">
                                <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-400">
                                    <i data-lucide="calendar-plus" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                    Fondée en ${new Date(chamber.created_at).getFullYear()}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-400">
                                    <i data-lucide="map-pin" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                    ${chamber.location || 'Non spécifiée'}
                                </span>
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