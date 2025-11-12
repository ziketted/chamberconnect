@props([
    'variant' => 'default', // default, compact, minimal
    'showIcon' => true,
    'showTrend' => false
])

@php
    $variants = [
        'default' => 'p-4',
        'compact' => 'p-3',
        'minimal' => 'p-2'
    ];
    
    $padding = $variants[$variant] ?? $variants['default'];
@endphp

<!-- Skeleton pour une carte de statistique -->
<div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 {{ $padding }} overflow-hidden relative">
    <!-- Animation de shimmer -->
    <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
    
    <!-- Contenu -->
    <div class="relative">
        <!-- Header avec icône -->
        @if($showIcon)
            <div class="flex items-center justify-between {{ $variant === 'minimal' ? 'mb-2' : 'mb-3' }}">
                <div class="flex items-center gap-2">
                    @if($variant === 'minimal')
                        <x-skeleton width="w-4" height="h-4" rounded="rounded" />
                        <x-skeleton width="w-16" height="h-3" />
                    @else
                        <x-skeleton width="w-5" height="h-5" rounded="rounded" />
                        <x-skeleton width="w-20" height="h-4" />
                    @endif
                </div>
                
                @if($showTrend && $variant !== 'minimal')
                    <x-skeleton width="w-8" height="h-4" rounded="rounded" />
                @endif
            </div>
        @endif
        
        <!-- Valeur principale -->
        <div class="{{ $variant === 'minimal' ? 'mb-1' : 'mb-2' }}">
            @if($variant === 'minimal')
                <x-skeleton width="w-8" height="h-5" />
            @elseif($variant === 'compact')
                <x-skeleton width="w-12" height="h-6" />
            @else
                <x-skeleton width="w-16" height="h-8" />
            @endif
        </div>
        
        <!-- Label/Description -->
        @if($variant === 'minimal')
            <x-skeleton width="w-12" height="h-2" />
        @else
            <x-skeleton width="w-20" height="h-3" />
        @endif
    </div>
</div>