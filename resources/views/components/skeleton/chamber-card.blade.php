@props([
    'variant' => 'default', // default, compact, minimal
    'showActions' => true,
    'showBadge' => true
])

@php
    $variants = [
        'default' => 'p-4',
        'compact' => 'p-3',
        'minimal' => 'p-2'
    ];
    
    $padding = $variants[$variant] ?? $variants['default'];
@endphp

<!-- Skeleton pour une carte de chambre -->
<div class="group relative rounded-xl border border-neutral-100 dark:border-gray-600 {{ $padding }} bg-gradient-to-br from-white to-green-50/30 dark:from-gray-800 dark:to-green-900/10 overflow-hidden">
    <!-- Animation de shimmer -->
    <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
    
    <!-- Contenu principal -->
    <div class="relative">
        <!-- Header avec logo et info -->
        <div class="flex items-center gap-3 {{ $variant === 'minimal' ? 'mb-2' : 'mb-3' }}">
            <!-- Logo skeleton -->
            <div class="flex-shrink-0">
                @if($variant === 'compact')
                    <x-skeleton width="w-10" height="h-10" rounded="rounded-lg" />
                @elseif($variant === 'minimal')
                    <x-skeleton width="w-8" height="h-8" rounded="rounded-md" />
                @else
                    <x-skeleton width="w-12" height="h-12" rounded="rounded-xl" />
                @endif
            </div>
            
            <!-- Nom et localisation -->
            <div class="flex-1 min-w-0 space-y-1">
                @if($variant === 'minimal')
                    <x-skeleton width="w-20" height="h-3" />
                    <x-skeleton width="w-16" height="h-2" />
                @else
                    <x-skeleton width="w-32" height="h-4" />
                    <x-skeleton width="w-24" height="h-3" />
                @endif
            </div>
            
            <!-- Badge de vérification -->
            @if($showBadge && $variant !== 'minimal')
                <div class="flex-shrink-0">
                    <x-skeleton width="w-6" height="h-6" rounded="rounded-full" />
                </div>
            @endif
        </div>
        
        <!-- Footer avec stats et actions -->
        @if($showActions)
            <div class="flex items-center justify-between">
                <!-- Compteur de membres -->
                <div class="flex items-center gap-1">
                    @if($variant === 'minimal')
                        <x-skeleton width="w-3" height="h-3" rounded="rounded-full" />
                        <x-skeleton width="w-6" height="h-2" />
                    @else
                        <x-skeleton width="w-4" height="h-4" rounded="rounded-full" />
                        <x-skeleton width="w-8" height="h-3" />
                    @endif
                </div>
                
                <!-- Boutons d'action -->
                <div class="flex items-center gap-2">
                    @if($variant === 'minimal')
                        <x-skeleton width="w-12" height="h-5" rounded="rounded" />
                        <x-skeleton width="w-5" height="h-5" rounded="rounded" />
                    @elseif($variant === 'compact')
                        <x-skeleton width="w-16" height="h-6" rounded="rounded-md" />
                        <x-skeleton width="w-6" height="h-6" rounded="rounded-md" />
                    @else
                        <x-skeleton width="w-20" height="h-7" rounded="rounded-lg" />
                        <x-skeleton width="w-8" height="h-7" rounded="rounded-lg" />
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
@keyframes shimmer {
    100% {
        transform: translateX(100%);
    }
}
</style>
@endpush