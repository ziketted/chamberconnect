@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestion des Chambres</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Validez, certifiez et gérez toutes les chambres</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-gray-400">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-yellow-500">
                <p class="text-sm text-gray-600 dark:text-gray-400">En attente</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-blue-500">
                <p class="text-sm text-gray-600 dark:text-gray-400">Vérifiées</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['verified'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-green-500">
                <p class="text-sm text-gray-600 dark:text-gray-400">Certifiées</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['certified'] }}</p>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="search" placeholder="Rechercher une chambre..."
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                
                <select name="filter_status"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('filter_status') === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="verified" {{ request('filter_status') === 'verified' ? 'selected' : '' }}>Vérifiées</option>
                    <option value="certified" {{ request('filter_status') === 'certified' ? 'selected' : '' }}>Certifiées</option>
                </select>

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <i data-lucide="search" class="h-4 w-4 inline mr-2"></i>
                    Rechercher
                </button>
            </form>
        </div>

        <!-- Tableau des chambres -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Chambre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Gestionnaires
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($chambers as $chamber)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $chamber->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($chamber->description, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if($chamber->verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                                        Vérifiée
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200">
                                        En attente
                                    </span>
                                @endif
                                @if($chamber->state_number)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200">
                                        Certifiée
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900 dark:text-white">{{ $chamber->members->where('pivot.role', 'manager')->count() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-3">
                                <a href="{{ route('super-admin.chambers.show-request', $chamber->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                    <i data-lucide="eye" class="h-4 w-4 inline mr-1"></i>
                                    Voir demande
                                </a>
                                @if(!$chamber->verified)
                                <button onclick="openCertifyModal({{ $chamber->id }}, '{{ $chamber->name }}')"
                                    class="text-green-600 dark:text-green-400 hover:underline text-sm">
                                    Certifier
                                </button>
                                @endif
                                <button onclick="openDeleteModal({{ $chamber->id }}, '{{ $chamber->name }}')"
                                    class="text-red-600 dark:text-red-400 hover:underline text-sm">
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            Aucune chambre trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $chambers->links() }}
        </div>
    </div>
</div>

<!-- Modal de certification -->
<div id="certifyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Certifier la chambre</h3>
        <form id="certifyForm" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Numéro d'état
                    </label>
                    <input type="text" name="state_number" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Date de certification
                    </label>
                    <input type="date" name="certification_date" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Notes
                    </label>
                    <textarea name="notes"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Certifier
                </button>
                <button type="button" onclick="closeCertifyModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Supprimer la chambre</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Êtes-vous sûr de vouloir supprimer <strong id="deleteModalName"></strong> ? Cette action est irréversible.
        </p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Supprimer
                </button>
                <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<script>
lucide.createIcons();

function openCertifyModal(chamberId, chamberName) {
    document.getElementById('certifyModal').classList.remove('hidden');
    document.getElementById('certifyForm').action = `/super-admin/chambers/${chamberId}/certify`;
}

function closeCertifyModal() {
    document.getElementById('certifyModal').classList.add('hidden');
}

function openDeleteModal(chamberId, chamberName) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModalName').textContent = chamberName;
    document.getElementById('deleteForm').action = `/super-admin/chambers/${chamberId}`;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Fermer les modals en cliquant en dehors
document.addEventListener('click', function(event) {
    const certifyModal = document.getElementById('certifyModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === certifyModal) {
        closeCertifyModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});
</script>
@endsection
