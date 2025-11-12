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

    // Créer un élément événement (style similaire aux chambres)
    function createEventElement(event) {
        const article = document.createElement("article");
        article.className =
            "rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4";

        article.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm">${escapeHtml(
                            event.chamber_name
                                ? event.chamber_name
                                      .substring(0, 2)
                                      .toUpperCase()
                                : "EV"
                        )}</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${escapeHtml(
                            event.title
                        )}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${escapeHtml(
                            event.chamber_name || "Événement général"
                        )}</div>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getEventStatusClass(
                    event.status
                )}">
                    ${escapeHtml(event.status || "En attente")}
                </span>
            </div>

            <div class="mb-3">
                <p class="text-sm text-gray-600 dark:text-gray-300">${escapeHtml(
                    event.description
                        ? event.description.substring(0, 150) + "..."
                        : "Aucune description disponible"
                )}</p>
            </div>

            <div class="flex flex-wrap gap-2 mb-3">
                <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-700 dark:text-gray-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    ${formatDate(event.date)}
                </span>
                
                ${
                    event.location
                        ? `
                <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-700 dark:text-gray-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    ${escapeHtml(event.location)}
                </span>
                `
                        : ""
                }

                ${
                    event.type
                        ? `
                <span class="inline-flex items-center rounded-md bg-blue-100 dark:bg-blue-900 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    ${escapeHtml(event.type)}
                </span>
                `
                        : ""
                }

                ${
                    event.participants_count
                        ? `
                <span class="inline-flex items-center rounded-md bg-green-100 dark:bg-green-900 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    ${event.participants_count} participant${
                              event.participants_count > 1 ? "s" : ""
                          }
                </span>
                `
                        : ""
                }
            </div>

            <div class="flex gap-2">
                <button onclick="likeEvent(${
                    event.id
                })" class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    J'aime
                </button>
                
                ${
                    event.can_register !== false
                        ? `
                <button onclick="registerEvent(${event.id})" class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    S'inscrire
                </button>
                `
                        : ""
                }
                
                <button onclick="viewEvent(${
                    event.id
                })" class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Voir détails
                </button>
            </div>
        `;

        return article;
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
