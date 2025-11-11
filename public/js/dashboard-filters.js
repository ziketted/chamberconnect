// Fonctionnalité des filtres pour le dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les icônes Lucide
    lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
    
    const searchInput = document.getElementById('search-input');
    const eventCards = document.querySelectorAll('.event-card');
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    // Fonction pour appliquer les filtres
    function applyFilters() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const activeFilter = document.querySelector('.filter-btn.bg-blue-600');
        const filter = activeFilter ? activeFilter.dataset.filter : 'all';
        
        let visibleCount = 0;
        
        eventCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            const chamberName = card.dataset.chamberName || '';
            const location = card.dataset.location || '';
            
            // Vérifier la recherche
            const matchesSearch = !searchTerm || 
                title.includes(searchTerm) || 
                description.includes(searchTerm) || 
                chamberName.includes(searchTerm) || 
                location.includes(searchTerm);
            
            // Vérifier le filtre
            let matchesFilter = true;
            
            if (filter === 'this-month') {
                const eventDate = new Date(card.dataset.eventDate);
                const currentDate = new Date();
                matchesFilter = eventDate.getMonth() === currentDate.getMonth() && 
                              eventDate.getFullYear() === currentDate.getFullYear();
            } else if (filter === 'this-week') {
                const eventDate = new Date(card.dataset.eventDate);
                const currentDate = new Date();
                const startOfWeek = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay()));
                const endOfWeek = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 6));
                matchesFilter = eventDate >= startOfWeek && eventDate <= endOfWeek;
            } else if (filter === 'certified') {
                matchesFilter = card.dataset.isUserChamber === 'true';
            } else if (filter === 'forum') {
                matchesFilter = card.dataset.eventType === 'forum';
            } else if (filter === 'networking') {
                matchesFilter = card.dataset.eventType === 'networking';
            }
            
            const shouldShow = matchesSearch && matchesFilter;
            card.style.display = shouldShow ? 'block' : 'none';
            
            if (shouldShow) visibleCount++;
        });
        
        // Gérer l'affichage du message "aucun résultat"
        handleNoResultsMessage(visibleCount, searchTerm, filter);
    }
    
    // Fonction pour gérer le message "aucun résultat"
    function handleNoResultsMessage(visibleCount, searchTerm, filter) {
        const eventsList = document.getElementById('events-list');
        let noResultsMessage = eventsList.querySelector('.no-results-message');
        
        if (visibleCount === 0) {
            if (!noResultsMessage) {
                noResultsMessage = document.createElement('div');
                noResultsMessage.className = 'no-results-message text-center py-12';
                eventsList.appendChild(noResultsMessage);
            }
            
            let message = 'Aucun événement trouvé';
            let description = 'Essayez de modifier vos critères de recherche ou de filtrage.';
            
            if (searchTerm) {
                description = `Aucun événement ne correspond à votre recherche "${searchTerm}".`;
            } else if (filter === 'this-month') {
                description = 'Aucun événement prévu pour ce mois.';
            } else if (filter === 'this-week') {
                description = 'Aucun événement prévu pour cette semaine.';
            } else if (filter === 'certified') {
                description = 'Aucun événement dans vos chambres pour le moment.';
            } else if (filter === 'forum') {
                description = 'Aucun forum prévu actuellement.';
            } else if (filter === 'networking') {
                description = 'Aucun événement de networking prévu.';
            }
            
            noResultsMessage.innerHTML = `
                <div class="h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="search-x" class="h-8 w-8 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">${message}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">${description}</p>
                <button onclick="resetFilters()" class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                    Réinitialiser
                </button>
            `;
            
            noResultsMessage.style.display = 'block';
            lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
        } else {
            if (noResultsMessage) {
                noResultsMessage.style.display = 'none';
            }
        }
    }
    
    // Événements pour la recherche
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    
    // Événements pour les filtres
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
            });
            
            // Ajouter la classe active au bouton cliqué
            this.classList.remove('bg-neutral-100', 'dark:bg-gray-700', 'text-neutral-700', 'dark:text-gray-300');
            this.classList.add('bg-blue-600', 'text-white');
            
            applyFilters();
        });
    });
    
    // Fonction globale pour réinitialiser les filtres
    window.resetFilters = function() {
        // Réinitialiser la recherche
        if (searchInput) {
            searchInput.value = '';
        }
        
        // Réinitialiser au filtre "Tous"
        const allButton = document.querySelector('[data-filter="all"]');
        if (allButton) {
            allButton.click();
        }
    };
});