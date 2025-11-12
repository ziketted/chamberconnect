@extends('layouts.app')

@section('title', 'Mes demandes de création')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Mes demandes de création
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Suivez l'état de vos demandes de création de chambre
                        </p>
                    </div>
                    <a href="{{ route('portal.chamber.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle demande
                    </a>
                </div>
            </div>

            @if($chambers->count() > 0)
                <div class="space-y-6">
                    @foreach($chambers as $chamber)
                        @php
                            $applicationData = json_decode($chamber->certification_notes, true) ?? [];
                            $submittedAt = isset($applicationData['submitted_at']) ? \Carbon\Carbon::parse($applicationData['submitted_at']) : $chamber->created_at;
                        @endphp
                        
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                {{ $chamber->name }}
                                            </h3>
                                            @if($chamber->verified)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Validée
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
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-600 dark:text-gray-400">
                                            <div>
                                                <span class="font-medium">Sigle:</span>
                                                {{ $applicationData['sigle'] ?? 'Non renseigné' }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Province:</span>
                                                {{ $chamber->location }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Soumise le:</span>
                                                {{ $submittedAt->format('d/m/Y à H:i') }}
                                            </div>
                                            @if($chamber->verified && $chamber->state_number)
                                                <div>
                                                    <span class="font-medium">Numéro d'état:</span>
                                                    <span class="font-mono text-green-600 dark:text-green-400">{{ $chamber->state_number }}</span>
                                                </div>
                                            @endif
                                            @if($chamber->certification_date)
                                                <div>
                                                    <span class="font-medium">Date de certification:</span>
                                                    {{ $chamber->certification_date->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        </div>

                                        @if($chamber->description)
                                            <p class="mt-3 text-gray-600 dark:text-gray-400 text-sm">
                                                {{ Str::limit($chamber->description, 200) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex flex-col space-y-2 ml-4">
                                        @if($chamber->verified)
                                            <a href="{{ route('chamber.show', $chamber) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Voir la chambre
                                            </a>
                                        @endif
                                        
                                        <button type="button" onclick="showDetails('{{ $chamber->id }}')"
                                                class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Détails
                                        </button>
                                    </div>
                                </div>

                                <!-- Details Panel (Hidden by default) -->
                                <div id="details-{{ $chamber->id }}" class="hidden mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                            </dl>
                                        </div>

                                        @if(isset($applicationData['documents']))
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Documents soumis</h4>
                                                <ul class="space-y-2 text-sm">
                                                    @foreach($applicationData['documents'] as $docType => $docPath)
                                                        <li class="flex items-center text-green-600 dark:text-green-400">
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
                    {{ $chambers->links() }}
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
                            Aucune demande trouvée
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Vous n'avez pas encore soumis de demande de création de chambre.
                        </p>
                        <a href="{{ route('portal.chamber.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Créer ma première demande
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function showDetails(chamberId) {
        const detailsPanel = document.getElementById(`details-${chamberId}`);
        detailsPanel.classList.toggle('hidden');
    }
</script>
@endpush