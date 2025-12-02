<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Demandes de création en attente
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Examinez et validez les demandes de création de chambres
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                            {{ $pendingChambers->total() }} demande(s) en attente
                        </span>
                        <a href="{{ route('admin.chambers') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                            </svg>
                            Toutes les chambres
                        </a>
                    </div>
                </div>
            </div>

            @if($pendingChambers->count() > 0)
                <div class="space-y-6">
                    @foreach($pendingChambers as $chamber)
                        @php
                            $applicationData = json_decode($chamber->agrément_notes, true) ?? [];
                            $applicant = $chamber->members->first();
                            $submittedAt = isset($applicationData['submitted_at']) ? \Carbon\Carbon::parse($applicationData['submitted_at']) : $chamber->created_at;
                            $isRejected = isset($applicationData['rejected_at']);
                        @endphp
                        
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                {{ $chamber->name }}
                                            </h3>
                                            @if($isRejected)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Rejetée
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    En attente
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            <div>
                                                <span class="font-medium">Sigle:</span>
                                                {{ $applicationData['sigle'] ?? 'Non renseigné' }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Province:</span>
                                                {{ $chamber->location }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Demandeur:</span>
                                                {{ $applicant ? $applicant->name : 'Non trouvé' }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Soumise le:</span>
                                                {{ $submittedAt->format('d/m/Y à H:i') }}
                                            </div>
                                        </div>

                                        @if($chamber->description)
                                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                                {{ Str::limit($chamber->description, 200) }}
                                            </p>
                                        @endif

                                        @if($isRejected && isset($applicationData['rejection_reason']))
                                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                                            Motif de refus
                                                        </h3>
                                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                                            <p>{{ $applicationData['rejection_reason'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @if(!$isRejected)
                                        <div class="flex flex-col space-y-2 ml-4">
                                            <button type="button" onclick="showApprovalModal('{{ $chamber->id }}')"
                                                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Approuver
                                            </button>
                                            
                                            <button type="button" onclick="showRejectionModal('{{ $chamber->id }}')"
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rejeter
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <!-- Collapsible Details -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <button type="button" onclick="toggleDetails('{{ $chamber->id }}')"
                                            class="flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="w-4 h-4 mr-2 transform transition-transform" id="arrow-{{ $chamber->id }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        Voir les détails complets
                                    </button>

                                    <div id="details-{{ $chamber->id }}" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Informations complètes</h4>
                                            <dl class="space-y-2 text-sm">
                                                <div>
                                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Adresse:</dt>
                                                    <dd class="text-gray-600 dark:text-gray-400">{{ $chamber->address }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Téléphone:</dt>
                                                    <dd class="text-gray-600 dark:text-gray-400">{{ $chamber->phone }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Email:</dt>
                                                    <dd class="text-gray-600 dark:text-gray-400">{{ $chamber->email }}</dd>
                                                </div>
                                                @if($chamber->website)
                                                    <div>
                                                        <dt class="font-medium text-gray-700 dark:text-gray-300">Site web:</dt>
                                                        <dd class="text-gray-600 dark:text-gray-400">
                                                            <a href="{{ $chamber->website }}" target="_blank" class="text-red-600 hover:text-red-700 dark:text-red-400">
                                                                {{ $chamber->website }}
                                                            </a>
                                                        </dd>
                                                    </div>
                                                @endif
                                                @if(isset($applicationData['nina_number']))
                                                    <div>
                                                        <dt class="font-medium text-gray-700 dark:text-gray-300">NINA:</dt>
                                                        <dd class="text-gray-600 dark:text-gray-400">{{ $applicationData['nina_number'] }}</dd>
                                                    </div>
                                                @endif
                                                @if(isset($applicationData['creation_date']))
                                                    <div>
                                                        <dt class="font-medium text-gray-700 dark:text-gray-300">Date de création:</dt>
                                                        <dd class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($applicationData['creation_date'])->format('d/m/Y') }}</dd>
                                                    </div>
                                                @endif
                                            </dl>
                                        </div>

                                        @if(isset($applicationData['documents']))
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Documents soumis</h4>
                                                <ul class="space-y-2 text-sm">
                                                    @foreach($applicationData['documents'] as $docType => $docPath)
                                                        <li class="flex items-center justify-between">
                                                            <span class="flex items-center text-green-600 dark:text-green-400">
                                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                @switch($docType)
                                                                    @case('statuts') Statuts signés @break
                                                                    @case('reglement_interieur') Règlement intérieur @break
                                                                    @case('pv_assemblee') PV Assemblée constitutive @break
                                                                    @case('liste_membres') Liste des membres fondateurs @break
                                                                    @case('plan_action') Plan d'action @break
                                                                    @case('pieces_identite') Pièces d'identité @break
                                                                    @case('lettre_demande') Lettre de demande @break
                                                                    @default {{ ucfirst($docType) }}
                                                                @endswitch
                                                            </span>
                                                            <a href="{{ Storage::url($docPath) }}" target="_blank" 
                                                               class="text-blue-600 hover:text-blue-700 dark:text-blue-400 text-xs">
                                                                Télécharger
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $pendingChambers->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-12 text-center">
                        <div class="flex items-center justify-center mb-4">
                            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-full">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Aucune demande en attente
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Toutes les demandes de création de chambres ont été traitées.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>    <!-
- Approval Modal -->
    <div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Approuver la demande
                    </h3>
                    <button type="button" onclick="closeApprovalModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="approvalForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="state_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Numéro d'état (optionnel)
                        </label>
                        <input type="text" name="state_number" id="state_number"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Sera généré automatiquement si vide">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: CHMBR-YYYY-XXXX</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="approval_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Notes (optionnel)
                        </label>
                        <textarea name="notes" id="approval_notes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Notes internes sur l'approbation"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeApprovalModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                            Approuver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Rejeter la demande
                    </h3>
                    <button type="button" onclick="closeRejectionModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="rejectionForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Motif du refus *
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Expliquez les raisons du refus de cette demande"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectionModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleDetails(chamberId) {
            const details = document.getElementById(`details-${chamberId}`);
            const arrow = document.getElementById(`arrow-${chamberId}`);
            
            details.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function showApprovalModal(chamberId) {
            const modal = document.getElementById('approvalModal');
            const form = document.getElementById('approvalForm');
            form.action = `/admin/chambers/${chamberId}/approve-request`;
            modal.classList.remove('hidden');
        }

        function closeApprovalModal() {
            const modal = document.getElementById('approvalModal');
            modal.classList.add('hidden');
            document.getElementById('approvalForm').reset();
        }

        function showRejectionModal(chamberId) {
            const modal = document.getElementById('rejectionModal');
            const form = document.getElementById('rejectionForm');
            form.action = `/admin/chambers/${chamberId}/reject-request`;
            modal.classList.remove('hidden');
        }

        function closeRejectionModal() {
            const modal = document.getElementById('rejectionModal');
            modal.classList.add('hidden');
            document.getElementById('rejectionForm').reset();
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const approvalModal = document.getElementById('approvalModal');
            const rejectionModal = document.getElementById('rejectionModal');
            
            if (event.target === approvalModal) {
                closeApprovalModal();
            }
            if (event.target === rejectionModal) {
                closeRejectionModal();
            }
        }
    </script>
    @endpush
</x-app-layout>