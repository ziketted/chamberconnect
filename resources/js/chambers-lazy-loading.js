// Lazy loading automatique pour la page des chambres
document.addEventListener("DOMContentLoaded", function () {
    const chambersList = document.getElementById("chambers-list");
    const loadingIndicator = document.getElementById("loading-indicator");
    const endMessage = document.getElementById("end-message");

    if (!chambersList) {
        console.warn("Container des chambres non trouvé");
        return;
    }

    let isLoading = false;
    let currentPage = 2; // Commencer à la page 2 car la page 1 est déjà chargée
    let hasMoreChambers = true;

    // Fonction pour charger plus de chambres
    async function loadMoreChambers() {
        if (isLoading || !hasMoreChambers) return;

        isLoading = true;

        // Afficher l'indicateur de chargement
        if (loadingIndicator) {
            loadingIndicator.classList.remove("hidden");
        }

        try {
            const response = await fetch(`/chambers?page=${currentPage}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            });

            if (!response.ok) throw new Error("Erreur de chargement");

            const data = await response.json();

            if (data.chambers && data.chambers.length > 0) {
                // Ajouter les nouvelles chambres
                data.chambers.forEach((chamber) => {
                    const chamberElement = createChamberElement(chamber);
                    chambersList.appendChild(chamberElement);
                });

                currentPage++;
                hasMoreChambers = data.hasMore || false;

                if (!hasMoreChambers) {
                    // Afficher le message de fin
                    if (endMessage) {
                        endMessage.classList.remove("hidden");
                    }
                }
            } else {
                hasMoreChambers = false;
                if (endMessage) {
                    endMessage.classList.remove("hidden");
                }
            }
        } catch (error) {
            console.error("Erreur lors du chargement des chambres:", error);
            showError("Erreur lors du chargement des chambres");
        } finally {
            isLoading = false;
            if (loadingIndicator) {
                loadingIndicator.classList.add("hidden");
            }
        }
    }

    // Créer un élément chambre
    function createChamberElement(chamber) {
        const div = document.createElement("div");
        div.className =
            "chamber-card group rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 hover:shadow-sm transition-all duration-200 relative";

        // Ajouter les attributs de données pour les filtres
        div.setAttribute("data-name", chamber.name.toLowerCase());
        div.setAttribute(
            "data-description",
            (chamber.description || "").toLowerCase()
        );
        div.setAttribute("data-activity-level", chamber.activity_level || "");
        div.setAttribute("data-events-count", chamber.upcoming_events || 0);
        div.setAttribute("data-members-count", chamber.members_count || 0);
        div.setAttribute(
            "data-certified",
            chamber.is_certified ? "true" : "false"
        );
        div.setAttribute("data-created", chamber.created_at || "2024-01-01");

        // Vérifier si l'utilisateur est connecté
        const isAuthenticated =
            document
                .querySelector('meta[name="user-authenticated"]')
                ?.getAttribute("content") === "true";
        const isMember = chamber.is_subscribed || false;

        div.innerHTML = `
            <!-- Statut d'adhésion dans le coin supérieur droit -->
            <div class="absolute top-4 right-4">
                ${
                    isAuthenticated
                        ? !isMember
                            ? `
                        <form action="/chambers/${
                            chamber.slug
                        }/join" method="POST" class="inline">
                            <input type="hidden" name="_token" value="${document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")}">
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#073066] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-all duration-200 shadow-sm hover:shadow-md"
                                title="Adhérer à cette chambre">
                                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                Adhérer
                            </button>
                        </form>
                    `
                            : `
                        <div class="inline-flex items-center gap-1.5 rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800">
                            <i data-lucide="check" class="h-3.5 w-3.5"></i>
                            Membre
                        </div>
                    `
                        : `
                    <button onclick="openModal('signin-modal')"
                        class="inline-flex items-center gap-1.5 rounded-full bg-[#073066] px-3 py-1.5 text-xs font-medium text-white hover:bg-[#052347] transition-all duration-200 shadow-sm hover:shadow-md">
                        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                        Adhérer
                    </button>
                `
                }
            </div>

            <div class="flex items-start gap-4 flex-1 pr-20">
                <div class="relative">
                    ${
                        isAuthenticated
                            ? `
                        <a href="/chamber/${chamber.slug}" class="block">
                    `
                            : `
                        <button onclick="openModal('signin-modal')" class="block">
                    `
                    }
                        ${
                            chamber.logo_path
                                ? `
                            <img src="/storage/${chamber.logo_path}"
                                alt="${escapeHtml(chamber.name)}"
                                class="h-14 w-14 rounded-lg object-cover shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                        `
                                : `
                            <div class="relative flex h-14 w-14 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                <div class="flex flex-col items-center text-sm font-semibold leading-none">
                                    <span>${chamber.code.substring(0, 2)}</span>
                                    <span class="mt-0.5 text-white/80">${chamber.code.substring(
                                        2
                                    )}</span>
                                </div>
                            </div>
                        `
                        }
                        ${
                            chamber.is_certified
                                ? `
                            <div class="absolute -right-1 -top-1 rounded-full bg-white dark:bg-gray-800 p-0.5 shadow-sm">
                                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-[#fcb357] text-white">
                                    <i data-lucide="shield-check" class="h-3 w-3"></i>
                                </div>
                            </div>
                        `
                                : ""
                        }
                    ${isAuthenticated ? "</a>" : "</button>"}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        ${
                            isAuthenticated
                                ? `
                            <a href="/chamber/${
                                chamber.slug
                            }" class="hover:text-[#073066] dark:hover:text-blue-400 transition-colors">
                                <h3 class="text-base font-medium cursor-pointer">${escapeHtml(
                                    chamber.name
                                )}</h3>
                            </a>
                        `
                                : `
                            <button onclick="openModal('signin-modal')" class="hover:text-[#073066] dark:hover:text-blue-400 transition-colors">
                                <h3 class="text-base font-medium cursor-pointer">${escapeHtml(
                                    chamber.name
                                )}</h3>
                            </button>
                        `
                        }
                        ${
                            chamber.is_certified
                                ? `
                            <span class="inline-flex items-center gap-1 rounded-full bg-[#fcb357]/10 px-2 py-0.5 text-xs font-medium text-[#fcb357]">
                                <i data-lucide="shield-check" class="h-3.5 w-3.5"></i> Agréée
                            </span>
                        `
                                : ""
                        }
                    </div>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400 text-justify">
                        ${escapeHtml(
                            chamber.description
                                ? chamber.description.substring(0, 150) + "..."
                                : ""
                        )}
                    </p>
                    <div class="mt-3 space-y-2">
                        <!-- Première ligne : Membres et Événements -->
                        <div class="flex items-center flex-wrap gap-4">
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="users" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                ${formatNumber(chamber.members_count)} membres
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="calendar" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                ${chamber.upcoming_events} événements
                            </span>
                            ${
                                chamber.upcoming_events > 0
                                    ? `
                                <div class="inline-flex items-center gap-1.5 rounded-full bg-[#fcb357]/10 px-2.5 py-1 text-xs font-medium text-[#fcb357]">
                                    <i data-lucide="calendar-clock" class="h-3.5 w-3.5"></i>
                                    ${chamber.activity_level}
                                </div>
                            `
                                    : ""
                            }
                        </div>

                        <!-- Deuxième ligne : Date de création et Localisation -->
                        <div class="flex items-center flex-wrap gap-4">
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-400">
                                <i data-lucide="calendar-plus" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                Fondée en ${
                                    chamber.certification_date
                                        ? new Date(
                                              chamber.certification_date
                                          ).getFullYear()
                                        : new Date(
                                              chamber.created_at
                                          ).getFullYear()
                                }
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-400">
                                <i data-lucide="map-pin" class="h-4 w-4 text-neutral-400 dark:text-gray-400"></i>
                                ${chamber.location || "Non spécifiée"}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        return div;
    }

    // Fonction utilitaire pour échapper le HTML
    function escapeHtml(text) {
        if (!text) return "";
        const div = document.createElement("div");
        div.textContent = text;
        return div.innerHTML;
    }

    // Fonction pour formater les nombres
    function formatNumber(num) {
        return new Intl.NumberFormat("fr-FR").format(num);
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
        chambersList.appendChild(errorDiv);

        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.remove();
            }
        }, 5000);
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
                hasMoreChambers
            ) {
                loadMoreChambers();
            }
        }, 100);
    });

    // Initialiser les icônes Lucide après le chargement
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
});
