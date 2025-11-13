// Lazy loading automatique pour les événements du dashboard
document.addEventListener("DOMContentLoaded", function () {
    // Créer une section dédiée aux événements dans le dashboard
    createEventsSection();

    // Trouver le container des événements
    const eventsContainer = document.getElementById("events-container");
    const loadingIndicator = document.getElementById("events-loading");

    if (!eventsContainer) {
        console.warn("Container des événements non trouvé");
        return;
    }

    let isLoading = false;
    let currentPage = 1;
    let hasMoreEvents = true;

    // Charger automatiquement les premiers événements
    loadMoreEvents();

    // Ajouter l'event listener pour le bouton "Charger plus" après création de la section
    setTimeout(() => {
        const loadMoreBtn = document.getElementById("load-more-events");
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener("click", loadMoreEvents);
        }
    }, 100);

    // Fonction pour créer la section d'événements
    function createEventsSection() {
        // Vérifier si la section existe déjà
        if (document.getElementById("events-container")) return;

        // Trouver le main content (colonne du milieu)
        const mainContent = document.querySelector("main.lg\\:col-span-6");
        if (!mainContent) return;

        // Créer la section d'événements
        const eventsSection = document.createElement("div");
        eventsSection.className =
            "rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4";
        eventsSection.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Événements récents</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">Chargement automatique</span>
            </div>
            <div id="events-container" class="space-y-4">
                <!-- Les événements seront chargés ici -->
            </div>
            <div id="events-loading" class="text-center py-6" style="display: none;">
                <div class="inline-flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Chargement des événements...
                </div>
            </div>
            <button id="load-more-events" class="w-full mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors" style="display: none;">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Charger plus d'événements
            </button>
        `;

        // Insérer après le premier élément (create post ou premier article)
        const firstChild = mainContent.children[1] || mainContent.children[0];
        if (firstChild) {
            mainContent.insertBefore(eventsSection, firstChild.nextSibling);
        } else {
            mainContent.appendChild(eventsSection);
        }
    }

    // Fonction pour créer le message de fin
    function createEndMessage() {
        const endDiv = document.createElement("div");
        endDiv.className = "text-center py-4";
        endDiv.innerHTML = `
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Tous les événements ont été chargés
            </p>
        `;
        return endDiv;
    }

    // Fonction pour charger plus d'événements
    async function loadMoreEvents() {
        if (isLoading || !hasMoreEvents) return;

        isLoading = true;

        // Afficher l'indicateur de chargement
        if (loadingIndicator) {
            loadingIndicator.style.display = "block";
        }

        try {
            const response = await fetch(
                `/dashboard/load-events?page=${currentPage}`,
                {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                }
            );

            if (!response.ok) throw new Error("Erreur de chargement");

            const data = await response.json();

            if (data.events && data.events.length > 0) {
                // Ajouter les nouveaux événements
                data.events.forEach((event) => {
                    const eventElement = createEventElement(event);
                    eventsContainer.appendChild(eventElement);
                });

                currentPage++;
                hasMoreEvents = data.hasMore || false;

                // Gérer l'affichage du bouton "Charger plus" et du message de fin
                const loadMoreBtn = document.getElementById("load-more-events");

                if (!hasMoreEvents) {
                    // Masquer le bouton et afficher le message de fin
                    if (loadMoreBtn) {
                        loadMoreBtn.style.display = "none";
                    }
                    if (loadingIndicator) {
                        loadingIndicator.remove();
                    }
                    eventsContainer.parentNode.appendChild(createEndMessage());
                } else {
                    // Afficher le bouton "Charger plus" si il y a encore des événements
                    if (loadMoreBtn) {
                        loadMoreBtn.style.display = "block";
                    }
                }
            } else {
                hasMoreEvents = false;
                if (currentPage === 1) {
                    showNoEventsMessage();
                } else {
                    if (loadingIndicator) {
                        loadingIndicator.remove();
                    }
                    eventsContainer.parentNode.appendChild(createEndMessage());
                }
            }
        } catch (error) {
            console.error("Erreur lors du chargement des événements:", error);
            showError("Erreur lors du chargement des événements");
        } finally {
            isLoading = false;
            if (loadingIndicator) {
                loadingIndicator.style.display = "none";
            }
        }
    }

    // Créer un élément événement (style identique aux chambres)
    function createEventElement(event) {
        const div = document.createElement("div");
        div.className = "chamber-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 hover:shadow-sm transition-all duration-200 relative";

        div.innerHTML = `
            <!-- Statut d'événement dans le coin supérieur droit -->
            <div class="absolute top-4 right-4">
                <span class="inline-flex items-center gap-1.5 rounded-full ${getEventStatusBadgeClass(event.status)} px-3 py-1.5 text-xs font-medium">
                    <i data-lucide="${getEventStatusIcon(event.status)}" class="h-3.5 w-3.5"></i>
                    ${escapeHtml(event.status || "En attente")}
                </span>
            </div>

            <div class="flex items-start gap-4 flex-1 pr-20">
                <div class="relative">
                    <div class="relative flex h-14 w-14 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex flex-col items-center text-sm font-semibold leading-none">
                            <span>${escapeHtml(event.chamber_name ? event.chamber_name.substring(0, 2).toUpperCase() : 'EV')}</span>
                        </div>
                    </div>
                    ${event.is_user_chamber ? `
                        <div class="absolute -right-1 -top-1 rounded-full bg-white dark:bg-gray-800 p-0.5 shadow-sm">
                            <div class="flex h-5 w-5 items-center justify-center rounded-full bg-yellow-500 text-white">
                                <i data-lucide="star" class="h-3 w-3"></i>
                            </div>
                        </div>
                    ` : ''}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-base font-medium cursor-pointer hover:text-[#073066] dark:hover:text-blue-400 transition-colors">${escapeHtml(event.title)}</h3>
                        ${getEventTypeBadge(event.type)}
                    </div>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400 text-justify">
                        ${escapeHtml(event.description ? event.description.substring(0, 150) + '...' : 'Aucune description disponible')}
                    </p>
                    <div class="mt-3 space-y-2">
                        <!-- Première ligne : Date et Lieu -->
                        <div class="flex items-center flex-wrap gap-4">
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="calendar" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                ${formatDate(event.date)}
                            </span>
                            ${event.location ? `
                                <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                    <i data-lucide="map-pin" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                    ${escapeHtml(event.location)}
                                </span>
                            ` : ''}
                            ${event.participants ? `
                                <div class="inline-flex items-center gap-1.5 rounded-full bg-[#fcb357]/10 px-2.5 py-1 text-xs font-medium text-[#fcb357]">
                                    <i data-lucide="users" class="h-3.5 w-3.5"></i>
                                    ${event.participants}${event.max_participants ? `/${event.max_participants}` : ''} participants
                                </div>
                            ` : ''}
                        </div>

                        <!-- Deuxième ligne : Chambre et Prix -->
                        <div class="flex items-center flex-wrap gap-4">
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-400">
                                <i data-lucide="building" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                ${escapeHtml(event.chamber_name || 'Chambre inconnue')}
                            </span>
                            ${event.price ? `
                                <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-400">
                                    <i data-lucide="tag" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                    ${escapeHtml(event.price)}
                                </span>
                            ` : ''}
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-4 flex gap-2">
                        <button onclick="likeEvent(${event.id})" class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:hover:bg-gray-700">
                            <i data-lucide="heart" class="h-4 w-4"></i>
                            J'aime
                        </button>
                        ${event.status !== 'complet' && event.status !== 'cancelled' ? `
                            <button onclick="registerEvent(${event.id})" class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                S'inscrire
                            </button>
                        ` : ''}
                        <button onclick="viewEvent(${event.id})" class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:hover:bg-gray-700">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                            Voir détails
                        </button>
                    </div>
                </div>
            </div>
        `;

        return div;
    }

    // Fonction pour obtenir la classe CSS du badge de statut
    function getEventStatusBadgeClass(status) {
        switch (status) {
            case "confirmé":
            case "confirmed":
                return "bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800";
            case "annulé":
            case "cancelled":
                return "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800";
            case "reporté":
            case "postponed":
                return "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800";
            case "complet":
            case "full":
                return "bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 border border-orange-200 dark:border-orange-800";
            default:
                return "bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800";
        }
    }

    // Fonction pour obtenir l'icône du statut
    function getEventStatusIcon(status) {
        switch (status) {
            case "confirmé":
            case "confirmed":
                return "check-circle";
            case "annulé":
            case "cancelled":
                return "x-circle";
            case "reporté":
            case "postponed":
                return "clock";
            case "complet":
            case "full":
                return "users-x";
            default:
                return "calendar";
        }
    }

    // Fonction pour obtenir le badge du type d'événement
    function getEventTypeBadge(type) {
        if (!type) return '';
        
        const typeClasses = {
            'forum': 'bg-[#073066]/10 text-[#073066] dark:text-blue-400',
            'atelier': 'bg-[#fcb357]/10 text-[#fcb357]',
            'networking': 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
            'conference': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
            'formation': 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400'
        };
        
        const className = typeClasses[type] || 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
        
        return `
            <span class="inline-flex items-center gap-1 rounded-full ${className} px-2 py-0.5 text-xs font-medium">
                <i data-lucide="${getTypeIcon(type)}" class="h-3.5 w-3.5"></i> 
                ${escapeHtml(type.charAt(0).toUpperCase() + type.slice(1))}
            </span>
        `;
    }

    // Fonction pour obtenir l'icône du type
    function getTypeIcon(type) {
        const icons = {
            'forum': 'users',
            'atelier': 'wrench',
            'networking': 'network',
            'conference': 'presentation',
            'formation': 'graduation-cap'
        };
        return icons[type] || 'calendar';
    }

    // Fonction utilitaire pour échapper le HTML
    function escapeHtml(text) {
        if (!text) return "";
        const div = document.createElement("div");
        div.textContent = text;
        return div.innerHTML;
    }

    // Fonction pour formater la date
    function formatDate(dateString) {
        if (!dateString) return "Date non définie";
        const date = new Date(dateString);
        return date.toLocaleDateString("fr-FR", {
            year: "numeric",
            month: "short",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        });
    }

    // Fonction pour obtenir la classe CSS du statut
    function getEventStatusClass(status) {
        switch (status) {
            case "confirmé":
            case "confirmed":
                return "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300";
            case "annulé":
            case "cancelled":
                return "bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300";
            case "reporté":
            case "postponed":
                return "bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300";
            case "complet":
            case "full":
                return "bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300";
            default:
                return "bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300";
        }
    }

    // Fonction pour afficher les erreurs
    function showError(message) {
        const errorDiv = document.createElement("div");
        errorDiv.className =
            "bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4";
        errorDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                ${message}
            </div>
        `;
        eventsContainer.appendChild(errorDiv);

        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.remove();
            }
        }, 5000);
    }

    // Fonction pour afficher le message "aucun événement"
    function showNoEventsMessage() {
        const noEventsDiv = document.createElement("div");
        noEventsDiv.className =
            "text-center py-12 text-gray-500 dark:text-gray-400";
        noEventsDiv.innerHTML = `
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium mb-2">Aucun événement disponible</h3>
            <p class="text-sm">Les événements apparaîtront ici une fois créés par les chambres.</p>
        `;
        eventsContainer.appendChild(noEventsDiv);
    }

    // Lazy loading automatique au scroll
    let scrollTimeout;
    window.addEventListener("scroll", function () {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            const scrollPosition = window.innerHeight + window.scrollY;
            const documentHeight = document.documentElement.offsetHeight;

            // Charger plus quand on arrive à 80% du bas de la page
            if (
                scrollPosition >= documentHeight * 0.8 &&
                !isLoading &&
                hasMoreEvents
            ) {
                loadMoreEvents();
            }
        }, 100);
    });

    // Fonctions globales pour les interactions
    window.likeEvent = function (eventId) {
        console.log("Like event:", eventId);
        // Ici tu peux ajouter l'appel AJAX pour liker l'événement
    };

    window.viewEvent = function (eventId) {
        console.log("View event:", eventId);
        // Ici tu peux ajouter la redirection vers la page de l'événement
    };

    window.registerEvent = function (eventId) {
        console.log("Register for event:", eventId);
        // Ici tu peux ajouter l'appel AJAX pour s'inscrire à l'événement
    };

    // Initialiser les icônes Lucide après le chargement
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
});
