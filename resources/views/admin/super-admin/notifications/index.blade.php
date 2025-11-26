@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Centre de Notifications</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Envoyez des messages en masse à vos utilisateurs</p>
        </div>

        <!-- Onglets -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-8 border-b border-gray-200 dark:border-gray-700">
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button onclick="switchTab('send')" data-tab="send"
                    class="send-tab flex-1 px-6 py-4 text-center font-medium border-b-2 border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <i data-lucide="send" class="h-4 w-4 inline mr-2"></i>
                    Envoyer un message
                </button>
                <button onclick="switchTab('history')" data-tab="history"
                    class="history-tab flex-1 px-6 py-4 text-center font-medium border-b-2 border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <i data-lucide="history" class="h-4 w-4 inline mr-2"></i>
                    Historique
                </button>
            </div>
        </div>

        <!-- Contenu des onglets -->
        <div id="send" class="tab-content">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Composer un message</h2>
                
                <form method="POST" action="{{ route('super-admin.notifications.send') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cible de destination -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Envoyer à
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="target" value="all" checked
                                        onchange="updateChamberSelection()"
                                        class="form-radio h-4 w-4">
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">Tous les gestionnaires</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="target" value="specific"
                                        onchange="updateChamberSelection()"
                                        class="form-radio h-4 w-4">
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">Chambres spécifiques</span>
                                </label>
                            </div>
                        </div>

                        <!-- Sélection des chambres -->
                        <div id="chamberSelection" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sélectionner les chambres
                            </label>
                            <select name="chambers[]" multiple size="4"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @foreach($chambers as $chamber)
                                <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Maintenez Ctrl pour sélectionner plusieurs chambres
                            </p>
                        </div>
                    </div>

                    <!-- Objet du message -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Objet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="subject" required maxlength="100"
                            placeholder="Titre de votre message..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Corps du message -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" required rows="10"
                            placeholder="Votre message..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <!-- Options d'envoi -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="send_email" value="1"
                                class="form-checkbox h-4 w-4">
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Envoyer également par email</span>
                        </label>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            <i data-lucide="send" class="h-4 w-4 inline mr-2"></i>
                            Envoyer le message
                        </button>
                        <button type="reset"
                            class="px-8 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Réinitialiser
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Onglet Historique -->
        <div id="history" class="tab-content hidden">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Historique des envois</h2>
                
                <div class="text-center text-gray-500 dark:text-gray-400 py-12">
                    <i data-lucide="inbox" class="h-16 w-16 mx-auto mb-4 opacity-50"></i>
                    <p>Aucun historique d'envoi pour le moment</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
lucide.createIcons();

function switchTab(tabName) {
    // Masquer tous les onglets
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Afficher l'onglet sélectionné
    document.getElementById(tabName).classList.remove('hidden');
    
    // Mettre à jour la classe active des boutons
    document.querySelectorAll('[data-tab]').forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600', 'dark:text-blue-400', 'dark:border-blue-600');
        if (btn.getAttribute('data-tab') === tabName) {
            btn.classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-400', 'dark:border-blue-600');
        }
    });
}

function updateChamberSelection() {
    const target = document.querySelector('input[name="target"]:checked').value;
    const chamberSelection = document.getElementById('chamberSelection');
    
    if (target === 'specific') {
        chamberSelection.classList.remove('hidden');
    } else {
        chamberSelection.classList.add('hidden');
    }
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Activer le premier onglet
    document.querySelector('[data-tab="send"]').classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-400', 'dark:border-blue-600');
});
</script>
@endsection
