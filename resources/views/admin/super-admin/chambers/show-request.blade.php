@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Messages d'erreur/succès -->
        @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-start">
                <i data-lucide="alert-circle" class="h-5 w-5 text-red-600 dark:text-red-400 mr-3 mt-0.5"></i>
                <div>
                    <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">Erreur(s) de validation</h3>
                    <ul class="text-sm text-red-700 dark:text-red-300 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="h-5 w-5 text-red-600 dark:text-red-400 mr-3"></i>
                <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400 mr-3"></i>
                <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $chamber->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Demande de création de chambre</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200">
                    <i data-lucide="clock" class="h-4 w-4 mr-1"></i>
                    En attente de certification
                </span>
            </div>
        </div>

        <!-- Informations de demande -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">📋 Informations de la demande</h2>
            
            @php
                $requestData = json_decode($chamber->certification_notes, true) ?? [];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Colonne gauche -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Sigle/Acronyme</label>
                        <p class="text-gray-900 dark:text-white">{{ $requestData['sigle'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Numéro NINA</label>
                        <p class="text-gray-900 dark:text-white">{{ $requestData['nina_number'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Type de chambre</label>
                        <p class="text-gray-900 dark:text-white">
                            @if($chamber->type === 'national')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                    Nationale
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200">
                                    Bilatérale ({{ $chamber->embassy_country }})
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Date de soumission</label>
                        <p class="text-gray-900 dark:text-white">
                            @if(isset($requestData['submitted_at']))
                                {{ \Carbon\Carbon::parse($requestData['submitted_at'])->format('d/m/Y H:i') }}
                            @else
                                {{ $chamber->created_at->format('d/m/Y H:i') }}
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Date de création de la chambre</label>
                        <p class="text-gray-900 dark:text-white">{{ $requestData['creation_date'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                        <p class="text-gray-900 dark:text-white">{{ $chamber->location }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <p class="text-gray-900 dark:text-white">{{ $chamber->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Téléphone</label>
                        <p class="text-gray-900 dark:text-white">{{ $chamber->phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <div class="mt-2 max-w-full">
                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap break-words overflow-hidden text-ellipsis">{{ $chamber->description }}</p>
                </div>
            </div>
        </div>

        <!-- Informations de suspension (si applicable) -->
        @if($chamber->is_suspended)
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center mb-4">
                <i data-lucide="pause-circle" class="h-6 w-6 text-red-600 dark:text-red-400 mr-3"></i>
                <h2 class="text-xl font-bold text-red-900 dark:text-red-200">🚫 Chambre Suspendue</h2>
            </div>
            
            <div class="bg-red-100 dark:bg-red-900/40 border border-red-300 dark:border-red-700 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <i data-lucide="alert-triangle" class="h-5 w-5 text-red-600 dark:text-red-400 mr-3 mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">Cette chambre est actuellement suspendue</h3>
                        <p class="text-sm text-red-700 dark:text-red-300">
                            La chambre n'est pas visible pour les utilisateurs et ses activités sont temporairement interrompues.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-red-700 dark:text-red-300">Date de suspension</label>
                    <p class="text-red-900 dark:text-red-200 font-medium">
                        @if($chamber->suspended_at)
                            {{ $chamber->suspended_at->format('d/m/Y à H:i') }}
                            <span class="text-xs text-red-600 dark:text-red-400 block">
                                ({{ $chamber->suspended_at->diffForHumans() }})
                            </span>
                        @else
                            Non spécifiée
                        @endif
                    </p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-red-700 dark:text-red-300">Statut</label>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-200 dark:bg-red-800 text-red-800 dark:text-red-200">
                        <i data-lucide="pause-circle" class="h-3 w-3 mr-1"></i>
                        Suspendue
                    </span>
                </div>
            </div>

            @if($chamber->suspension_reason)
            <div class="mt-6 pt-4 border-t border-red-200 dark:border-red-700">
                <label class="text-sm font-medium text-red-700 dark:text-red-300">Raison de la suspension</label>
                <div class="mt-2 p-4 bg-red-100 dark:bg-red-900/40 border border-red-200 dark:border-red-700 rounded-lg">
                    <p class="text-red-900 dark:text-red-200 whitespace-pre-wrap break-words">{{ $chamber->suspension_reason }}</p>
                </div>
            </div>
            @endif

            <!-- Actions de suspension -->
            <div class="mt-6 pt-4 border-t border-red-200 dark:border-red-700">
                <div class="flex flex-col sm:flex-row gap-3">
                    <form method="POST" action="{{ route('super-admin.chambers.reactivate', $chamber->id) }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                            class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                            <i data-lucide="play-circle" class="h-4 w-4 mr-2"></i>
                            Réactiver la chambre
                        </button>
                    </form>
                    
                    <button onclick="openModifySuspensionModal()" 
                        class="flex-1 px-4 py-2 border border-red-300 dark:border-red-600 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex items-center justify-center">
                        <i data-lucide="edit" class="h-4 w-4 mr-2"></i>
                        Modifier la raison
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Demandeur -->
        @if(isset($requestData['submitted_by']) && !empty($requestData['submitted_by']))
            @php
                $applicant = \App\Models\User::find($requestData['submitted_by']);
            @endphp
            @if($applicant)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">👤 Demandeur</h2>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                        {{ substr($applicant->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $applicant->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $applicant->email }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <p class="text-blue-800 dark:text-blue-200">
                    <i data-lucide="info" class="h-4 w-4 inline mr-2"></i>
                    Informations sur le demandeur non disponibles.
                </p>
            </div>
            @endif
        @endif

        <!-- Documents attachés -->
        @if(isset($requestData['documents']) && count($requestData['documents']) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">📄 Documents attachés</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $documentLabels = [
                        'statuts' => 'Statuts signés',
                        'reglement_interieur' => 'Règlement intérieur',
                        'pv_assemblee' => 'PV Assemblée constitutive',
                        'liste_membres' => 'Liste des membres fondateurs',
                        'plan_action' => 'Plan d\'action',
                        'pieces_identite' => 'Pièces d\'identité',
                        'lettre_demande' => 'Lettre de demande'
                    ];
                @endphp

                @foreach($requestData['documents'] as $docKey => $docPath)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i data-lucide="file-pdf" class="h-8 w-8 text-red-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $documentLabels[$docKey] ?? ucfirst(str_replace('_', ' ', $docKey)) }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $docPath }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $docPath) }}" target="_blank"
                            class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                            <i data-lucide="download" class="h-4 w-4 inline"></i>
                            Télécharger
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 mb-8">
            <p class="text-yellow-800 dark:text-yellow-200">
                <i data-lucide="alert-circle" class="h-4 w-4 inline mr-2"></i>
                Aucun document attaché à cette demande.
            </p>
        </div>
        @endif

        <!-- Actions SuperAdmin -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">🔧 Actions</h2>
            
            @if($chamber->state_number)
                <!-- Chambre certifiée -->
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-600 dark:text-green-400 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-900 dark:text-green-200">Chambre Certifiée</h3>
                    </div>
                    <div class="space-y-2 text-sm text-green-800 dark:text-green-300">
                        <p><strong>Numéro d'état:</strong> {{ $chamber->state_number }}</p>
                        <p><strong>Date de certification:</strong> {{ $chamber->certification_date?->format('d/m/Y') ?? 'N/A' }}</p>
                        @if(isset($requestData['certification_notes']) && $requestData['certification_notes'])
                        <p><strong>Notes:</strong> {{ $requestData['certification_notes'] }}</p>
                        @endif
                    </div>
                </div>
            @else
                <!-- Boutons d'action -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Approuver -->
                    <button onclick="openApproveModal()"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                        <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
                        Approuver
                    </button>

                    <!-- Certifier et attribuer numéro -->
                    <button onclick="openCertifyModal()"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                        <i data-lucide="badge" class="h-5 w-5 mr-2"></i>
                        Certifier & Numéro
                    </button>

                    <!-- Rejeter -->
                    <button onclick="openRejectModal()"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                        <i data-lucide="x-circle" class="h-5 w-5 mr-2"></i>
                        Rejeter
                    </button>
                </div>
            @endif
        </div>

        <!-- Retour -->
        <div>
            <a href="{{ route('super-admin.chambers.index') }}"
                class="text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                Retour à la liste des demandes
            </a>
        </div>
    </div>

    <!-- Modal: Approuver -->
    <div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Approuver la demande</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Êtes-vous sûr de vouloir approuver cette demande? La chambre sera vérifiée mais ne recevra pas encore de numéro d'état.
            </p>
            <form method="POST" action="{{ route('super-admin.chambers.approve', $chamber->id) }}">
                @csrf
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        Approuver
                    </button>
                    <button type="button" onclick="closeApproveModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Certifier -->
    <div id="certifyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Certifier la chambre</h3>
            <form id="certifyForm" method="POST" action="{{ route('super-admin.chambers.certify', $chamber->id) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Numéro d'état <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="state_number" required
                            placeholder="Ex: CC-2024-001"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Date de certification <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="certification_date" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Notes (optionnel)
                        </label>
                        <textarea name="notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
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

    <!-- Modal: Rejeter -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Rejeter la demande</h3>
            <form method="POST" action="{{ route('super-admin.chambers.reject', $chamber->id) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Raison du rejet <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_reason" required rows="4"
                            placeholder="Expliquez pourquoi cette demande est rejetée..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Rejeter
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    lucide.createIcons();

    function openApproveModal() {
        document.getElementById('approveModal').classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }

    function openCertifyModal() {
        document.getElementById('certifyModal').classList.remove('hidden');
    }

    function closeCertifyModal() {
        document.getElementById('certifyModal').classList.add('hidden');
    }

    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    // Fermer les modals en cliquant en dehors
    document.addEventListener('click', function(event) {
        const approveModal = document.getElementById('approveModal');
        const certifyModal = document.getElementById('certifyModal');
        const rejectModal = document.getElementById('rejectModal');
        
        if (event.target === approveModal) closeApproveModal();
        if (event.target === certifyModal) closeCertifyModal();
        if (event.target === rejectModal) closeRejectModal();
    });
    </script>
</div>
@endsection

