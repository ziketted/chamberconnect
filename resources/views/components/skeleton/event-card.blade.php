@props([
    'variant' => 'card', // 'card' ou 'list'
    'showActions' => true
])

<!-- Skeleton pour une carte d'événement -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-pulse">
    <!-- En-tête avec chambre et badge -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <x-skeleton width="w-10" height="h-10" rounded="rounded-lg" />
            <div>
                @if($variant === 'list')
                    <x-skeleton width="w-32" height="h-4" />
                @else
                    <x-skeleton width="w-48" height="h-5" class="mb-1" />
                    <x-skeleton width="w-24" height="h-3" />
                @endif
            </div>
        </div>
        <x-skeleton width="w-16" height="h-6" rounded="rounded-full" />
    </div>

    <!-- Titre de l'événement -->
    @if($variant !== 'list')
        <div class="mb-4">
            <x-skeleton width="w-3/4" height="h-6" class="mb-2" />
        </div>

        <!-- Informations en grille -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <!-- Date -->
            <div class="flex items-center gap-2">
                <x-skeleton width="w-4" height="h-4" rounded="rounded" />
                <x-skeleton width="w-24" height="h-3" />
            </div>
            
            <!-- Lieu -->
            <div class="flex items-center gap-2">
                <x-skeleton width="w-4" height="h-4" rounded="rounded" />
                <x-skeleton width="w-20" height="h-3" />
            </div>
            
            <!-- Participants -->
            <div class="flex items-center gap-2">
                <x-skeleton width="w-4" height="h-4" rounded="rounded" />
                <x-skeleton width="w-16" height="h-3" />
            </div>
            
            <!-- Type -->
            <div class="flex items-center gap-2">
                <x-skeleton width="w-4" height="h-4" rounded="rounded" />
                <x-skeleton width="w-12" height="h-3" />
            </div>
        </div>

        <!-- Description -->
        <div class="space-y-2 mb-6">
            <x-skeleton width="w-full" height="h-3" />
            <x-skeleton width="w-3/4" height="h-3" />
        </div>
    @else
        <!-- Version liste compacte -->
        <div class="space-y-2 mb-4">
            <x-skeleton width="w-full" height="h-4" />
            <x-skeleton width="w-2/3" height="h-3" />
        </div>
    @endif

    <!-- Actions -->
    @if($showActions)
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- Bouton like -->
                @if($variant === 'list')
                    <x-skeleton width="w-8" height="h-6" rounded="rounded" />
                @else
                    <x-skeleton width="w-16" height="h-8" rounded="rounded-lg" />
                @endif
            </div>

            <div class="flex items-center gap-3">
                <!-- Boutons d'action -->
                @if($variant === 'list')
                    <x-skeleton width="w-16" height="h-6" rounded="rounded" />
                    <x-skeleton width="w-12" height="h-6" rounded="rounded" />
                @else
                    <x-skeleton width="w-24" height="h-8" rounded="rounded-lg" />
                    <x-skeleton width="w-20" height="h-8" rounded="rounded-lg" />
                @endif
            </div>
        </div>
    @endif
</div>