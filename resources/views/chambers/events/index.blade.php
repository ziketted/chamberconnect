@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('chamber.show', $chamber) }}" 
               class="inline-flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Retour à {{ $chamber->name }}
            </a>
            <a href="{{ route('chambers.events.create', $chamber) }}"
               class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                Créer un événement
            </a>
        </div>
        <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Gestion des événements</h1>
        <p class="text-sm text-neutral-600 dark:text-gray-400 mt-1">Gérez tous les événements de votre chambre</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400"></i>
                <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($events->count() > 0)
    {{-- Search Bar --}}
    <div class="mb-6">
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 dark:text-gray-500">
                <i data-lucide="search" class="h-5 w-5"></i>
            </span>
            <input type="text" id="events-search"
                placeholder="Rechercher un événement par titre, type ou mode..."
                class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-4 py-2.5 text-sm text-neutral-800 dark:text-gray-100 placeholder:text-neutral-400 dark:placeholder:text-gray-500 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="border-b border-neutral-200 dark:border-gray-700 px-6 py-4">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-white">Événements ({{ $events->count() }})</h2>
        </div>
        <div class="divide-y divide-neutral-200 dark:divide-gray-700">
            @foreach($events as $event)
            <div class="event-item p-6 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors"
                 data-title="{{ strtolower($event->title) }}"
                 data-type="{{ strtolower($event->type) }}"
                 data-mode="{{ strtolower($event->mode) }}">
                <div class="flex items-center gap-6">
                    {{-- Image de couverture --}}
                    <div class="flex-shrink-0">
                        @if($event->cover_image_path)
                            <img src="{{ asset('storage/' . $event->cover_image_path) }}" 
                                 alt="{{ $event->title }}"
                                 class="h-24 w-36 rounded-lg object-cover">
                        @else
                            <div class="h-24 w-36 rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] flex items-center justify-center">
                                <i data-lucide="calendar" class="h-10 w-10 text-white/30"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Informations de l'événement --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">{{ $event->title }}</h3>
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                {{ $event->date->format('d M Y') }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="clock" class="h-4 w-4"></i>
                                {{ $event->time }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-xs font-medium text-blue-800 dark:text-blue-300">
                                <i data-lucide="tag" class="h-3 w-3"></i>
                                {{ ucfirst($event->type) }}
                            </span>
                            @if($event->mode === 'online')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/30 text-xs font-medium text-purple-800 dark:text-purple-300">
                                    <i data-lucide="monitor" class="h-3 w-3"></i>
                                    En ligne
                                </span>
                            @elseif($event->mode === 'presentiel')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-xs font-medium text-green-800 dark:text-green-300">
                                    <i data-lucide="map-pin" class="h-3 w-3"></i>
                                    Présentiel
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-xs font-medium text-orange-800 dark:text-orange-300">
                                    <i data-lucide="globe" class="h-3 w-3"></i>
                                    Hybride
                                </span>
                            @endif
                            @if($event->status === 'full')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-xs font-medium text-red-800 dark:text-red-300">
                                    <i data-lucide="users-x" class="h-3 w-3"></i>
                                    Complet
                                </span>
                            @endif
                        </div>
                        @if($event->description)
                        <p class="text-sm text-neutral-600 dark:text-gray-400 line-clamp-2 mb-2">{{ $event->description }}</p>
                        @endif
                        {{-- Participant count --}}
                        <div class="flex items-center gap-1.5 text-sm text-neutral-600 dark:text-gray-400">
                            <i data-lucide="users" class="h-4 w-4"></i>
                            <span class="font-medium">{{ $event->participants()->count() }}</span>
                            @if($event->max_participants)
                                <span>/ {{ $event->max_participants }}</span>
                            @endif
                            <span>participant(s)</span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('chambers.events.participants', [$chamber, $event]) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-md border border-blue-200 dark:border-blue-800 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20">
                            <i data-lucide="users" class="h-4 w-4"></i>
                            Participants
                        </a>
                        <a href="{{ route('chambers.events.edit', [$chamber, $event]) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700">
                            <i data-lucide="edit" class="h-4 w-4"></i>
                            Modifier
                        </a>
                        <button type="button" onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}')"
                                class="inline-flex items-center justify-center gap-2 rounded-md border border-red-200 dark:border-red-800 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                            Supprimer
                        </button>
                        <form id="delete-form-{{ $event->id }}" 
                              action="{{ route('chambers.events.destroy', [$chamber, $event]) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-12 text-center">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
            <i data-lucide="calendar-x" class="h-8 w-8"></i>
        </div>
        <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun événement</h3>
        <p class="text-sm text-neutral-600 dark:text-gray-400 mb-6">Vous n'avez pas encore créé d'événement pour cette chambre.</p>
        <a href="{{ route('chambers.events.create', $chamber) }}"
           class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
            <i data-lucide="calendar-plus" class="h-4 w-4"></i>
            Créer votre premier événement
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    
    // Search functionality
    const searchInput = document.getElementById('events-search');
    const eventItems = document.querySelectorAll('.event-item');
    
    if (searchInput && eventItems.length > 0) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            eventItems.forEach(item => {
                const title = item.dataset.title || '';
                const type = item.dataset.type || '';
                const mode = item.dataset.mode || '';
                
                const matches = query === '' || 
                    title.includes(query) || 
                    type.includes(query) || 
                    mode.includes(query);
                
                item.style.display = matches ? 'block' : 'none';
            });
        });
    }
});

// Fonction de confirmation de suppression
function confirmDelete(eventId, eventTitle) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'événement "${eventTitle}" ?\n\nCette action est irréversible.`)) {
        document.getElementById('delete-form-' + eventId).submit();
    }
}
</script>
@endpush
@endsection
