// Système de filtres pour les événements
class EventFilters {
    constructor() {
        this.activeFilters = {
            type: null,
            mode: null,
            verified: null,
            available: null,
            search: ''
        };
        
        this.init();
    }

    init() {
        // Attendre que le DOM soit chargé
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        console.log('Initializing event filters...');
        
        // Sélecteurs
        this.searchInput = document.getElementById('events-search');
        this.clearFiltersBtn = document.getElementById('clear-filters');
        
        // Attacher les événements
        this.attachEvents();
        
        // Initialiser l'affichage
        this.applyFilters();
        
        console.log('Event filters initialized successfully');
    }

    getEventCards() {
        return document.querySelectorAll('.event-card');
    }

    getFilterButtons() {
        return document.querySelectorAll('[data-filter]:not([data-filter="clear"])');
    }

    attachEvents() {
        // Boutons de filtre
        this.getFilterButtons().forEach(button => {
            button.addEventListener('click', (e) => this.handleFilterClick(e));
        });

        // Bouton effacer filtres
        if (this.clearFiltersBtn) {
            this.clearFiltersBtn.addEventListener('click', () => this.clearAllFilters());
        }

        // Recherche textuelle
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => {
                this.activeFilters.search = e.target.value.toLowerCase();
                this.applyFilters();
            });
        }
    }

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
            this.getFilterButtons().forEach(btn => {
                if (btn.getAttribute('data-filter') === filterType && btn !== button) {
                    this.resetButtonStyle(btn);
                }
            });
            
            // Activer ce filtre
            this.activeFilters[filterType] = filterValue;
            this.activateButtonStyle(button, filterType);
        }

        this.applyFilters();
    }

    resetButtonStyle(button) {
        button.classList.remove('bg-blue-600', 'bg-green-600', 'bg-purple-600', 'text-white');
        button.classList.add('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
    }

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
    }

    applyFilters() {
        const eventCards = this.getEventCards();
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
    }

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
    }

    updateClearButton() {
        if (!this.clearFiltersBtn) return;

        const hasActiveFilters = Object.values(this.activeFilters).some(value => value !== null && value !== '');
        this.clearFiltersBtn.style.display = hasActiveFilters ? 'inline-flex' : 'none';
    }

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
        this.getFilterButtons().forEach(button => {
            this.resetButtonStyle(button);
        });

        // Vider la recherche
        if (this.searchInput) {
            this.searchInput.value = '';
        }

        // Appliquer les filtres
        this.applyFilters();
    }

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
                // Réinitialiser les icônes Lucide
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        } else if (!show && noResultsDiv) {
            noResultsDiv.remove();
        }
    }
}

// Initialiser les filtres
const eventFilters = new EventFilters();

// Fonction globale pour compatibilité
window.clearAllEventFilters = function() {
    eventFilters.clearAllFilters();
};