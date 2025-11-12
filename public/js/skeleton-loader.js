/**
 * Gestionnaire des skeleton loaders pour améliorer l'UX
 */
class SkeletonLoader {
    constructor() {
        this.activeSkeletons = new Set();
    }

    /**
     * Affiche un skeleton loader
     * @param {string} skeletonId - ID du skeleton à afficher
     * @param {string} contentId - ID du contenu à masquer
     */
    show(skeletonId, contentId = null) {
        const skeleton = document.getElementById(skeletonId);
        if (skeleton) {
            skeleton.style.display = 'block';
            this.activeSkeletons.add(skeletonId);
        }

        if (contentId) {
            const content = document.getElementById(contentId);
            if (content) {
                content.style.display = 'none';
            }
        }
    }

    /**
     * Masque un skeleton loader
     * @param {string} skeletonId - ID du skeleton à masquer
     * @param {string} contentId - ID du contenu à afficher
     */
    hide(skeletonId, contentId = null) {
        const skeleton = document.getElementById(skeletonId);
        if (skeleton) {
            skeleton.style.display = 'none';
            this.activeSkeletons.delete(skeletonId);
        }

        if (contentId) {
            const content = document.getElementById(contentId);
            if (content) {
                content.style.display = 'block';
            }
        }
    }

    /**
     * Simule un chargement avec skeleton
     * @param {string} skeletonId - ID du skeleton
     * @param {string} contentId - ID du contenu
     * @param {number} duration - Durée en millisecondes
     */
    simulate(skeletonId, contentId, duration = 2000) {
        this.show(skeletonId, contentId);
        
        setTimeout(() => {
            this.hide(skeletonId, contentId);
        }, duration);
    }

    /**
     * Affiche les skeletons pendant un appel AJAX
     * @param {string} skeletonId - ID du skeleton
     * @param {string} contentId - ID du contenu
     * @param {Promise} promise - Promise de l'appel AJAX
     */
    async showDuringAjax(skeletonId, contentId, promise) {
        this.show(skeletonId, contentId);
        
        try {
            const result = await promise;
        