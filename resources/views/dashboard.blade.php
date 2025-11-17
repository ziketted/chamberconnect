@extends('layouts.app')

@section('content')
<!-- Barre de recherche principale -->
<div class="mb-6">
    <div class="max-w-2xl mx-auto">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
            </div>
            <input type="text" placeholder="Rechercher une chambre par nom, pays ou secteur d'activité..."
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>
</div>

<!-- Filtres rapides -->
<div class="mb-6">
    <div class="flex justify-center gap-4">
        <button class="inline-flex items-center px-4 py-2 rounded-full bg-blue-600 text-white text-sm font-medium">
            <i data-lucide="trending-up" class="mr-2 h-4 w-4"></i>
            Les plus actives
        </button>
        <button
            class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600">
            <i data-lucide="clock" class="mr-2 h-4 w-4"></i>
            Récemment créées
        </button>
        <button
            class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600">
            <i data-lucide="calendar" class="mr-2 h-4 w-4"></i>
            Événements à venir
        </button>
        <button
            class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600">
            <i data-lucide="check-circle" class="mr-2 h-4 w-4"></i>
            Agréée
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Sidebar Gauche -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Mon rôle -->
            <div class="rounded-xl bg-gray-800 dark:bg-gray-900 p-4">
                <h2 class="text-sm font-semibold text-white mb-2">Mon rôle</h2>
                <p class="text-xs text-gray-300 mb-4">Contrôlez la portée et les actions.</p>

                @if(Auth::user()->isSuperAdmin())
                <div
                    class="inline-flex items-center rounded-md bg-red-500/20 px-3 py-2 text-sm font-medium text-red-300 mb-3">
                    <i data-lucide="shield" class="mr-2 h-4 w-4"></i>
                    Super Admin
                </div>
                @else
                <div
                    class="inline-flex items-center rounded-md bg-blue-500/20 px-3 py-2 text-sm font-medium text-blue-300 mb-3">
                    <i data-lucide="user" class="mr-2 h-4 w-4"></i>
                    Utilisateur
                </div>
                @endif

                <div class="text-xs text-gray-400 mb-4">
                    Membre des chambres
                </div>

                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors">
                    Administration
                </a>
                @endif
            </div>

            <!-- Mes Chambres -->
            <div class="rounded-xl bg-gray-800 dark:bg-gray-900 p-4">
                <h2 class="text-sm font-semibold text-white mb-2">Mes Chambres</h2>
                <p class="text-xs text-gray-300 mb-4">6 chambre(s) rejointe(s)</p>

                <!-- Barre de recherche -->
                <div class="relative mb-4">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                    </div>
                    <input type="text" id="chambersSearch" placeholder="Rechercher une chambre..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>

                <!-- Liste des chambres (limitée à 3 par défaut) -->
                <div id="chambersList" class="space-y-3">
                    <!-- Chambre 1 -->
                    <div class="chamber-item flex items-center gap-3 p-3 rounded-lg bg-gray-700/50 border border-gray-600"
                        data-name="Chambre de Commerce de Dakar">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">Ch</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white truncate">Chambre de comm...</div>
                            <div class="text-xs text-gray-400">3 membres</div>
                        </div>
                        <button class="text-gray-400 hover:text-white transition-colors">
                            <i data-lucide="external-link" class="h-4 w-4"></i>
                        </button>
                    </div>

                    <!-- Chambre 2 -->
                    <div class="chamber-item flex items-center gap-3 p-3 rounded-lg bg-gray-700/50 border border-gray-600"
                        data-name="Chambre de Commerce d'Abidjan">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">Ch</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white truncate">Chambre de comm...</div>
                            <div class="text-xs text-gray-400">4 membres</div>
                        </div>
                        <button class="text-gray-400 hover:text-white transition-colors">
                            <i data-lucide="external-link" class="h-4 w-4"></i>
                        </button>
                    </div>

                    <!-- Chambre 3 -->
                    <div class="chamber-item flex items-center gap-3 p-3 rounded-lg bg-gray-700/50 border border-gray-600"
                        data-name="Chambre de Commerce de Kinshasa">
                        <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">Ch</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white truncate">Chambre de comm...</div>
                            <div class="text-xs text-gray-400">5 membres</div>
                        </div>
                        <button class="text-gray-400 hover:text-white transition-colors">
                            <i data-lucide="external-link" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Bouton Voir mes chambres -->
                <div class="mt-4">
                    <a href="{{ route('my-chambers') }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors">
                        Voir mes chambres
                    </a>
                </div>

                <!-- Message quand aucun résultat -->
                <div id="noResults" class="hidden text-center py-4">
                    <div class="text-sm text-gray-400">Aucune chambre trouvée</div>
                </div>
            </div>

            <!-- Nos Partenaires -->
            <div class="rounded-xl bg-gray-800 dark:bg-gray-900 p-4">
                <h2 class="text-sm font-semibold text-white mb-2">Nos Partenaires</h2>
                <p class="text-xs text-gray-300 mb-4">Grandes marques qui nous font confiance</p>

                <div class="space-y-3">
                    <!-- Amazon -->
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-700/50">
                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">A</span>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-white">Amazon</div>
                            <div class="text-xs text-gray-400">Partenaire technologique</div>
                        </div>
                    </div>

                    <!-- Microsoft -->
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-700/50">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-white">Microsoft</div>
                            <div class="text-xs text-gray-400">Solutions cloud</div>
                        </div>
                    </div>

                    <!-- Google -->
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-700/50">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">G</span>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-white">Google</div>
                            <div class="text-xs text-gray-400">Partenaire digital</div>
                        </div>
                    </div>
                </div>

                <!-- Pagination dots -->
                <div class="flex justify-center gap-2 mt-4">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:col-span-6 space-y-6">
        @if(!auth()->user()->isSuperAdmin())
        <!-- Create Post -->
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=User" alt="" class="h-10 w-10 rounded-full object-cover">
                <div class="flex-1">
                    <input type="text" placeholder="Annoncer un forum, atelier, participation..."
                        class="w-full rounded-md border border-neutral-200 dark:border-gray-700 bg-neutral-50 dark:bg-gray-700 px-4 py-2 text-sm placeholder:text-neutral-500 dark:text-gray-500 dark:text-gray-400 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button
                    class="inline-flex items-center gap-2 rounded-md bg-neutral-100 dark:bg-gray-700 px-3 py-1.5 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-200 dark:hover:bg-gray-600">
                    <i data-lucide="message-square" class="h-4 w-4"></i>
                    Forum
                </button>
                <button
                    class="inline-flex items-center gap-2 rounded-md bg-neutral-100 dark:bg-gray-700 px-3 py-1.5 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-200 dark:hover:bg-gray-600">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    Atelier
                </button>
                <button
                    class="inline-flex items-center gap-2 rounded-md bg-neutral-100 dark:bg-gray-700 px-3 py-1.5 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-200 dark:hover:bg-gray-600">
                    <i data-lucide="calendar" class="h-4 w-4"></i>
                    Participation
                </button>
            </div>
        </div>
        @endif

        <!-- Skeleton loading pour le feed des chambres -->
        <div id="chambers-feed-skeleton" class="space-y-4" style="display: none;">
            @for($i = 0; $i
            < 4; $i++) <x-skeleton.chamber-feed />
            @endfor
        </div>

        <!-- Chambres Feed -->
        <div class="space-y-4">
            @forelse($chambers as $chamber)
            <article class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $chamber->logo_path ?? 'https://ui-avatars.com/api/?name=' . urlencode($chamber->name) . '&background=E71D36&color=fff' }}"
                                alt="{{ $chamber->name }}" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">{{ $chamber->name }}</div>
                                <div class="text-xs text-neutral-500 dark:text-gray-500 dark:text-gray-400">{{
                                    $chamber->location ?? 'Localisation non définie' }}</div>
                            </div>
                        </div>
                        @if(auth()->user()->isSuperAdmin())
                        @if($chamber->verified && $chamber->state_number)
                        <!-- Chambre agréée avec numéro d'état -->
                        <div class="flex flex-col items-end gap-1">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-gray-700 dark:bg-gray-600 px-2.5 py-1 text-xs font-medium text-green-400">
                                <i data-lucide="check-circle" class="h-3 w-3"></i>
                                Agréée
                            </span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">N° État: {{ $chamber->state_number
                                }}</span>
                        </div>
                        @else
                        <!-- Chambre non agréée - bouton pour ouvrir le modal -->
                        <button type="button" onclick="openCertificationModal('{{ $chamber->slug }}')"
                            class="inline-flex items-center gap-1.5 rounded-full bg-gray-700 dark:bg-gray-600 px-2.5 py-1 text-xs font-medium text-orange-400 hover:bg-gray-600 dark:hover:bg-gray-500">
                            <i data-lucide="shield-check" class="h-3 w-3"></i>
                            Agréer la chambre
                        </button>
                        @endif
                        @else
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#073066]/10 px-2.5 py-1 text-xs font-medium text-[#073066] dark:text-blue-400">
                            Chambre
                        </span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <h3 class="text-base font-semibold">{{ $chamber->name }}</h3>
                        <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">{{ $chamber->description ??
                            'Description non disponible' }}</p>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        @if($chamber->verified)
                        <span
                            class="inline-flex items-center rounded-md bg-gray-700 dark:bg-gray-600 px-2 py-1 text-xs font-medium text-green-400">
                            <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                            Vérifiée
                        </span>
                        @else
                        <span
                            class="inline-flex items-center rounded-md bg-gray-700 dark:bg-gray-600 px-2 py-1 text-xs font-medium text-yellow-400">
                            <i data-lucide="clock" class="mr-1 h-3 w-3"></i>
                            En attente
                        </span>
                        @endif

                        @if($chamber->location)
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300">
                            <i data-lucide="map-pin" class="mr-1 h-3 w-3"></i>
                            {{ $chamber->location }}
                        </span>
                        @endif

                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300">
                            <i data-lucide="users" class="mr-1 h-3 w-3"></i>
                            {{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}
                        </span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        @if(auth()->user()->isSuperAdmin())
                        <button
                            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            <i data-lucide="user-plus" class="h-4 w-4"></i>
                            Ajouter un gestionnaire
                        </button>
                        <span
                            class="inline-flex items-center gap-2 rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i data-lucide="users" class="h-4 w-4"></i>
                            {{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}
                        </span>
                        @else
                        <button
                            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                            S'inscrire
                        </button>
                        @endif
                        <a href="{{ route('chamber.show', $chamber) }}"
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:bg-gray-700">
                            Voir la chambre
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div
                class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center">
                <div
                    class="mx-auto h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                    <i data-lucide="building" class="h-6 w-6 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune chambre trouvée</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Il n'y a pas encore de chambres de commerce
                    enregistrées.</p>
                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('chambers.create') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Créer la première chambre
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </main>

    <!-- Sidebar Droite -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Événements du Mois -->
            <div class="rounded-xl bg-gray-800 dark:bg-gray-900 p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-white">Événements du Mois</h2>
                    <span class="text-xs text-blue-400 font-medium">Nov 2025</span>
                </div>
                <p class="text-xs text-gray-300 mb-4">Les 5 événements les plus populaires</p>

                <!-- Skeleton loading pour les événements -->
                <div id="sidebar-events-skeleton" class="space-y-4" style="display: none;">
                    @for($i = 0; $i
                    < 3; $i++) <x-skeleton.sidebar-event />
                    @endfor
                </div>

                <div class="space-y-4">
                    @forelse($popularEvents ?? [] as $event)
                    <!-- Événement dynamique -->
                    <div class="bg-gray-800 dark:bg-gray-900 border border-gray-700 rounded-lg p-4">
                        <!-- Header avec logo et badge -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">{{
                                        strtoupper(substr($event['chamber_name'], 0, 2)) }}</span>
                                </div>
                                <div>
                                    @if($event['is_user_chamber'])
                                    <div class="text-xs text-yellow-400 font-medium">⭐ Ma chambre</div>
                                    @else
                                    <div class="text-xs text-gray-400 font-medium">{{ $event['chamber_name'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-400">
                                <i data-lucide="clock" class="h-3 w-3"></i>
                                @if($event['max_participants'])
                                <span>{{ $event['max_participants'] - $event['participants'] }} places</span>
                                @else
                                <span>Places illimitées</span>
                                @endif
                            </div>
                        </div>

                        <!-- Titre -->
                        <h3 class="text-lg font-semibold text-white mb-3">{{ $event['title'] }}</h3>

                        <!-- Détails -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                <span>{{ $event['date'] }} à {{ $event['time'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="map-pin" class="h-4 w-4"></i>
                                <span>{{ $event['location'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                <span>{{ $event['participants'] }}@if($event['max_participants'])/{{
                                    $event['max_participants'] }}@endif participants</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="tag" class="h-4 w-4"></i>
                                <span>{{ ucfirst($event['type']) }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-gray-400 mb-4">{{ Str::limit($event['description'], 100) }}</p>

                        <!-- Actions -->
                        <div class="flex items-center gap-3">
                            <button onclick="toggleEventLike(this, {{ $event['id'] }})"
                                data-event-id="{{ $event['id'] }}"
                                class="like-btn flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 rounded-lg border border-gray-600 {{ $event['is_liked'] ? 'liked' : '' }}"
                                style="{{ $event['is_liked'] ? 'color: #f87171; border-color: #f87171; background-color: rgba(254, 226, 226, 0.3);' : '' }}">
                                <i data-lucide="heart"
                                    class="h-4 w-4 {{ $event['is_liked'] ? 'fill-current' : '' }}"></i>
                                <span class="like-count">{{ $event['likes_count'] }}</span>
                            </button>
                            @if($event['status'] !== 'complet')
                            <button data-action="reserve" data-event-id="{{ $event['id'] }}"
                                data-event-title="{{ $event['title'] }}"
                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                <span>Réserver place</span>
                            </button>
                            @else
                            <button disabled
                                class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-gray-400 text-sm font-medium rounded-md cursor-not-allowed">
                                <i data-lucide="users-x" class="h-4 w-4"></i>
                                <span>Complet</span>
                            </button>
                            @endif
                            <button onclick="viewEventDetails('{{ $event['id'] }}')"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-white transition-colors">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                <span>Voir plus</span>
                            </button>
                        </div>
                    </div>
                    @empty
                    <!-- Message si aucun événement -->
                    <div class="bg-gray-800 dark:bg-gray-900 border border-gray-700 rounded-lg p-6 text-center">
                        <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="calendar-x" class="h-6 w-6 text-gray-400"></i>
                        </div>
                        <h3 class="text-sm font-medium text-white mb-2">Aucun événement disponible</h3>
                        <p class="text-xs text-gray-400">Les événements apparaîtront ici une fois créés.</p>
                    </div>
                    @endforelse

                    <!-- Événement statique pour démonstration -->
                    <div class="bg-gray-800 dark:bg-gray-900 border border-gray-700 rounded-lg p-4">
                        <!-- Header avec logo et badge -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">CH</span>
                                </div>
                                <div>
                                    <div class="text-xs text-yellow-400 font-medium">⭐ Ma chambre</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-400">
                                <i data-lucide="clock" class="h-3 w-3"></i>
                                <span>14 places</span>
                            </div>
                        </div>

                        <!-- Titre -->
                        <h3 class="text-lg font-semibold text-white mb-3">Forum Entrepreneurial Jeunes</h3>

                        <!-- Détails -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                <span>14 Nov à 16:30:00</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="map-pin" class="h-4 w-4"></i>
                                <span>Salle de Conférences BCDC</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                <span>29/87 participants</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="tag" class="h-4 w-4"></i>
                                <span>Conférence</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-gray-400 mb-4">Événement de networking professionnel pour étendre votre
                            réseau et créer de nouvelles opportunités d'affaires. Organisé...</p>

                        <!-- Actions -->
                        <div class="flex items-center gap-3">
                            <button data-action="like" data-event-id="demo"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-white transition-colors">
                                <i data-lucide="heart" class="h-4 w-4"></i>
                                <span>J'aime</span>
                            </button>
                            <button data-action="reserve" data-event-id="demo"
                                data-event-title="Forum Entrepreneurial Jeunes"
                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                <span>Réserver place</span>
                            </button>
                            <button
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-white transition-colors">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                <span>Voir plus</span>
                            </button>
                        </div>
                    </div>

                    <!-- Forum d'Affaires Kinshasa -->
                    <div class="bg-gray-800 dark:bg-gray-900 border border-gray-700 rounded-lg p-4">
                        <!-- Header avec logo et badge -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">CH</span>
                                </div>
                                <div>
                                    <div class="text-xs text-yellow-400 font-medium">⭐ Ma chambre</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-400">
                                <i data-lucide="clock" class="h-3 w-3"></i>
                                <span>16 places</span>
                            </div>
                        </div>

                        <!-- Titre -->
                        <h3 class="text-lg font-semibold text-white mb-3">Forum d'Affaires Kinshasa</h3>

                        <!-- Détails -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                <span>16 Nov à 14:00:00</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="map-pin" class="h-4 w-4"></i>
                                <span>Centre de Conférences</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                <span>45/165 participants</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-300">
                                <i data-lucide="tag" class="h-4 w-4"></i>
                                <span>Forum</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-gray-400 mb-4">Grand forum d'affaires pour développer les opportunités
                            commerciales et les partenariats stratégiques en RDC...</p>

                        <!-- Actions -->
                        <div class="flex items-center gap-3">
                            <button data-action="like" data-event-id="3"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-white transition-colors">
                                <i data-lucide="heart" class="h-4 w-4"></i>
                                <span>J'aime</span>
                            </button>
                            <button data-action="reserve" data-event-id="3" data-event-title="Forum d'Affaires Kinshasa"
                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                <span>Réserver place</span>
                            </button>
                            <button
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:text-white transition-colors">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                <span>Voir plus</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

<!-- Modal d'agrément pour super admin -->
@if(auth()->user()->isSuperAdmin())
<div id="certificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-50 dark:bg-gray-8000 opacity-75"></div>
        </div>

        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="certificationForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="shield-check" class="h-6 w-6 text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Agréer la chambre
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="state_number"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Numéro d'état officiel
                                    </label>
                                    <input type="text" name="state_number" id="state_number" required
                                        placeholder="Ex: CCI-DK-2024-002"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-[#073066] sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format recommandé:
                                        CCI-[VILLE]-[ANNÉE]-[NUMÉRO]</p>
                                </div>

                                <div>
                                    <label for="certification_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Date d'agrément
                                    </label>
                                    <input type="date" name="certification_date" id="certification_date" required
                                        value="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-[#073066] sm:text-sm">
                                </div>

                                <div>
                                    <label for="notes"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Notes (optionnel)
                                    </label>
                                    <textarea name="notes" id="notes" rows="3"
                                        placeholder="Commentaires sur l'agrément..."
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:border-gray-400 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-[#073066] sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                        Agréer la chambre
                    </button>
                    <button type="button" onclick="closeCertificationModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 dark:border-gray-400 bg-white dark:bg-gray-800 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    /* Style pour les boutons like dans le dashboard principal */
    .like-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    /* Style par défaut - gris */
    .like-btn {
        color: #9ca3af !important;
        border-color: #4b5563 !important;
        background-color: transparent !important;
    }

    /* Style au hover - rouge */
    .like-btn:hover {
        color: #ef4444 !important;
        border-color: #f87171 !important;
        background-color: rgba(127, 29, 29, 0.3) !important;
    }

    /* Style quand liké - rouge permanent mais subtil */
    .like-btn.liked {
        color: #f87171 !important;
        border-color: #f87171 !important;
        background-color: rgba(127, 29, 29, 0.2) !important;
    }

    .like-btn.liked:hover {
        color: #ef4444 !important;
        border-color: #f87171 !important;
        background-color: rgba(127, 29, 29, 0.4) !important;
    }

    /* Animation pour le bouton like */
    .like-btn:active {
        transform: scale(0.95);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialiser les icônes Lucide
        lucide.createIcons({
            attrs: {
                'stroke-width': 1.5
            }
        });

        // Gérer les boutons "J'aime" (anciens boutons statiques)
        document.querySelectorAll('[data-action="like"]').forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.dataset.eventId;
                const heartIcon = this.querySelector('i[data-lucide="heart"]');
                const isLiked = this.classList.contains('liked');

                if (isLiked) {
                    // Retirer le like
                    this.classList.remove('liked');
                    this.classList.remove('text-red-400');
                    this.classList.add('text-gray-300');
                    heartIcon.setAttribute('data-lucide', 'heart');
                } else {
                    // Ajouter le like
                    this.classList.add('liked');
                    this.classList.remove('text-gray-300');
                    this.classList.add('text-red-400');
                    heartIcon.setAttribute('data-lucide', 'heart');
                    heartIcon.style.fill = 'currentColor';
                }

                // Réinitialiser les icônes Lucide
                lucide.createIcons();

                // Ici vous pouvez ajouter un appel AJAX pour sauvegarder le like
                console.log(`${isLiked ? 'Unlike' : 'Like'} event ${eventId}`);
            });
        });

        // Gérer les boutons "Réserver place"
        document.querySelectorAll('[data-action="reserve"]').forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.dataset.eventId;
                const eventTitle = this.dataset.eventTitle;

                // Afficher une confirmation
                if (confirm(`Voulez-vous réserver une place pour "${eventTitle}" ?`)) {
                    // Désactiver le bouton temporairement
                    this.disabled = true;
                    this.innerHTML = '<i data-lucide="loader-2" class="h-4 w-4 animate-spin mr-2"></i>Réservation...';

                    // Simuler un appel API (remplacez par un vrai appel AJAX)
                    setTimeout(() => {
                        // Succès de la réservation
                        this.innerHTML = '<i data-lucide="check" class="h-4 w-4 mr-2"></i>Réservé';
                        this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        this.classList.add('bg-green-600', 'hover:bg-green-700');

                        // Réinitialiser les icônes Lucide
                        lucide.createIcons();

                        // Afficher un message de succès
                        showNotification('Réservation confirmée !', 'success');

                        // Optionnel : réactiver le bouton après quelques secondes
                        setTimeout(() => {
                            this.disabled = false;
                        }, 2000);
                    }, 1500);
                }
            });
        });

        // Gérer la recherche dans "Mes Chambres"
        const chambersSearch = document.getElementById('chambersSearch');
        const chambersList = document.getElementById('chambersList');
        const noResults = document.getElementById('noResults');

        if (chambersSearch && chambersList) {
            chambersSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const chamberItems = chambersList.querySelectorAll('.chamber-item');
                let visibleCount = 0;

                chamberItems.forEach((item, index) => {
                    const chamberName = item.dataset.name.toLowerCase();
                    const shouldShow = searchTerm === '' ? index < 3 : chamberName.includes(searchTerm);

                    if (shouldShow) {
                        item.classList.remove('hidden');
                        item.classList.add('flex');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('flex');
                    }
                });

                // Afficher/masquer le message "Aucun résultat"
                if (visibleCount === 0 && searchTerm !== '') {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            });
        }
    });

    // Fonction pour gérer les likes d'événements (nouvelle version avec AJAX)
    window.toggleEventLike = function(button, eventId) {
        const icon = button.querySelector('i[data-lucide="heart"]');
        const likeCountElement = button.querySelector('.like-count');
        const isLiked = button.classList.contains('text-red-400');

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
                button.classList.remove('text-gray-300');
                button.classList.add('text-red-400');
                icon.classList.add('fill-current');
            } else {
                button.classList.add('text-gray-300');
                button.classList.remove('text-red-400');
                icon.classList.remove('fill-current');
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
    };

    // Fonction pour afficher des notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full`;

        if (type === 'success') {
            notification.classList.add('bg-green-600');
        } else if (type === 'error') {
            notification.classList.add('bg-red-600');
        } else {
            notification.classList.add('bg-blue-600');
        }

        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info'}" class="h-5 w-5"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animer l'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Supprimer après 3 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);

        // Réinitialiser les icônes Lucide
        lucide.createIcons();
    }

    // Fonctions pour le modal d'agrément
    window.openCertificationModal = function(chamberSlug) {
        console.log('Opening modal for:', chamberSlug);
        const modal = document.getElementById('certificationModal');
        const form = document.getElementById('certificationForm');

        if (!modal || !form) {
            console.error('Modal ou formulaire non trouvé');
            return;
        }

        // Définir l'action du formulaire avec le slug de la chambre
        form.action = `/admin/chambers/${chamberSlug}/certify`;

        // Générer un numéro d'état suggéré basé sur le slug
        const currentYear = new Date().getFullYear();
        let suggestedNumber = '';

        if (chamberSlug.includes('abidjan')) {
            suggestedNumber = `CCI-AB-${currentYear}-001`;
        } else if (chamberSlug.includes('dakar')) {
            suggestedNumber = `CCI-DK-${currentYear}-002`;
        } else if (chamberSlug.includes('paris')) {
            suggestedNumber = `CCI-PA-${currentYear}-003`;
        } else {
            // Générer un numéro générique
            const randomNum = Math.floor(Math.random() * 999) + 1;
            suggestedNumber = `CCI-XX-${currentYear}-${randomNum.toString().padStart(3, '0')}`;
        }

        document.getElementById('state_number').value = suggestedNumber;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCertificationModal() {
        const modal = document.getElementById('certificationModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';

        // Réinitialiser le formulaire
        document.getElementById('certificationForm').reset();
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('certificationModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCertificationModal();
        }
    });

    // Fonction pour gérer les likes d'événements (nouveaux événements dynamiques)
    window.toggleEventLike = function(button, eventId) {
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
                button.style.color = '#f87171';
                button.style.borderColor = '#f87171';
                button.style.backgroundColor = 'rgba(254, 226, 226, 0.3)';
                icon.classList.add('fill-current');
                icon.style.fill = 'currentColor';
            } else {
                button.classList.remove('liked');
                button.style.color = '';
                button.style.borderColor = '';
                button.style.backgroundColor = '';
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
    };

    // Fonction pour voir les détails d'un événement
    window.viewEventDetails = function(eventId) {
        // Pour l'instant, on peut juste afficher une notification
        showNotification(`Détails de l'événement ${eventId} - Fonctionnalité à venir`, 'info');
    };
</script>
@endpush
@endsection