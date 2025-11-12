@props([
    'cols' => 3, // Nombre de colonnes
    'items' => 6, // Nombre d'éléments
    'type' => 'chamber', // chamber, event, stat
    'variant' => 'default'
])

@php
    $gridClasses = [
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 md:grid-cols-2',
        3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
        5 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5',
        6 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6'
    ];
    
    $gridClass = $gridClasses[$cols] ?? $gridClasses[3];
@endphp

<!-- Skeleton pour une grille -->
<div class="grid {{ $gridClass }} gap-4">
    @for($i = 0; $i < $items; $i++)
        @if($type === 'chamber')
            <x-skeleton.chamber-card :variant="$variant" />
        @elseif($type === 'event')
            <x-skeleton.event-card :variant="$variant" />
        @elseif($type === 'stat')
            <x-skeleton.stat-card :variant="$variant" />
        @else
            <!-- Skeleton générique -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 overflow-hidden relative">
                <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                <div class="relative space-y-3">
                    <x-skeleton width="w-full" height="h-4" />
                    <x-skeleton width="w-3/4" height="h-3" />
                    <x-skeleton width="w-1/2" height="h-3" />
                </div>
            </div>
        @endif
    @endfor
</div>