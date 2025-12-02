@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('chamber.show', $chamber) }}" 
               class="inline-flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Retour à {{ $chamber->name }}
            </a>
        </div>
        
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $event->title }}</h1>
                <p class="text-sm text-neutral-600 dark:text-gray-400 mt-1">
                    Gestion des participants • {{ $event->date->format('d M Y') }} à {{ $event->time }}
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Statistiques rapides -->
                <div class="text-right">
                    <div class="text-2xl font-bold text-[#073066] dark:text-blue-400">{{ $participants->count() }}</div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">
                        @if($event->max_participants)
                            / {{ $event->max_participants }} participants
                        @else
                            participants
                        @endif
                    </div>
                </div>
                
                @if($event->max_participants)
                <div class="w-16 h-16">
                    <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-neutral-200 dark:text-gray-700" stroke="currentColor" stroke-width="3" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        <path class="text-[#073066] dark:text-blue-400" stroke="currentColor" stroke-width="3" fill="none"
                              stroke-dasharray="{{ ($participants->count() / $event->max_participants) * 100 }}, 100"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    </svg>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Informations de l'événement -->
    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#073066]/10 text-[#073066] dark:text-blue-400">
                    <i data-lucide="calendar" class="h-5 w-5"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-neutral-900 dark:text-white">{{ $event->date->format('d M Y') }}</div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">{{ $event->time }}</div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#fcb357]/10 text-[#fcb357]">
                    @if($event->mode === 'online')
                        <i data-lucide="monitor" class="h-5 w-5"></i>
                    @elseif($event->mode === 'presentiel')
                        <i data-lucide="map-pin" class="h-5 w-5"></i>
                    @else
                        <i data-lucide="globe" class="h-5 w-5"></i>
                    @endif
                </div>
                <div>
                    <div class="text-sm font-medium text-neutral-900 dark:text-white">
                        {{ ucfirst($event->mode) }}
                    </div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">
                        @if($event->mode === 'online')
                            En ligne
                        @elseif($event->mode === 'presentiel')
                            {{ $event->city }}, {{ $event->country }}
                        @else
                            Hybride
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-neutral-900 dark:text-white">
                        {{ $participants->where('pivot.status', 'confirmed')->count() }} confirmés
                    </div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">
                        {{ $participants->where('pivot.status', 'reserved')->count() }} en attente
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et actions -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-neutral-700 dark:text-gray-300">Filtrer par statut:</span>
            <select id="status-filter" class="rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-1 text-sm">
                <option value="">Tous</option>
                <option value="reserved">Réservé</option>
                <option value="confirmed">Confirmé</option>
                <option value="attended">Présent</option>
                <option value="cancelled">Annulé</option>
            </select>
        </div>
        
        <div class="flex items-center gap-2">
            <button onclick="exportParticipants()" 
                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700">
                <i data-lucide="download" class="h-4 w-4"></i>
                Exporter
            </button>
        </div>
    </div>

    <!-- Liste des participants -->
    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        @if($participants->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-neutral-200 dark:border-gray-700 bg-neutral-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-gray-400 uppercase tracking-wider">
                                Participant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-gray-400 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-gray-400 uppercase tracking-wider">
                                Réservé le
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-gray-400 uppercase tracking-wider">
                                Notes
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-gray-700">
                        @foreach($participants as $participant)
                        <tr class="participant-row hover:bg-neutral-50 dark:hover:bg-gray-700/50" data-status="{{ $participant->pivot->status }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($participant->avatar)
                                        <img src="{{ asset('storage/' . $participant->avatar) }}" 
                                             alt="{{ $participant->name }}"
                                             class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#073066] text-white text-sm font-medium">
                                            {{ strtoupper(substr($participant->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-neutral-900 dark:text-white">{{ $participant->name }}</div>
                                        <div class="text-xs text-neutral-500 dark:text-gray-500">{{ $participant->email }}</div>
                                        @if($participant->company)
                                            <div class="text-xs text-neutral-400 dark:text-gray-600">{{ $participant->company }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('chambers.events.participants.update', [$chamber, $event, $participant]) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="rounded-md border-0 text-sm font-medium focus:ring-2 focus:ring-[#073066]/20 
                                                   {{ $participant->pivot->status === 'reserved' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                                   {{ $participant->pivot->status === 'confirmed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                                   {{ $participant->pivot->status === 'attended' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                                   {{ $participant->pivot->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                        <option value="reserved" {{ $participant->pivot->status === 'reserved' ? 'selected' : '' }}>Réservé</option>
                                        <option value="confirmed" {{ $participant->pivot->status === 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                                        <option value="attended" {{ $participant->pivot->status === 'attended' ? 'selected' : '' }}>Présent</option>
                                        <option value="cancelled" {{ $participant->pivot->status === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-500 dark:text-gray-500">
                                {{ \Carbon\Carbon::parse($participant->pivot->reserved_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-500 dark:text-gray-500">
                                {{ $participant->pivot->notes ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="showParticipantDetails({{ $participant->id }})" 
                                        class="inline-flex items-center gap-1 text-sm text-[#073066] dark:text-blue-400 hover:text-[#052347] dark:hover:text-blue-300">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    Détails
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($participants->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200 dark:border-gray-700">
                    {{ $participants->links() }}
                </div>
                @endif
            </div>
        @else
            <div class="text-center py-12">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
                    <i data-lucide="users" class="h-6 w-6"></i>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun participant</h3>
                <p class="text-sm text-neutral-600 dark:text-gray-400">Aucune réservation n'a encore été effectuée pour cet événement.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    const participantRows = document.querySelectorAll('.participant-row');

    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;
        
        participantRows.forEach(row => {
            if (selectedStatus === '' || row.dataset.status === selectedStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    lucide.createIcons();
});

function exportParticipants() {
    // Logique d'export (CSV, Excel, etc.)
    alert('Fonctionnalité d\'export à implémenter');
}

function showParticipantDetails(participantId) {
    // Afficher les détails du participant
    alert('Détails du participant ' + participantId);
}
</script>
@endpush
@endsection