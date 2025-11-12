/**
 * Skeleton Loader Utility
 * Gère l'affichage des skeletons pendant le chargement des données
 */

class SkeletonLoader {
    constructor() {
        this.activeLoaders = new Set();
    }

    /**
     * Affiche un skeleton dans un conteneur
     * @param {string} containerId - ID du conteneur
     * @param {string} skeletonType - Type de skeleton à afficher
     * @param {object} options - Options supplémentaires
     */
    show(containerId, skeletonType = 'default', options = {}) {
        const container = document.getElementById(containerId);
        if (!container) return;

        // Sauvegarde le contenu original
        if (!container.dataset.originalContent) {
            container.dataset.originalContent = container.innerHTML;
        }

        // Génère le skeleton HTML
        const skeletonHtml = this.generateSkeleton(skeletonType, options);
        container.innerHTML = skeletonHtml;
        
        this.activeLoaders.add(containerId);
    }

    /**
     * Cache le skeleton et restaure le contenu original
     * @param {string} containerId - ID du conteneur
     */
    hide(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        if (container.dataset.originalContent) {
            container.innerHTML = container.dataset.originalContent;
            delete container.dataset.originalContent;
        }

        this.activeLoaders.delete(containerId);
    }

    /**
     * Génère le HTML du skeleton selon le type
     * @param {string} type - Type de skeleton
     * @param {object} options - Options
     * @returns {string} HTML du skeleton
     */
    generateSkeleton(type, options = {}) {
        const count = options.count || 3;
        
        switch (type) {
            case 'chamber-cards':
                return this.generateChamberCardsSkeleton(count);
            case 'user-cards':
                return this.generateUserCardsSkeleton(count);
            case 'event-cards':
                return this.generateEventCardsSkeleton(count);
            case 'table-rows':
                return this.generateTableRowsSkeleton(count, options.columns || 4);
            case 'list-items':
                return this.generateListItemsSkeleton(count);
            case 'dashboard-stats':
                return this.generateDashboardStatsSkeleton();
            default:
                return this.generateDefaultSkeleton(count);
        }
    }

    generateChamberCardsSkeleton(count) {
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="group relative rounded-xl border border-neutral-100 dark:border-gray-600 p-4 bg-gradient-to-br from-white to-green-50/30 dark:from-gray-800 dark:to-green-900/10 animate-pulse">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="flex-1 min-w-0">
                            <div class="w-32 h-4 bg-gray-200 dark:bg-gray-700 rounded mb-1"></div>
                            <div class="w-24 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="w-16 h-6 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-20 h-7 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                            <div class="w-8 h-7 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                        </div>
                    </div>
                </div>
            `;
        }
        html += '</div>';
        return html;
    }

    generateDefaultSkeleton(count) {
        let html = '<div class="space-y-4">';
        for (let i = 0; i < count; i++) {
            html += '<div class="w-full h-4 bg-gray-200 dark:bg-gray-700 animate-pulse rounded"></div>';
        }
        html += '</div>';
        return html;
    }

    generateUserCardsSkeleton(count) {
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 animate-pulse">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        <div class="flex-1 min-w-0">
                            <div class="w-32 h-4 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                            <div class="w-48 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="w-20 h-6 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    </div>
                </div>
            `;
        }
        html += '</div>';
        return html;
    }

    generateEventCardsSkeleton(count) {
        let html = '<div class="space-y-4">';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-pulse">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="w-48 h-5 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                            <div class="w-32 h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        <div class="w-3/4 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>
            `;
        }
        html += '</div>';
        return html;
    }

    generateTableRowsSkeleton(count, columns) {
        let html = '';
        for (let i = 0; i < count; i++) {
            html += '<tr class="animate-pulse">';
            for (let j = 0; j < columns; j++) {
                html += '<td class="px-6 py-4"><div class="w-full h-4 bg-gray-200 dark:bg-gray-700 rounded"></div></td>';
            }
            html += '</tr>';
        }
        return html;
    }

    generateListItemsSkeleton(count) {
        let html = '<div class="space-y-3">';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="flex items-center space-x-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm animate-pulse">
                    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    <div class="flex-1 min-w-0">
                        <div class="w-40 h-4 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                        <div class="w-32 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                    <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
            `;
        }
        html += '</div>';
        return html;
    }

    generateDashboardStatsSkeleton() {
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">';
        for (let i = 0; i < 4; i++) {
            html += `
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 animate-pulse">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="w-24 h-4 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                            <div class="w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    </div>
                </div>
            `;
        }
        html += '</div>';
        return html;
    }

    /**
     * Cache tous les skeletons actifs
     */
    hideAll() {
        this.activeLoaders.forEach(containerId => {
            this.hide(containerId);
        });
    }
}

// Instance globale
window.skeletonLoader = new SkeletonLoader();

// Fonctions utilitaires
window.showSkeleton = (containerId, type, options) => {
    window.skeletonLoader.show(containerId, type, options);
};

window.hideSkeleton = (containerId) => {
    window.skeletonLoader.hide(containerId);
};

export default SkeletonLoader;