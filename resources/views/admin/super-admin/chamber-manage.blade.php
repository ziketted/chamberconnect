<!-- Informations de la chambre -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations principales -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-lg font-medium text-gray-900">{{ $chamber->name }}</h4>
                <div class="flex items-center space-x-2">
                    @if($chamber->verified && $chamber->state_number)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i data-lucide="shield-check" class="h-3 w-3 mr-1"></i>
                            Certifiée
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                            En attente
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Localisation</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $chamber->location ?? 'Non définie' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date de création</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $chamber->created_at->format('d/m/Y') }}</dd>
                </div>
                @if($chamber->state_number)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Numéro d'État</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $chamber->state_number }}</dd>
                </div>
                @endif
                @if($chamber->certification_date)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date de certification</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($chamber->certification_date)->format('d/m/Y') }}</dd>
                </div>
                @endif
            </div>

            @if($chamber->description)
            <div class="mb-6">
                <dt class="text-sm font-medium text-gray-500">Description</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $chamber->description }}</dd>
            </div>
            @endif

            @if($chamber->certification_notes)
            <div class="mb-6">
                <dt class="text-sm font-medium text-gray-500">Notes de certification</dt>
                <dd class="mt-1 text-sm text-gray-900 bg-green-50 p-3 rounded-md">{{ $chamber->certification_notes }}</dd>
            </div>
            @endif
        </div>

        <!-- Membres de la chambre -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-medium text-gray-900">Membres ({{ $chamber->members->count() }})</h4>
                <button onclick="openAddMemberModal('{{ $chamber->id }}')" 
                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                    <i data-lucide="user-plus" class="h-4 w-4 inline mr-1"></i>
                    Ajouter membre
                </button>
            </div>

            <div class="space-y-3">
                @forelse($chamber->members as $member)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        @if($member->avatar)
                            <img class="h-8 w-8 rounded-full" src="{{ $member->avatar }}" alt="{{ $member->name }}">
                        @else
                            <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-700">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                            <p class="text-xs text-gray-500">{{ $member->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($member->pivot->role === 'manager')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i data-lucide="crown" class="h-3 w-3 mr-1"></i>
                                Gestionnaire
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Membre
                            </span>
                        @endif
                        <button onclick="removeMember('{{ $chamber->id }}', '{{ $member->id }}')" 
                                class="text-red-600 hover:text-red-800 p-1">
                            <i data-lucide="user-minus" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucun membre dans cette chambre</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-4">
        <!-- Certification -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Certification</h4>
            
            @if(!$chamber->verified || !$chamber->state_number)
                <button onclick="openCertificationModal('{{ $chamber->slug }}')" 
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 mb-3">
                    <i data-lucide="shield-check" class="h-4 w-4 inline mr-2"></i>
                    Certifier la chambre
                </button>
            @else
                <form method="POST" action="{{ route('admin.chambers.uncertify', $chamber->slug) }}" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            onclick="return confirm('Êtes-vous sûr de vouloir retirer la certification ?')"
                            class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                        <i data-lucide="shield-off" class="h-4 w-4 inline mr-2"></i>
                        Retirer certification
                    </button>
                </form>
            @endif
        </div>

        <!-- Suspension -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Suspension</h4>
            
            <form method="POST" action="{{ route('admin.chambers.suspend', $chamber) }}">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        onclick="return confirm('Êtes-vous sûr de vouloir suspendre cette chambre ?')"
                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                    <i data-lucide="ban" class="h-4 w-4 inline mr-2"></i>
                    Suspendre la chambre
                </button>
            </form>
        </div>

        <!-- Gestion des gestionnaires -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Gestionnaires</h4>
            
            <button onclick="openAssignManagerModal('{{ $chamber->id }}')" 
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 mb-3">
                <i data-lucide="user-plus" class="h-4 w-4 inline mr-2"></i>
                Assigner gestionnaire
            </button>

            @if($chamber->members->where('pivot.role', 'manager')->count() > 0)
                <div class="space-y-2">
                    @foreach($chamber->members->where('pivot.role', 'manager') as $manager)
                    <div class="flex items-center justify-between p-2 bg-blue-50 rounded">
                        <span class="text-sm text-gray-900">{{ $manager->name }}</span>
                        <form method="POST" action="{{ route('admin.chambers.remove-manager', $chamber) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $manager->id }}">
                            <button type="submit" 
                                    onclick="return confirm('Retirer ce gestionnaire ?')"
                                    class="text-red-600 hover:text-red-800 p-1">
                                <i data-lucide="user-minus" class="h-3 w-3"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Statistiques -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Statistiques</h4>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total membres:</span>
                    <span class="text-sm font-medium">{{ $chamber->members->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Gestionnaires:</span>
                    <span class="text-sm font-medium">{{ $chamber->members->where('pivot.role', 'manager')->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Membres actifs:</span>
                    <span class="text-sm font-medium">{{ $chamber->members->where('pivot.status', 'approved')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour retirer un membre
function removeMember(chamberId, userId) {
    if (!confirm('Êtes-vous sûr de vouloir retirer ce membre ?')) {
        return;
    }

    fetch(`/admin/chambers/${chamberId}/remove-member`, {
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
            // Recharger le contenu du modal
            openChamberModal(chamberId);
        } else {
            alert('Erreur lors de la suppression du membre');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la suppression du membre');
    });
}

// Fonction pour ouvrir le modal d'assignation de gestionnaire
function openAssignManagerModal(chamberId) {
    // Fermer le modal de gestion de chambre
    closeChamberModal();
    
    // Ouvrir le modal d'assignation depuis la page principale
    setTimeout(() => {
        window.openAssignManagerModal(chamberId);
    }, 100);
}

// Fonction pour ouvrir le modal d'ajout de membre
function openAddMemberModal(chamberId) {
    alert('Fonctionnalité d\'ajout de membre à implémenter dans une future version');
}
</script>