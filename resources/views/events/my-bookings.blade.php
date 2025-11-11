@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Mes réservations</h1>
        <p class="text-sm text-neutral-600 dark:text-gray-400 mt-1">Gérez vos participations aux événements</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#073066]/10 text-[#073066] dark:text-blue-400">
                    <i data-lucide="calendar-check" class="h-5 w-5"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $upcomingEvents->count() }}</div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">À venir</div>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <i data-lucide="check-circle" class="h-5 w-5"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ $upcomingEvents->where('pivot.status', 'confirmed')->count() }}
                    </div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">Confirmés</div>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                    <i data-lucide="clock" class="h-5 w-5"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ $upcomingEvents->where('pivot.status', 'reserved')->count() }}
                    </div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">En attente</div>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400">
                    <i data-lucide="history" class="h-5 w-5"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $pastEvents->count() }}</div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500">Passés</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Événements à venir -->
    @if($upcomingEvents->count() > 0)
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Événements à venir</h2>
        <div class="space-y-4">
            @foreach($upcomingEvents as $event)
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            @if($event->chamber->logo_path)
                                <img src="{{ asset('storage/' . $event->chamber->logo_path) }}" 
                                     alt="{{ $event->chamber->name }}"
                                     class="h-10 w-10 rounded-lg object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#073066] to-[#052347] text-white text-sm font-medium">
                                    {{ strtoupper(substr($event->chamber->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $event->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-gray-400">{{ $event->chamber->name }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                {{ $event->date->format('d M Y') }} à {{ $event->time }}
                            </div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                @if($event->mode === 'online')
                                    <i data-lucide="monitor" class="h-4 w-4"></i>
                                    En ligne
                                @elseif($event->mode === 'presentiel')
                                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                                    {{ $event->city }}, {{ $event->country }}
                                @else
                                    <i data-lucide="globe" class="h-4 w-4"></i>
                                    Hybride
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="tag" class="h-4 w-4"></i>
                                {{ ucfirst($event->type) }}
                            </div>
                        </div>
                        
                        @if($event->description)
                        <p class="text-sm text-neutral-600 dark:text-gray-400 mb-4">{{ Str::limit($event->description, 150) }}</p>
                        @endif
                    </div>
                    
                    <div class="flex flex-col items-end gap-3 ml-6">
                        <!-- Statut de la réservation -->
                        <div class="flex items-center gap-2">
                            @if($event->pivot->status === 'reserved')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 dark:bg-yellow-900/30 px-3 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-400">
                                    <i data-lucide="clock" class="h-3 w-3"></i>
                                    Réservé
                                </span>
                            @elseif($event->pivot->status === 'confirmed')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-xs font-medium text-green-800 dark:text-green-400">
                                    <i data-lucide="check-circle" class="h-3 w-3"></i>
                                    Confirmé
                                </span>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            @if($event->pivot->status === 'reserved')
                                <form action="{{ route('events.confirm', $event) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-[#073066] px-3 py-2 text-xs font-medium text-white hover:bg-[#052347] transition-colors">
                                        <i data-lucide="check" class="h-3 w-3"></i>
                                        Confirmer
                                    </button>
                                </form>
                            @endif
                            
                            @if($event->mode === 'online' && $event->lien_live)
                                <a href="{{ $event->lien_live }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700 transition-colors">
                                    <i data-lucide="external-link" class="h-3 w-3"></i>
                                    Rejoindre
                                </a>
                            @endif
                            
                            <form action="{{ route('events.cancel', $event) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 dark:border-red-800 bg-white dark:bg-gray-800 px-3 py-2 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i data-lucide="x" class="h-3 w-3"></i>
                                    Annuler
                                </button>
                            </form>
                        </div>
                        
                        <!-- Date de réservation -->
                        <div class="text-xs text-neutral-500 dark:text-gray-500">
                            Réservé le {{ \Carbon\Carbon::parse($event->pivot->reserved_at)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Événements passés -->
    @if($pastEvents->count() > 0)
    <div>
        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Événements passés</h2>
        <div class="space-y-4">
            @foreach($pastEvents as $event)
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 opacity-75">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            @if($event->chamber->logo_path)
                                <img src="{{ asset('storage/' . $event->chamber->logo_path) }}" 
                                     alt="{{ $event->chamber->name }}"
                                     class="h-10 w-10 rounded-lg object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-600 to-neutral-700 text-white text-sm font-medium">
                                    {{ strtoupper(substr($event->chamber->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $event->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-gray-400">{{ $event->chamber->name }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                {{ $event->date->format('d M Y') }} à {{ $event->time }}
                            </div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                @if($event->mode === 'online')
                                    <i data-lucide="monitor" class="h-4 w-4"></i>
                                    En ligne
                                @elseif($event->mode === 'presentiel')
                                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                                    {{ $event->city }}, {{ $event->country }}
                                @else
                                    <i data-lucide="globe" class="h-4 w-4"></i>
                                    Hybride
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400">
                                <i data-lucide="tag" class="h-4 w-4"></i>
                                {{ ucfirst($event->type) }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end gap-2 ml-6">
                        @if($event->pivot->status === 'attended')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-xs font-medium text-green-800 dark:text-green-400">
                                <i data-lucide="check-circle-2" class="h-3 w-3"></i>
                                Participé
                            </span>
                        @elseif($event->pivot->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-800 dark:text-blue-400">
                                <i data-lucide="check-circle" class="h-3 w-3"></i>
                                Confirmé
                            </span>
                        @elseif($event->pivot->status === 'cancelled')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 dark:bg-red-900/30 px-3 py-1 text-xs font-medium text-red-800 dark:text-red-400">
                                <i data-lucide="x-circle" class="h-3 w-3"></i>
                                Annulé
                            </span>
                        @endif
                        
                        <div class="text-xs text-neutral-500 dark:text-gray-500">
                            {{ \Carbon\Carbon::parse($event->pivot->reserved_at)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Message si aucune réservation -->
    @if($upcomingEvents->count() === 0 && $pastEvents->count() === 0)
    <div class="text-center py-12">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-neutral-100 dark:bg-gray-700 text-neutral-400 dark:text-gray-500 mx-auto mb-4">
            <i data-lucide="calendar-x" class="h-8 w-8"></i>
        </div>
        <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucune réservation</h3>
        <p class="text-sm text-neutral-600 dark:text-gray-400 mb-6">Vous n'avez encore réservé aucun événement.</p>
        <a href="{{ route('events') }}" 
           class="inline-flex items-center gap-2 rounded-lg bg-[#073066] px-4 py-2 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
            <i data-lucide="calendar-plus" class="h-4 w-4"></i>
            Découvrir les événements
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endpush
@endsection