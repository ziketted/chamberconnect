@props([
    'variant' => 'default', // default, compact
    'showHeader' => true,
    'showActions' => false,
    'items' => 3
])

@php
    $variants = [
        'default' => 'p-4',
        'compact' => 'p-3'
    ];
    
    $padding = $variants[$variant] ?? $variants['default'];
@endphp

<!-- Skeleton pour une section de contenu -->
<div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
    <!-- Header -->
    @if($showHeader)
        <div class="border-b border-neutral-200 dark:border-gray-700 {{ $padding }}">
            <div class="flex items-center justify-between">
                <div>
                    <x-skeleton width="w-32" height="h-5" class="mb-1" />
                    <x-skeleton width="w-48" height="h-3" />
                </div>
                
                @if($showActions)
                    <x-skeleton width="w-6" height="h-6" rounded="rounded" />
                @endif
            </div>
        </div>
    @endif
    
    <!-- Contenu -->
    <div class="{{ $padding }} space-y-4">
        @for($i = 0; $i < $items; $i++)
            <div class="flex items-center gap-3 {{ $i < $items - 1 ? 'pb-3 border-b border-gray-100 dark:border-gray-700' : '' }}">
                <!-- Avatar/Icône -->
                <div class="flex-shrink-0">
                    @if($variant === 'compact')
                        <x-skeleton width="w-8" height="h-8" rounded="rounded-lg" />
                    @else
                        <x-skeleton width="w-10" height="h-10" rounded="rounded-lg" />
                    @endif
                </div>
                
                <!-- Contenu -->
                <div class="flex-1 min-w-0">
                    @if($variant === 'compact')
                        <x-skeleton width="w-24" height="h-3" class="mb-1" />
                        <x-skeleton width="w-16" height="h-2" />
                    @else
                        <x-skeleton width="w-32" height="h-4" class="mb-1" />
                        <x-skeleton width="w-20" height="h-3" />
                    @endif
                </div>
                
                <!-- Action -->
                <div class="flex-shrink-0">
                    <x-skeleton width="w-6" height="h-6" rounded="rounded" />
                </div>
            </div>
        @endfor
        
        <!-- Footer action -->
        @if($showActions)
            <div class="pt-3 border-t border-neutral-200 dark:border-gray-700">
                <x-skeleton width="w-full" height="h-8" rounded="rounded-md" />
            </div>
        @endif
    </div>
</div>