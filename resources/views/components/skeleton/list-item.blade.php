@props([
    'variant' => 'default', // default, compact, minimal
    'showAvatar' => true,
    'showActions' => true,
    'lines' => 2
])

@php
    $variants = [
        'default' => 'p-4',
        'compact' => 'p-3',
        'minimal' => 'p-2'
    ];
    
    $padding = $variants[$variant] ?? $variants['default'];
@endphp

<!-- Skeleton pour un élément de liste -->
<div class="flex items-center gap-3 {{ $padding }} border-b border-gray-100 dark:border-gray-700 last:border-b-0 overflow-hidden relative">
    <!-- Animation de shimmer -->
    <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
    
    <!-- Avatar/Logo -->
    @if($showAvatar)
        <div class="flex-shrink-0">
            @if($variant === 'minimal')
                <x-skeleton width="w-6" height="h-6" rounded="rounded" />
            @elseif($variant === 'compact')
                <x-skeleton width="w-8" height="h-8" rounded="rounded-lg" />
            @else
                <x-skeleton width="w-10" height="h-10" rounded="rounded-lg" />
            @endif
        </div>
    @endif
    
    <!-- Contenu principal -->
    <div class="flex-1 min-w-0">
        @for($i = 0; $i < $lines; $i++)
            @if($i === 0)
                <!-- Ligne principale -->
                @if($variant === 'minimal')
                    <x-skeleton width="w-24" height="h-3" class="{{ $lines > 1 ? 'mb-1' : '' }}" />
                @else
                    <x-skeleton width="w-32" height="h-4" class="{{ $lines > 1 ? 'mb-1' : '' }}" />
                @endif
            @else
                <!-- Lignes secondaires -->
                @if($variant === 'minimal')
                    <x-skeleton width="w-16" height="h-2" class="{{ $i < $lines - 1 ? 'mb-1' : '' }}" />
                @else
                    <x-skeleton width="w-20" height="h-3" class="{{ $i < $lines - 1 ? 'mb-1' : '' }}" />
                @endif
            @endif
        @endfor
    </div>
    
    <!-- Actions -->
    @if($showActions)
        <div class="flex-shrink-0 flex items-center gap-2">
            @if($variant === 'minimal')
                <x-skeleton width="w-4" height="h-4" rounded="rounded" />
            @elseif($variant === 'compact')
                <x-skeleton width="w-6" height="h-6" rounded="rounded" />
                <x-skeleton width="w-6" height="h-6" rounded="rounded" />
            @else
                <x-skeleton width="w-8" height="h-8" rounded="rounded-lg" />
                <x-skeleton width="w-8" height="h-8" rounded="rounded-lg" />
            @endif
        </div>
    @endif
</div>