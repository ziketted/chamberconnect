@extends('layouts.app')

@section('content')
<div class="min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec navigation -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <a href="{{ route('admin.chambers') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <i data-lucide="arrow-left" class="h-5 w-5 mr-2"></i>
            Retour aux chambres
          </a>
          <h1 class="text-2xl font-bold text-gray-900">Gestion de {{ $chamber->name }}</h1>
        </div>

        <!-- Badge de certification -->
        <div class="flex items-center space-x-3">
          @if($chamber->verified && $chamber->state_number)
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
            <i data-lucide="shield-check" class="h-4 w-4 mr-2"></i>
            Certifiée
          </span>
          @else
          <span
            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
            <i data-lucide="clock" class="h-4 w-4 mr-2"></i>
            En attente
          </span>
          @endif
        </div>
      </div>
    </div>

    <!-- Messages de succès/erreur -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
      <div class="flex items-center">
        <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
        {{ session('success') }}
      </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
      <div class="flex items-center">
        <i data-lucide="alert-circle" class="h-5 w-5 mr-2"></i>
        {{ session('error') }}
      </div>
    </div>
    @endif

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Colonne principale - Informations de la chambre -->
      <div class="lg:col-span-2">
        <!-- Informations de la chambre -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
          <div class="p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-semibold text-gray-900">Informations de la chambre</h2>
              <a href="{{ route('chamber.show', $chamber) }}" target="_blank"
                class="text-blue-600 hover:text-blue-800 flex items-center text-sm">
                <i data-lucide="external-link" class="h-4 w-4 mr-1"></i>
                Voir la page publique
              </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Nom</dt>
                <dd class="text-sm text-gray-900">{{ $chamber->name }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Localisation</dt>
                <dd class="text-sm text-gray-900">{{ $chamber->location ?? 'Non définie' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Email</dt>
                <dd class="text-sm text-gray-900">{{ $chamber->email ?? 'Non défini' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Téléphone</dt>
                <dd class="text-sm text-gray-900">{{ $chamber->phone ?? 'Non défini' }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Date de création</dt>
                <dd class="text-sm text-gray-900">{{ $chamber->created_at->format('d/m/Y à H:i') }}</dd>
              </div>
              @if($chamber->state_number)
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Numéro d'État</dt>
                <dd class="text-sm text-gray-900 font-medium">{{ $chamber->state_number }}</dd>
              </div>
              @endif
              @if($chamber->certification_date)
              <div>
                <dt class="text-sm font-medium text-gray-500 mb-1">Date de certification</dt>
                <dd class="text-sm text-gray-900">{{
                  \Carbon\Carbon::parse($chamber->certification_date)->format('d/m/Y') }}</dd>
              </div>
              @endif
            </div>

            @if($chamber->description)
            <div class="mt-6">
              <dt class="text-sm font-medium text-gray-500 mb-2">Description</dt>
              <dd class="text-sm text-gray-900 bg-gray-50 p-4 rounded-md">{{ $chamber->description }}</dd>
            </div>
            @endif
          </div>
        </div>

        <!-- Section Membres -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-semibold text-gray-900">Membres ({{ $chamber->members->count() }})</h2>
              <button
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i data-lucide="user-plus" class="h-4 w-4 mr-2"></i>
                Ajouter membre
              </button>
            </div>

            <!-- Liste des membres -->
            @forelse($chamber->members as $member)
            <div class="flex items-center justify-between p-3 border-b border-gray-100 last:border-b-0">
              <div class="flex items-center flex-1">
                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                  <span class="text-sm font-medium text-gray-700">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900 truncate">{{ $member->name }}</p>
                  <p class="text-xs text-gray-500 truncate">{{ $member->email }}</p>
                </div>
              </div>
              <div class="flex items-center space-x-2 ml-3">
                <!-- Badge de rôle -->
                @if($member->pivot->role === 'manager')
                <div class="h-6 w-6 rounded-full bg-purple-100 flex items-center justify-center" title="Gestionnaire">
                  <i data-lucide="crown" class="h-3 w-3 text-purple-600"></i>
                </div>
                @else
                <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center" title="Membre">
                  <i data-lucide="user" class="h-3 w-3 text-blue-600"></i>
                </div>
                @endif

                <!-- Badge de statut -->
                @if($member->pivot->status === 'approved')
                <div class="h-6 w-6 rounded-full bg-green-100 flex items-center justify-center" title="Approuvé">
                  <i data-lucide="check" class="h-3 w-3 text-green-600"></i>
                </div>
                @elseif($member->pivot->status === 'pending')
                <div class="h-6 w-6 rounded-full bg-yellow-100 flex items-center justify-center" title="En attente">
                  <i data-lucide="clock" class="h-3 w-3 text-yellow-600"></i>
                </div>
                @else
                <div class="h-6 w-6 rounded-full bg-red-100 flex items-center justify-center" title="Rejeté">
                  <i data-lucide="x" class="h-3 w-3 text-red-600"></i>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center space-x-1">
                  @if($member->pivot->role === 'manager')
                  <!-- Actions pour les gestionnaires -->
                  <button onclick="showDemoteFromManagerConfirm('{{ $member->id }}', '{{ $member->name }}')"
                    class="text-orange-600 hover:text-orange-800 p-1 rounded hover:bg-orange-50 transition-colors"
                    title="Retirer les droits de gestionnaire">
                    <i data-lucide="user-check" class="h-4 w-4"></i>
                  </button>
                  @else
                  <!-- Actions pour les membres réguliers -->
                  <button onclick="showPromoteToManagerConfirm('{{ $member->id }}', '{{ $member->name }}')"
                    class="text-purple-600 hover:text-purple-800 p-1 rounded hover:bg-purple-50 transition-colors"
                    title="Promouvoir gestionnaire">
                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                  </button>
                  @endif

                  <button onclick="showRemoveMemberConfirm('{{ $member->id }}', '{{ $member->name }}')"
                    class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors"
                    title="Retirer le membre">
                    <i data-lucide="user-minus" class="h-4 w-4"></i>
                  </button>
                </div>
              </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
              <i data-lucide="users" class="h-12 w-12 mx-auto mb-4 text-gray-400"></i>
              <p class="text-sm text-gray-500">Aucun membre dans cette chambre</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Colonne latérale - Actions -->
      <div class="space-y-6">
        <!-- Certification -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Certification</h3>

            @if($chamber->verified)
            <!-- Chambre certifiée -->
            <div class="space-y-3">
              <button onclick="showRevokeCertificationConfirm()"
                class="w-full bg-orange-600 text-white px-4 py-3 rounded-lg flex items-center justify-center hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                <i data-lucide="x-circle" class="h-5 w-5 mr-2"></i>
                Retirer certification
              </button>
              <button onclick="showVerificationModal()"
                class="w-full bg-yellow-600 text-white px-4 py-3 rounded-lg flex items-center justify-center hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                <i data-lucide="shield-check" class="h-5 w-5 mr-2"></i>
                Retirer vérification
              </button>
            </div>
            @else
            <!-- Chambre non certifiée -->
            <button onclick="showCertificationModal()"
              class="w-full bg-green-600 text-white px-4 py-3 rounded-lg flex items-center justify-center hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
              <i data-lucide="award" class="h-5 w-5 mr-2"></i>
              Certifier la chambre
            </button>
            @endif
          </div>
        </div>

        <!-- Gestionnaires -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Gestionnaires</h3>
            </div>

            <a href="{{ route('admin.chambers.assign-manager.show', $chamber) }}"
              class="w-full bg-purple-600 text-white px-4 py-3 rounded-lg flex items-center justify-center hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors mb-4">
              <i data-lucide="user-plus" class="h-5 w-5 mr-2"></i>
              Assigner gestionnaire
            </a>

            <div class="space-y-3">
              <p class="text-sm text-gray-600">Gestionnaires actuels:</p>

              @forelse($chamber->members->where('pivot.role', 'manager') as $manager)
              <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center flex-1">
                  <div class="h-10 w-10 rounded-full bg-purple-200 flex items-center justify-center mr-3">
                    <span class="text-sm font-medium text-purple-800">{{ strtoupper(substr($manager->name, 0, 1))
                      }}</span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $manager->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $manager->email }}</p>
                  </div>
                </div>
                <div class="flex items-center space-x-2 ml-3">
                  <div class="h-6 w-6 rounded-full bg-purple-100 flex items-center justify-center" title="Gestionnaire">
                    <i data-lucide="crown" class="h-3 w-3 text-purple-600"></i>
                  </div>
                  <button onclick="showRemoveManagerConfirm('{{ $manager->id }}', '{{ $manager->name }}')"
                    class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors"
                    title="Retirer le gestionnaire">
                    <i data-lucide="user-minus" class="h-4 w-4"></i>
                  </button>
                </div>
              </div>
              @empty
              <div class="text-center py-6">
                <i data-lucide="users" class="h-10 w-10 text-gray-400 mx-auto mb-3"></i>
                <p class="text-sm text-gray-500">Aucun gestionnaire assigné</p>
              </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Actions dangereuses -->
        <div class="bg-white rounded-lg shadow-sm border border-red-200">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-4">Actions dangereuses</h3>

            <div class="space-y-3">
              @if(!$chamber->suspended)
              <button onclick="showSuspendConfirm()"
                class="w-full bg-red-600 text-white px-4 py-3 rounded-lg flex items-center justify-center hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                <i data-lucide="ban" class="h-5 w-5 mr-2"></i>
                Suspendre la chambre
              </button>
              @else
              <button onclick="showUnsuspendConfirm()"
                class="w-full bg-green-600 text-white px-4 py-3 rounded-lg flex items-center justify-center hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
                Réactiver la chambre
              </button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de certification -->
<div id="certificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" onclick="closeCertificationModal()"></div>

    <div
      class="inline-block transform overflow-hidden rounded-2xl bg-white text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
      <div class="bg-white px-6 pt-6 pb-4">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
              <i data-lucide="shield-check" class="h-6 w-6 text-green-600"></i>
            </div>
          </div>
          <div class="ml-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Certifier la chambre</h3>
            <p class="text-sm text-gray-500">Remplissez les informations de certification</p>
          </div>
        </div>

        <form id="certificationForm" method="POST" action="{{ route('admin.chambers.certify', $chamber) }}">
          @csrf
          <div class="space-y-4">
            <div>
              <label for="state_number" class="block text-sm font-medium text-gray-700 mb-1">
                Numéro d'État *
              </label>
              <input type="text" name="state_number" id="state_number" required
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                placeholder="Ex: RDC-CC-1627">
            </div>
            <div>
              <label for="certification_date" class="block text-sm font-medium text-gray-700 mb-1">
                Date de certification *
              </label>
              <input type="date" name="certification_date" id="certification_date" required
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                value="{{ date('Y-m-d') }}">
            </div>
            <div>
              <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                Notes (optionnel)
              </label>
              <textarea name="notes" id="notes" rows="3"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                placeholder="Notes sur la certification..."></textarea>
            </div>
          </div>
        </form>
      </div>

      <div
        class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
        <button type="button" onclick="closeCertificationModal()"
          class="inline-flex w-full justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:w-auto sm:text-sm">
          <i data-lucide="x" class="h-4 w-4 mr-2"></i>
          Annuler
        </button>
        <button type="button" onclick="submitCertification()"
          class="inline-flex w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">
          <i data-lucide="award" class="h-4 w-4 mr-2"></i>
          Certifier
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Popup de confirmation moderne -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" onclick="closeConfirmationModal()"></div>

    <div
      class="inline-block transform overflow-hidden rounded-2xl bg-gray-800 text-left align-bottom shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:align-middle border border-gray-700">
      <div class="bg-gray-800 px-6 pt-6 pb-4">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full mb-4 bg-purple-900 bg-opacity-50"
          id="confirmIcon">
          <i data-lucide="alert-triangle" class="h-8 w-8 text-purple-400"></i>
        </div>

        <div class="text-center">
          <h3 class="text-xl font-semibold text-white mb-2" id="confirmTitle">
            Confirmer l'action
          </h3>
          <p class="text-sm text-gray-300 mb-6 leading-relaxed" id="confirmMessage">
            Êtes-vous sûr de vouloir effectuer cette action ?
          </p>
        </div>
      </div>

      <div
        class="bg-gray-700 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
        <button type="button" onclick="closeConfirmationModal()"
          class="inline-flex w-full justify-center rounded-lg border border-gray-600 bg-gray-700 px-4 py-2.5 text-sm font-medium text-gray-300 shadow-sm hover:bg-gray-600 sm:w-auto transition-colors">
          <i data-lucide="x" class="h-4 w-4 mr-2"></i>
          Annuler
        </button>
        <button type="button" id="confirmButton"
          class="inline-flex w-full justify-center rounded-lg border border-transparent px-4 py-2.5 text-sm font-medium text-white shadow-sm sm:w-auto bg-purple-600 hover:bg-purple-700 transition-colors">
          <i data-lucide="check" class="h-4 w-4 mr-2"></i>
          <span id="confirmButtonText">Confirmer</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Formulaires cachés -->
<form id="suspend-form" method="POST" action="{{ route('admin.chambers.suspend', $chamber) }}" style="display: none;">
  @csrf
  @method('PATCH')
</form>

<form id="revoke-certification-form" method="POST" action="{{ route('admin.chambers.uncertify', $chamber) }}"
  style="display: none;">
  @csrf
  @method('PATCH')
</form>

<form id="revoke-verification-form" method="POST" action="{{ route('admin.chambers.unverify', $chamber) }}"
  style="display: none;">
  @csrf
  @method('PATCH')
</form>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});

// Variables globales
let confirmationCallback = null;
const chamberSlug = '{{ $chamber->slug }}';

// Gestion du modal de certification
function showCertificationModal() {
    document.getElementById('certificationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCertificationModal() {
    document.getElementById('certificationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function submitCertification() {
    const form = document.getElementById('certificationForm');
    const stateNumber = document.getElementById('state_number').value;
    const certificationDate = document.getElementById('certification_date').value;
    
    if (!stateNumber || !certificationDate) {
        alert('Veuillez remplir tous les champs obligatoires');
        return;
    }
    
    form.submit();
}

// Gestion du popup de confirmation
function showConfirmation(options) {
    const {
        title = 'Confirmer l\'action',
        message = 'Êtes-vous sûr de vouloir effectuer cette action ?',
        confirmText = 'Confirmer',
        callback = null,
        type = 'danger'
    } = options;

    confirmationCallback = callback;

    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMessage').textContent = message;
    document.getElementById('confirmButtonText').textContent = confirmText;

    const confirmButton = document.getElementById('confirmButton');
    if (type === 'danger') {
        confirmButton.className = 'inline-flex w-full justify-center rounded-lg border border-transparent px-4 py-2.5 text-sm font-medium text-white shadow-sm sm:w-auto bg-red-600 hover:bg-red-700 transition-colors';
    } else if (type === 'success') {
        confirmButton.className = 'inline-flex w-full justify-center rounded-lg border border-transparent px-4 py-2.5 text-sm font-medium text-white shadow-sm sm:w-auto bg-green-600 hover:bg-green-700 transition-colors';
    }

    const modal = document.getElementById('confirmationModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        lucide.createIcons();
    }, 10);
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    confirmationCallback = null;
}

// Gérer la confirmation
document.getElementById('confirmButton').addEventListener('click', function() {
    if (confirmationCallback && typeof confirmationCallback === 'function') {
        confirmationCallback();
    }
    closeConfirmationModal();
});

// Fermer avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const confirmModal = document.getElementById('confirmationModal');
        const certModal = document.getElementById('certificationModal');
        
        if (!confirmModal.classList.contains('hidden')) {
            closeConfirmationModal();
        } else if (!certModal.classList.contains('hidden')) {
            closeCertificationModal();
        }
    }
});

// Fonctions spécifiques pour les actions
function showPromoteToManagerConfirm(userId, userName) {
    showConfirmation({
        title: 'Promouvoir en gestionnaire ?',
        message: `Êtes-vous sûr de vouloir promouvoir "${userName}" au rôle de gestionnaire ?`,
        confirmText: 'OK',
        type: 'success',
        callback: function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}/promote`;
            form.style.display = 'none';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            form.appendChild(methodField);
            
            const chamberIdField = document.createElement('input');
            chamberIdField.type = 'hidden';
            chamberIdField.name = 'chamber_id';
            chamberIdField.value = '{{ $chamber->id }}';
            form.appendChild(chamberIdField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function showDemoteFromManagerConfirm(userId, userName) {
    showConfirmation({
        title: 'Retirer les droits de gestionnaire ?',
        message: `Êtes-vous sûr de vouloir retirer les droits de gestionnaire à "${userName}" ?`,
        confirmText: 'OK',
        type: 'danger',
        callback: function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}/demote`;
            form.style.display = 'none';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            form.appendChild(methodField);
            
            const chamberIdField = document.createElement('input');
            chamberIdField.type = 'hidden';
            chamberIdField.name = 'chamber_id';
            chamberIdField.value = '{{ $chamber->id }}';
            form.appendChild(chamberIdField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function showRemoveMemberConfirm(userId, userName) {
    showConfirmation({
        title: 'Retirer ce membre ?',
        message: `Êtes-vous sûr de vouloir retirer "${userName}" de cette chambre ?`,
        confirmText: 'OK',
        type: 'danger',
        callback: function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/chambers/{{ $chamber->id }}/remove-member`;
            form.style.display = 'none';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const userIdField = document.createElement('input');
            userIdField.type = 'hidden';
            userIdField.name = 'user_id';
            userIdField.value = userId;
            form.appendChild(userIdField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function showRemoveManagerConfirm(userId, userName) {
    showConfirmation({
        title: 'Retirer ce gestionnaire ?',
        message: `Êtes-vous sûr de vouloir retirer "${userName}" de son rôle de gestionnaire ?`,
        confirmText: 'OK',
        type: 'danger',
        callback: function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/chambers/{{ $chamber->id }}/remove-manager`;
            form.style.display = 'none';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            const userIdField = document.createElement('input');
            userIdField.type = 'hidden';
            userIdField.name = 'user_id';
            userIdField.value = userId;
            form.appendChild(userIdField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function showSuspendConfirm() {
    showConfirmation({
        title: 'Suspendre la chambre ?',
        message: 'Êtes-vous sûr de vouloir suspendre cette chambre ?',
        confirmText: 'OK',
        type: 'danger',
        callback: function() {
            document.getElementById('suspend-form').submit();
        }
    });
}

function showUnsuspendConfirm() {
    showConfirmation({
        title: 'Réactiver la chambre ?',
        message: 'Êtes-vous sûr de vouloir réactiver cette chambre ?',
        confirmText: 'OK',
        type: 'success',
        callback: function() {
            document.getElementById('unsuspend-form').submit();
        }
    });
}

function showRevokeCertificationConfirm() {
    showConfirmation({
        title: 'Retirer la certification ?',
        message: 'Êtes-vous sûr de vouloir retirer la certification de cette chambre ?',
        confirmText: 'OK',
        type: 'danger',
        callback: function() {
            document.getElementById('revoke-certification-form').submit();
        }
    });
}

function showVerificationModal() {
    showConfirmation({
        title: 'Retirer la vérification ?',
        message: 'Êtes-vous sûr de vouloir retirer la vérification de cette chambre ?',
        confirmText: 'OK',
        type: 'danger',
        callback: function() {
            document.getElementById('revoke-verification-form').submit();
        }
    });
}
</script>
@endpush

@endsection