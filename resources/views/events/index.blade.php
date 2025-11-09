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
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </span>
                <input type="text" id="events-search" placeholder="Rechercher des événements, chambres, organisateurs..."
                    class="w-full rounded-xl border border-neutral-200 bg-white pl-10 pr-4 py-3 text-sm text-neutral-800 placeholder:text-neutral-400 shadow-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20">
            </div>
        </div>

        <div class="border-b border-neutral-200 mb-6">
            <nav class="flex gap-1">
                <button class="px-4 py-2 text-sm font-medium text-[#073066] border-b-2 border-[#073066]">For
                    you</button>
                <button class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Following</button>
                <button class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Chambers</button>
                <button class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Events</button>
            </nav>
        </div>

        <div class="space-y-8">
            <div class="space-y-6">
                <!-- Static upcoming event card -->
                <div
                    class="event-card group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200"
                    data-activity-type="forum"
                    data-location="kinshasa"
                    data-period="cette-semaine"
                    data-verified="true"
                    data-title="business forum 2025"
                    data-description="key event for networking and collaboration among businesses"
                    data-chamber="chamber of commerce of kinshasa">
                    <div class="grid sm:grid-cols-3 gap-0">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop"
                            alt="" class="h-48 w-full object-cover sm:h-full">
                        <div class="sm:col-span-2 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm">
                                        <span class="text-sm font-medium">KN</span>
                                    </div>
                                    <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                        Kinshasa</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Business Forum 2025</h3>
                            <p class="text-sm text-neutral-600 mb-4">Key event for networking and collaboration among
                                businesses.</p>
                            
                            <!-- Stats Section -->
                            <div class="flex items-center gap-6 mb-4">
                                <div class="flex items-center gap-1.5 text-sm text-neutral-500">
                                    <i data-lucide="heart" class="h-4 w-4"></i>
                                    <span class="likes-count font-medium">24</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-sm text-neutral-500">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    <span class="views-count font-medium">156</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <button onclick="toggleLike(this)" data-likes="24"
                                    class="like-btn inline-flex items-center justify-center w-9 h-9 rounded-full text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                                    <i data-lucide="heart" class="h-4 w-4"></i>
                                </button>
                                <button
                                    class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors shadow-sm">
                                    <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                    Réserver place
                                </button>
                                <button onclick="incrementViews(this)" data-views="156"
                                    class="inline-flex items-center gap-2 rounded-md border border-neutral-200 bg-white px-4 py-2.5 text-sm font-medium text-neutral-600 hover:bg-neutral-50 hover:border-neutral-300 transition-colors">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    Voir plus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Static upcoming event card -->
                <div
                    class="event-card group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200"
                    data-activity-type="atelier"
                    data-location="lubumbashi"
                    data-period="ce-mois"
                    data-verified="true"
                    data-title="mining industry conference"
                    data-description="explore latest trends and technologies in the mining sector"
                    data-chamber="chamber of commerce of lubumbashi">
                    <div class="grid sm:grid-cols-3 gap-0">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1600&auto=format&fit=crop"
                            alt="" class="h-48 w-full object-cover sm:h-full">
                        <div class="sm:col-span-2 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm">
                                        <span class="text-sm font-medium">LB</span>
                                    </div>
                                    <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                        Lubumbashi</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Mining Industry Conference</h3>
                            <p class="text-sm text-neutral-600 mb-4">Explore latest trends and technologies in the
                                mining sector.</p>
                            
                            <!-- Stats Section -->
                            <div class="flex items-center gap-6 mb-4">
                                <div class="flex items-center gap-1.5 text-sm text-neutral-500">
                                    <i data-lucide="heart" class="h-4 w-4"></i>
                                    <span class="likes-count font-medium">18</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-sm text-neutral-500">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    <span class="views-count font-medium">89</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <button onclick="toggleLike(this)" data-likes="18"
                                    class="like-btn inline-flex items-center justify-center w-9 h-9 rounded-full text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                                    <i data-lucide="heart" class="h-4 w-4"></i>
                                </button>
                                <button
                                    class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors shadow-sm">
                                    <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                    Réserver place
                                </button>
                                <button onclick="incrementViews(this)" data-views="89"
                                    class="inline-flex items-center gap-2 rounded-md border border-neutral-200 bg-white px-4 py-2.5 text-sm font-medium text-neutral-600 hover:bg-neutral-50 hover:border-neutral-300 transition-colors">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    Voir plus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-4">Past Events</h2>
                <div class="space-y-6">
                    <div
                        class="event-card group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200"
                        data-activity-type="atelier"
                        data-location="kinshasa"
                        data-period="trimestre"
                        data-verified="false"
                        data-title="digital transformation workshop"
                        data-description="a workshop on digital transformation for businesses"
                        data-chamber="chamber of commerce of kinshasa">
                        <div class="grid sm:grid-cols-3 gap-0">
                            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-48 w-full object-cover sm:h-full">
                            <div class="sm:col-span-2 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-600 to-neutral-700 text-white shadow-sm">
                                            <span class="text-sm font-medium">KN</span></div>
                                        <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                            Kinshasa</span>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">Digital Transformation Workshop</h3>
                                <p class="text-sm text-neutral-600 mb-4">A workshop on digital transformation for
                                    businesses.</p>
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"><i
                                        data-lucide="eye" class="h-4 w-4"></i> View Details</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="event-card group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200"
                        data-activity-type="participation"
                        data-location="lubumbashi"
                        data-period="trimestre"
                        data-verified="true"
                        data-title="sme financing seminar"
                        data-description="a seminar focused on financing options for smes"
                        data-chamber="chamber of commerce of lubumbashi">
                        <div class="grid sm:grid-cols-3 gap-0">
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-48 w-full object-cover sm:h-full">
                            <div class="sm:col-span-2 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-600 to-neutral-700 text-white shadow-sm">
                                            <span class="text-sm font-medium">LB</span></div>
                                        <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                            Lubumbashi</span>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">SME Financing Seminar</h3>
                                <p class="text-sm text-neutral-600 mb-4">A seminar focused on financing options for
                                    SMEs.</p>
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"><i
                                        data-lucide="eye" class="h-4 w-4"></i> View Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar - Filtres -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <div class="rounded-xl border border-neutral-200 bg-white">
                <div class="border-b border-neutral-200 p-4">
                    <h2 class="text-sm font-semibold">Filtres</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <!-- Type d'activité -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Type d'activité</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button data-activity-filter="forum"
                                    class="activity-filter-btn inline-flex items-center rounded-md bg-[#fcb357]/10 px-2.5 py-1.5 text-xs font-medium text-[#fcb357] hover:bg-[#fcb357]/20 transition-colors">Forum</button>
                                <button data-activity-filter="atelier"
                                    class="activity-filter-btn inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 transition-colors">Atelier</button>
                                <button data-activity-filter="participation"
                                    class="activity-filter-btn inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 transition-colors">Participation</button>
                            </div>
                        </div>
                        
                        <!-- Période -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Période</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button data-period-filter="cette-semaine"
                                    class="period-filter-btn inline-flex items-center rounded-md bg-[#073066] px-2.5 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-colors">Cette semaine</button>
                                <button data-period-filter="ce-mois"
                                    class="period-filter-btn inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 transition-colors">Ce mois</button>
                                <button data-period-filter="trimestre"
                                    class="period-filter-btn inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200 transition-colors">Trimestre</button>
                            </div>
                        </div>
                        
                        <!-- Localisation -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Localisation</label>
                            <div class="mt-2">
                                <select id="location-filter"
                                    class="w-full rounded-md border border-neutral-200 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20">
                                    <option value="">Toutes les régions</option>
                                    <option value="kinshasa">Kinshasa</option>
                                    <option value="lubumbashi">Lubumbashi</option>
                                    <option value="goma">Goma</option>
                                    <option value="bukavu">Bukavu</option>
                                    <option value="online">En ligne</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Toggle Vérifiées -->
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-medium text-neutral-700">Afficher uniquement "agréées"</label>
                            <button type="button" id="verified-toggle"
                                class="relative inline-flex h-5 w-9 flex-shrink-0 rounded-full border-2 border-transparent bg-neutral-200 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#073066] focus:ring-offset-2">
                                <span class="translate-x-0 pointer-events-none relative inline-block h-4 w-4 transform rounded-full bg-white shadow transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @auth
            @if(Auth::user()->isRegularUser())
                @php
                    // Simuler les chambres de l'utilisateur (à remplacer par la vraie logique)
                    $userChambers = collect([
                        ['name' => 'Kinshasa', 'code' => 'KN', 'members_count' => 12345],
                        ['name' => 'Lubumbashi', 'code' => 'LB', 'members_count' => 8765]
                    ]);
                @endphp
                
                @if($userChambers->count() > 0)
                <!-- Section Mes Chambres - Seulement pour les utilisateurs normaux avec des chambres -->
                <div class="rounded-xl border border-neutral-200 bg-white">
                    <div class="border-b border-neutral-200 p-4">
                        <h2 class="text-sm font-semibold">Mes Chambres</h2>
                        <p class="mt-1 text-xs text-neutral-600">S'abonner à une chambre vous notifiera automatiquement de leurs événements.</p>
                    </div>
                    <div class="divide-y divide-neutral-200">
                        @foreach($userChambers as $chamber)
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white">
                                    <span class="text-sm font-medium">{{ $chamber['code'] }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">{{ $chamber['name'] }}</div>
                                    <div class="text-xs text-neutral-500">{{ number_format($chamber['members_count']) }} membres</div>
                                </div>
                            </div>
                            <button class="group relative inline-flex h-8 w-8 items-center justify-center rounded-full text-neutral-400 hover:bg-neutral-100 hover:text-[#073066] transition-colors">
                                <i data-lucide="heart" class="h-4 w-4"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endif
            @endauth
        </div>
    </aside>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        
        // Variables globales pour les filtres
        const searchInput = document.getElementById('events-search');
        const eventCards = document.querySelectorAll('.event-card');
        const activityFilterBtns = document.querySelectorAll('.activity-filter-btn');
        const periodFilterBtns = document.querySelectorAll('.period-filter-btn');
        const locationFilter = document.getElementById('location-filter');
        const verifiedToggle = document.getElementById('verified-toggle');
        
        let activeFilters = {
            activity: null,
            period: 'cette-semaine', // Par défaut "Cette semaine" est actif
            location: '',
            verified: false,
            search: ''
        };
        
        // Fonction principale de filtrage
        function applyFilters() {
            let visibleCount = 0;
            
            eventCards.forEach(card => {
                const matchesActivity = !activeFilters.activity || card.dataset.activityType === activeFilters.activity;
                const matchesPeriod = !activeFilters.period || card.dataset.period === activeFilters.period;
                const matchesLocation = !activeFilters.location || card.dataset.location === activeFilters.location;
                const matchesVerified = !activeFilters.verified || card.dataset.verified === 'true';
                
                // Recherche textuelle
                const searchTerm = activeFilters.search.toLowerCase();
                const matchesSearch = !searchTerm || 
                    card.dataset.title.includes(searchTerm) ||
                    card.dataset.description.includes(searchTerm) ||
                    card.dataset.chamber.includes(searchTerm);
                
                const shouldShow = matchesActivity && matchesPeriod && matchesLocation && matchesVerified && matchesSearch;
                
                // Animation de transition
                if (shouldShow) {
                    card.style.display = 'block';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    
                    setTimeout(() => {
                        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, visibleCount * 50);
                    
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Afficher message si aucun résultat
            showNoResultsMessage(visibleCount === 0);
        }
        
        // Fonction pour afficher/masquer le message "Aucun résultat"
        function showNoResultsMessage(show) {
            let noResultsDiv = document.getElementById('no-results-events');
            
            if (show && !noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'no-results-events';
                noResultsDiv.className = 'text-center py-12';
                noResultsDiv.innerHTML = `
                    <div class="mx-auto max-w-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 text-neutral-400 mx-auto mb-4">
                            <i data-lucide="calendar-x" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">Aucun événement trouvé</h3>
                        <p class="text-sm text-neutral-600">Essayez de modifier vos critères de recherche ou vos filtres.</p>
                        <button onclick="clearAllEventFilters()" class="mt-4 inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347] transition-colors">
                            <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                            Réinitialiser les filtres
                        </button>
                    </div>
                `;
                
                // Insérer après le titre "Past Events" ou à la fin
                const pastEventsSection = document.querySelector('h2');
                if (pastEventsSection) {
                    pastEventsSection.parentNode.insertBefore(noResultsDiv, pastEventsSection.nextSibling);
                } else {
                    document.querySelector('main .space-y-8').appendChild(noResultsDiv);
                }
                
                lucide.createIcons();
            } else if (!show && noResultsDiv) {
                noResultsDiv.remove();
            }
        }
        
        // Fonction pour réinitialiser tous les filtres
        window.clearAllEventFilters = function() {
            activeFilters = {
                activity: null,
                period: 'cette-semaine',
                location: '',
                verified: false,
                search: ''
            };
            
            searchInput.value = '';
            locationFilter.value = '';
            updateFilterButtons();
            updateVerifiedToggle();
            applyFilters();
        };
        
        // Mise à jour de l'apparence des boutons de filtre
        function updateFilterButtons() {
            // Boutons d'activité
            activityFilterBtns.forEach(btn => {
                const isActive = btn.dataset.activityFilter === activeFilters.activity;
                btn.className = btn.className.replace(/bg-\[#[^\]]+\]/g, '').replace(/text-\[#[^\]]+\]/g, '');
                
                if (isActive) {
                    btn.className += ' bg-[#fcb357] text-white';
                } else {
                    btn.className += ' bg-neutral-100 text-neutral-700 hover:bg-neutral-200';
                }
            });
            
            // Boutons de période
            periodFilterBtns.forEach(btn => {
                const isActive = btn.dataset.periodFilter === activeFilters.period;
                btn.className = btn.className.replace(/bg-\[#[^\]]+\]/g, '').replace(/text-\[#[^\]]+\]/g, '');
                
                if (isActive) {
                    btn.className += ' bg-[#073066] text-white';
                } else {
                    btn.className += ' bg-neutral-100 text-neutral-700 hover:bg-neutral-200';
                }
            });
        }
        
        // Mise à jour du toggle "agréées"
        function updateVerifiedToggle() {
            const toggle = verifiedToggle;
            const span = toggle.querySelector('span');
            
            if (activeFilters.verified) {
                toggle.classList.remove('bg-neutral-200');
                toggle.classList.add('bg-[#073066]');
                span.classList.remove('translate-x-0');
                span.classList.add('translate-x-4');
            } else {
                toggle.classList.remove('bg-[#073066]');
                toggle.classList.add('bg-neutral-200');
                span.classList.remove('translate-x-4');
                span.classList.add('translate-x-0');
            }
        }
        
        // Event listeners
        
        // Recherche textuelle avec debounce
        let searchTimeout;
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                activeFilters.search = searchInput.value.toLowerCase().trim();
                applyFilters();
            }, 300);
        });
        
        // Filtres d'activité
        activityFilterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.activityFilter;
                activeFilters.activity = activeFilters.activity === filter ? null : filter;
                updateFilterButtons();
                applyFilters();
            });
        });
        
        // Filtres de période
        periodFilterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.periodFilter;
                activeFilters.period = activeFilters.period === filter ? null : filter;
                updateFilterButtons();
                applyFilters();
            });
        });
        
        // Filtre de localisation
        locationFilter.addEventListener('change', () => {
            activeFilters.location = locationFilter.value;
            applyFilters();
        });
        
        // Toggle "agréées"
        verifiedToggle.addEventListener('click', () => {
            activeFilters.verified = !activeFilters.verified;
            updateVerifiedToggle();
            applyFilters();
        });
        
        // Initialisation
        updateFilterButtons();
        updateVerifiedToggle();
        applyFilters();
    });
    
    // Fonction pour gérer le bouton J'aime avec compteur
    function toggleLike(button) {
        const isLiked = button.classList.contains('liked');
        const eventCard = button.closest('.event-card');
        const likesCountElement = eventCard.querySelector('.likes-count');
        let currentLikes = parseInt(likesCountElement.textContent);
        
        if (isLiked) {
            // Retirer le like
            button.classList.remove('liked', 'bg-red-50', 'text-red-600', 'border-red-200');
            button.classList.add('bg-white', 'text-neutral-700', 'border-neutral-200');
            button.innerHTML = '<i data-lucide="heart" class="h-4 w-4"></i>';
            currentLikes--;
        } else {
            // Ajouter le like
            button.classList.add('liked', 'bg-red-50', 'text-red-600', 'border-red-200');
            button.classList.remove('bg-white', 'text-neutral-700', 'border-neutral-200');
            button.innerHTML = '<i data-lucide="heart" class="h-4 w-4 fill-current"></i>';
            currentLikes++;
        }
        
        // Mettre à jour le compteur
        likesCountElement.textContent = currentLikes;
        button.setAttribute('data-likes', currentLikes);
        
        // Recréer les icônes Lucide
        lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
    }
    
    // Fonction pour incrémenter les vues
    function incrementViews(button) {
        const eventCard = button.closest('.event-card');
        const viewsCountElement = eventCard.querySelector('.views-count');
        let currentViews = parseInt(viewsCountElement.textContent);
        
        // Incrémenter les vues
        currentViews++;
        viewsCountElement.textContent = currentViews;
        button.setAttribute('data-views', currentViews);
        
        // Ici vous pouvez ajouter une requête AJAX pour sauvegarder en base de données
        // fetch('/events/increment-views', { method: 'POST', ... });
    }
</script>
@endpush
@endsection
