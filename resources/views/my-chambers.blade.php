@extends('layouts.app')

@push('styles')
<style>
/* Animations */
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

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animation du card profil */
.profile-card-animation {
    animation: slideInDown 0.6s ease-out;
}

/* Animation des chambres */
.chamber-card-animation {
    animation: fadeInUp 0.5s ease-out;
    animation-fill-mode: both;
}

.chamber-card-animation:nth-child(1) { animation-delay: 0.1s; }
.chamber-card-animation:nth-child(2) { animation-delay: 0.15s; }
.chamber-card-animation:nth-child(3) { animation-delay: 0.2s; }
.chamber-card-animation:nth-child(4) { animation-delay: 0.25s; }
.chamber-card-animation:nth-child(5) { animation-delay: 0.3s; }
.chamber-card-animation:nth-child(6) { animation-delay: 0.35s; }

/* Effet hover sur les cards de chambres */
.chamber-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.chamber-card:hover {
    transform: translateY(-4px);
}

/* Zoom sur l'image de couverture au hover */
.chamber-card:hover .chamber-cover-image {
    transform: scale(1.05);
}

.chamber-cover-image {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Animation du logo au hover */
.chamber-card:hover .chamber-logo {
    transform: scale(1.1);
}

.chamber-logo {
    transition: transform 0.3s ease;
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

/* Effet glassmorphism */
.stat-glass {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Animation du séparateur */
.separator-animated {
    background: linear-gradient(90deg, transparent, currentColor 20%, currentColor 80%, transparent);
}

/* Animation pulse pour les boutons */
@keyframes pulse-shadow {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(37, 99, 235, 0);
    }
}

.pulse-shadow {
    animation: pulse-shadow 2s infinite;
}

/* Transitions pour le dark mode */
* {
    transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
}

/* Amélioration du hover pour les stats */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateX(4px);
}

.stat-icon {
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
}
</style>
@endpush

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
    <!-- Sidebar Gauche - Card Profil -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Card Profil & Statistiques -->
            <div class="profile-card-animation rounded-xl border border-neutral-200 dark:border-gray-700 bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/10 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                <!-- Header avec dégradé -->
                <div class="profile-header h-20 bg-gradient-to-r from-[#2563eb] to-[#1e40af] relative">
                    <div class="absolute -bottom-10 left-4">
                        @if(Auth::user()->avatar || Auth::user()->profile_photo_path)
                            <div class="profile-avatar">
                                <img src="{{ asset('storage/' . (Auth::user()->avatar ?? Auth::user()->profile_photo_path)) }}" 
                                     alt="{{ Auth::user()->name }}"
                                     class="w-20 h-20 rounded-xl border-4 border-white dark:border-gray-800 shadow-lg object-cover">
                            </div>
                        @else
                            <div class="profile-avatar w-20 h-20 rounded-xl border-4 border-white dark:border-gray-800 shadow-lg bg-gradient-to-br from-[#2563eb] to-[#1e40af] flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                </span>
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
                    <div class="separator-animated h-px bg-neutral-200 dark:bg-gray-700 mb-4"></div>

                    <!-- Statistiques cliquables -->
                    <div class="space-y-2.5">
                        <a href="{{ route('my-chambers') }}" class="stat-card stat-glass flex items-center justify-between p-3 rounded-lg bg-blue-50/50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center gap-2.5">
                                <div class="stat-icon w-9 h-9 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center">
                                    <i data-lucide="building" class="h-4 w-4 text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="text-xs font-medium text-blue-700 dark:text-blue-300">Mes chambres</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $stats['total_chambers'] }}</span>
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
                                <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent">{{ Auth::user()->events()->count() }}</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 text-neutral-400 dark:text-gray-500 group-hover:text-green-600 dark:group-hover:text-green-400 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Actions rapides</h3>
                <div class="space-y-2">
                    <a href="{{ route('chambers') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-neutral-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors group">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="search" class="h-4 w-4 text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <span class="font-medium">Découvrir</span>
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div class="w-8 h-8 rounded-lg bg-neutral-100 dark:bg-gray-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="home" class="h-4 w-4 text-neutral-600 dark:text-gray-400"></i>
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Contenu Principal -->
    <main class="lg:col-span-9">
        <!-- Header avec titre et statistiques -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Mes Chambres
                    </h1>
                    <p class="text-sm text-neutral-600 dark:text-gray-400">
                        Gérez et accédez à vos chambres de commerce
                    </p>
                </div>
            </div>

            <!-- Cards Statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <!-- Total des chambres -->
                <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/10 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <i data-lucide="building" class="h-6 w-6 text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-neutral-600 dark:text-gray-400">Total</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_chambers'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Chambres vérifiées -->
                <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-gradient-to-br from-white to-green-50/30 dark:from-gray-800 dark:to-green-900/10 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                            <i data-lucide="shield-check" class="h-6 w-6 text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-neutral-600 dark:text-gray-400">Vérifiées</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['verified_chambers'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total des membres -->
                <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-gradient-to-br from-white to-purple-50/30 dark:from-gray-800 dark:to-purple-900/10 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <i data-lucide="users" class="h-6 w-6 text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-neutral-600 dark:text-gray-400">Membres</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_members'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barre de recherche et filtres -->
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                    <input type="text" 
                           id="chambersSearch" 
                           placeholder="Rechercher une chambre par nom..." 
                           class="block w-full pl-11 pr-4 py-2.5 rounded-lg border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-neutral-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <select id="statusFilter" 
                        class="px-4 py-2.5 rounded-lg border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="all">Tous les statuts</option>
                    <option value="verified">Vérifiées</option>
                    <option value="pending">En attente</option>
                </select>
            </div>
        </div>

        <!-- Liste des chambres -->
        @if($userChambers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="chambersList">
            @foreach($userChambers as $chamber)
            <div class="chamber-card chamber-card-animation rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300"
                 data-name="{{ strtolower($chamber->name) }}"
                 data-status="{{ $chamber->verified ? 'verified' : 'pending' }}">
                
                <!-- Header Card avec Image de Couverture -->
                <div class="relative h-40 overflow-hidden bg-neutral-100 dark:bg-gray-700">
                    <!-- Image de couverture ou pattern par défaut -->
                    @if($chamber->cover_image_path)
                        <img src="{{ asset('storage/' . $chamber->cover_image_path) }}" 
                             alt="{{ $chamber->name }}"
                             class="chamber-cover-image w-full h-full object-cover">
                    @else
                        <!-- Image par défaut avec pattern élégant -->
                        <div class="chamber-cover-image w-full h-full bg-gradient-to-br from-[#2563eb] via-[#1e40af] to-[#1e3a8a] relative">
                            <!-- Pattern overlay -->
                            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                            <!-- Gradient overlay pour effet de profondeur -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            <!-- Nom de la chambre en grand sur le fond par défaut -->
                            <div class="absolute inset-0 flex items-center justify-center p-4">
                                <span class="text-white/20 text-4xl font-black text-center uppercase tracking-wider">
                                    {{ substr($chamber->name, 0, 3) }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Overlay sombre pour améliorer la lisibilité -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent pointer-events-none"></div>
                    
                    <!-- Logo en overlay -->
                    <div class="absolute bottom-3 left-4 chamber-logo">
                        @if($chamber->logo_path)
                            <img src="{{ asset('storage/' . $chamber->logo_path) }}" 
                                 alt="{{ $chamber->name }}"
                                 class="w-16 h-16 rounded-xl border-3 border-white dark:border-white shadow-xl object-cover bg-white">
                        @else
                            <div class="w-16 h-16 rounded-xl border-3 border-white dark:border-white shadow-xl bg-white dark:bg-gray-800 flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 text-lg font-bold">
                                    {{ strtoupper(substr($chamber->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Badge de statut -->
                    <div class="absolute top-3 right-3">
                        @if($chamber->verified)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-white/95 dark:bg-gray-800/95 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-700 backdrop-blur-sm shadow-lg">
                            <i data-lucide="check-circle" class="h-3 w-3"></i>
                            Vérifiée
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-white/95 dark:bg-gray-800/95 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-700 backdrop-blur-sm shadow-lg">
                            <i data-lucide="clock" class="h-3 w-3"></i>
                            En attente
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Contenu -->
                <div class="pt-4 px-4 pb-4">
                    <!-- Nom de la chambre -->
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-1" title="{{ $chamber->name }}">
                        {{ $chamber->name }}
                    </h3>

                    <!-- Description -->
                    @if($chamber->description)
                    <p class="text-sm text-neutral-600 dark:text-gray-400 mb-4 line-clamp-2">
                        {{ $chamber->description }}
                    </p>
                    @else
                    <p class="text-sm italic text-neutral-400 dark:text-gray-500 mb-4">
                        Aucune description disponible
                    </p>
                    @endif

                    <!-- Informations -->
                    <div class="space-y-2 mb-4">
                        @if($chamber->location)
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                            <i data-lucide="map-pin" class="h-4 w-4 text-blue-500 flex-shrink-0"></i>
                            <span class="truncate">{{ $chamber->location }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                            <i data-lucide="users" class="h-4 w-4 text-green-500 flex-shrink-0"></i>
                            <span>{{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}</span>
                        </div>
                        
                        @if($chamber->state_number)
                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                            <i data-lucide="shield" class="h-4 w-4 text-purple-500 flex-shrink-0"></i>
                            <span class="truncate">N° {{ $chamber->state_number }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-3 border-t border-neutral-200 dark:border-gray-700">
                        <a href="{{ route('chamber.show', $chamber) }}"
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] text-white text-sm font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                            Voir
                        </a>
                        <button onclick="confirmLeave('{{ $chamber->name }}', {{ $chamber->id }})"
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700 text-white text-sm font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200"
                                title="Quitter la chambre">
                            <i data-lucide="log-out" class="h-4 w-4"></i>
                            <span>Quitter</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Message quand aucun résultat de recherche -->
        <div id="noResults" class="hidden">
            <div class="text-center py-16 rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="w-16 h-16 rounded-full bg-neutral-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="search-x" class="h-8 w-8 text-neutral-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Aucune chambre trouvée</h3>
                <p class="text-sm text-neutral-600 dark:text-gray-400">
                    Essayez de modifier vos filtres ou votre recherche
                </p>
            </div>
        </div>

        @else
        <!-- État vide -->
        <div class="text-center py-16 rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 flex items-center justify-center mx-auto mb-6">
                <i data-lucide="building-2" class="h-10 w-10 text-blue-600 dark:text-blue-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucune chambre rejointe</h3>
            <p class="text-sm text-neutral-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Vous n'avez pas encore rejoint de chambres de commerce. Découvrez les chambres disponibles et rejoignez-en une !
            </p>
            <a href="{{ route('chambers') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] text-white font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200 pulse-shadow">
                <i data-lucide="plus" class="h-5 w-5"></i>
                Découvrir les chambres
            </a>
        </div>
        @endif
    </main>
</div>

<!-- Modal de confirmation pour quitter une chambre -->
<div id="leaveModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quitter la chambre</h3>
                    <p class="text-sm text-neutral-600 dark:text-gray-400">Cette action est irréversible</p>
                </div>
            </div>
            
            <p class="text-sm text-neutral-700 dark:text-gray-300 mb-6">
                Êtes-vous sûr de vouloir quitter <span id="chamberName" class="font-semibold text-gray-900 dark:text-white"></span> ?
                Vous perdrez l'accès à tous les événements et ressources de cette chambre.
            </p>
            
            <div class="flex gap-3">
                <button onclick="closeLeaveModal()" 
                        class="flex-1 px-4 py-2.5 rounded-lg border border-neutral-300 dark:border-gray-600 text-neutral-700 dark:text-gray-300 font-medium hover:bg-neutral-50 dark:hover:bg-gray-700 transition-colors">
                    Annuler
                </button>
                <button onclick="leaveChamber()" 
                        class="flex-1 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors">
                    Quitter
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('chambersSearch');
    const statusFilter = document.getElementById('statusFilter');
    const chamberCards = document.querySelectorAll('.chamber-card');
    const noResults = document.getElementById('noResults');
    const chambersList = document.getElementById('chambersList');

    function filterChambers() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter.value;
        let visibleCount = 0;

        chamberCards.forEach(card => {
            const chamberName = card.dataset.name;
            const chamberStatus = card.dataset.status;
            
            const matchesSearch = chamberName.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || chamberStatus === statusValue;
            
            const isVisible = matchesSearch && matchesStatus;
            card.style.display = isVisible ? 'block' : 'none';
            if (isVisible) visibleCount++;
        });

        // Afficher/masquer le message "aucun résultat"
        if (noResults && chambersList) {
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                chambersList.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                chambersList.classList.remove('hidden');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterChambers);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterChambers);
    }
});

let chamberToLeave = null;

function confirmLeave(chamberName, chamberId) {
    chamberToLeave = chamberId;
    document.getElementById('chamberName').textContent = chamberName;
    document.getElementById('leaveModal').classList.remove('hidden');
}

function closeLeaveModal() {
    chamberToLeave = null;
    document.getElementById('leaveModal').classList.add('hidden');
}

function leaveChamber() {
    if (!chamberToLeave) return;
    
    // TODO: Implémenter l'appel AJAX pour quitter la chambre
    console.log('Quitter la chambre ID:', chamberToLeave);
    
    // Fermer le modal
    closeLeaveModal();
    
    // Recharger la page (temporaire - à remplacer par une mise à jour dynamique)
    window.location.reload();
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('leaveModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeLeaveModal();
    }
});
</script>
@endsection
