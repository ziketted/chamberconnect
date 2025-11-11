<!-- Popup de confirmation moderne -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay avec effet de flou -->
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 backdrop-blur-sm" onclick="closeConfirmationModal()"></div>
        
        <!-- Modal -->
        <div class="inline-block transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:align-middle animate-in zoom-in-95 duration-200">
            <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                <!-- Icône dynamique -->
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4" id="confirmIcon">
                    <i data-lucide="alert-triangle" class="h-8 w-8 text-amber-600"></i>
                </div>
                
                <!-- Contenu -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2" id="confirmTitle">
                        Confirmer l'action
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 leading-relaxed" id="confirmMessage">
                        Êtes-vous sûr de vouloir effectuer cette action ?
                    </p>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                <button type="button" onclick="closeConfirmationModal()"
                        class="inline-flex w-full justify-center rounded-lg border border-gray-300 dark:border-gray-600 dark:border-gray-400 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto transition-colors">
                    <i data-lucide="x" class="h-4 w-4 mr-2"></i>
                    Annuler
                </button>
                <button type="button" id="confirmButton"
                        class="inline-flex w-full justify-center rounded-lg border border-transparent px-4 py-2.5 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto transition-colors">
                    <i data-lucide="check" class="h-4 w-4 mr-2"></i>
                    <span id="confirmButtonText">Confirmer</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes zoom-in-95 {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-in {
    animation-fill-mode: both;
}

.zoom-in-95 {
    animation-name: zoom-in-95;
}

.duration-200 {
    animation-duration: 200ms;
}

#confirmationModal .backdrop-blur-sm {
    backdrop-filter: blur(4px);
}
</style>

<script>
// Variables globales pour le popup de confirmation
let confirmationCallback = null;
let confirmationData = null;

// Configuration des types de confirmation
const confirmationTypes = {
    danger: {
        icon: 'alert-triangle',
        iconClass: 'bg-red-100 text-red-600',
        buttonClass: 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        buttonText: 'Supprimer'
    },
    warning: {
        icon: 'alert-circle',
        iconClass: 'bg-amber-100 text-amber-600',
        buttonClass: 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        buttonText: 'Continuer'
    },
    info: {
        icon: 'info',
        iconClass: 'bg-blue-100 text-blue-600',
        buttonClass: 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        buttonText: 'Confirmer'
    },
    success: {
        icon: 'check-circle',
        iconClass: 'bg-green-100 text-green-600',
        buttonClass: 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
        buttonText: 'Valider'
    }
};

// Fonction principale pour afficher le popup de confirmation
function showConfirmation(options) {
    const {
        title = 'Confirmer l\'action',
        message = 'Êtes-vous sûr de vouloir effectuer cette action ?',
        type = 'warning',
        confirmText = null,
        callback = null,
        data = null
    } = options;

    // Stocker le callback et les données
    confirmationCallback = callback;
    confirmationData = data;

    // Récupérer la configuration du type
    const config = confirmationTypes[type] || confirmationTypes.warning;

    // Mettre à jour le contenu du modal
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMessage').textContent = message;
    document.getElementById('confirmButtonText').textContent = confirmText || config.buttonText;

    // Mettre à jour l'icône
    const iconContainer = document.getElementById('confirmIcon');
    const icon = iconContainer.querySelector('i');
    
    // Réinitialiser les classes
    iconContainer.className = `mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4 ${config.iconClass}`;
    icon.setAttribute('data-lucide', config.icon);
    icon.className = `h-8 w-8`;

    // Mettre à jour le bouton
    const confirmButton = document.getElementById('confirmButton');
    confirmButton.className = `inline-flex w-full justify-center rounded-lg border border-transparent px-4 py-2.5 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto transition-colors ${config.buttonClass}`;

    // Afficher le modal
    const modal = document.getElementById('confirmationModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Réinitialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Focus sur le bouton d'annulation par défaut
    setTimeout(() => {
        modal.querySelector('button[onclick="closeConfirmationModal()"]').focus();
    }, 100);
}

// Fermer le popup de confirmation
function closeConfirmationModal() {
    const modal = document.getElementById('confirmationModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Réinitialiser les variables
    confirmationCallback = null;
    confirmationData = null;
}

// Gérer la confirmation
document.getElementById('confirmButton').addEventListener('click', function() {
    if (confirmationCallback && typeof confirmationCallback === 'function') {
        confirmationCallback(confirmationData);
    }
    closeConfirmationModal();
});

// Fermer avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('confirmationModal');
        if (!modal.classList.contains('hidden')) {
            closeConfirmationModal();
        }
    }
});

// Fonctions spécifiques pour les actions courantes
function confirmRemoveManager(managerId, managerName) {
    showConfirmation({
        title: 'Retirer le gestionnaire',
        message: `Êtes-vous sûr de vouloir retirer "${managerName}" de son rôle de gestionnaire ? Cette action ne peut pas être annulée.`,
        type: 'danger',
        confirmText: 'Retirer',
        callback: function() {
            document.getElementById(`remove-manager-form-${managerId}`).submit();
        }
    });
}

function confirmRemoveMember(chamberSlug, userId, userName) {
    showConfirmation({
        title: 'Retirer le membre',
        message: `Êtes-vous sûr de vouloir retirer "${userName}" de cette chambre ? Cette action ne peut pas être annulée.`,
        type: 'danger',
        confirmText: 'Retirer',
        callback: function() {
            removeMemberAction(chamberSlug, userId);
        }
    });
}

function confirmPromoteManager(chamberSlug, userId, userName) {
    showConfirmation({
        title: 'Promouvoir en gestionnaire',
        message: `Êtes-vous sûr de vouloir promouvoir "${userName}" au rôle de gestionnaire de cette chambre ?`,
        type: 'success',
        confirmText: 'Promouvoir',
        callback: function() {
            promoteToManagerAction(chamberSlug, userId);
        }
    });
}

function confirmUncertify() {
    showConfirmation({
        title: 'Retirer l\'agrément',
        message: 'Êtes-vous sûr de vouloir retirer l\'agrément de cette chambre ? Cette action affectera son statut public.',
        type: 'warning',
        confirmText: 'Retirer',
        callback: function() {
            // Le formulaire sera soumis automatiquement
            return true;
        }
    });
}

function confirmUnverify() {
    showConfirmation({
        title: 'Retirer la vérification',
        message: 'Êtes-vous sûr de vouloir retirer la vérification de cette chambre ?',
        type: 'warning',
        confirmText: 'Retirer',
        callback: function() {
            // Le formulaire sera soumis automatiquement
            return true;
        }
    });
}

function confirmSuspend() {
    showConfirmation({
        title: 'Suspendre la chambre',
        message: 'Êtes-vous sûr de vouloir suspendre cette chambre ? Cette action est très grave et affectera tous ses membres.',
        type: 'danger',
        confirmText: 'Suspendre',
        callback: function() {
            // Le formulaire sera soumis automatiquement
            return true;
        }
    });
}

// Actions réelles (à implémenter selon vos besoins)
function removeMemberAction(chamberSlug, userId) {
    fetch(`/admin/chambers/${chamberSlug}/remove-member`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur lors de la suppression du membre');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la suppression du membre');
    });
}

function promoteToManagerAction(chamberSlug, userId) {
    fetch(`/admin/chambers/${chamberSlug}/assign-manager`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Erreur lors de la promotion');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la promotion');
    });
}
</script>
