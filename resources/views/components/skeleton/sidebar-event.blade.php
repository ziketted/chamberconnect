<!-- Skeleton pour un événement dans la sidebar -->
<div class="bg-gray-800 dark:bg-gray-900 border border-gray-700 rounded-lg p-4 animate-pulse">
    <!-- Header avec logo et badge -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-3">
            <x-skeleton width="w-10" height="h-10" rounded="rounded-lg" class="bg-gray-600" />
            <x-skeleton width="w-20" height="h-3" class="bg-gray-600" />
        </div>
        <x-skeleton width="w-16" height="h-4" class="bg-gray-600" />
    </div>

    <!-- Titre -->
    <x-skeleton width="w-3/4" height="h-5" class="mb-3 bg-gray-600" />

    <!-- Détails -->
    <div class="space-y-2 mb-4">
        <div class="flex items-center gap-2">
            <x-skeleton width="w-4" height="h-4" class="bg-gray-600" />
            <x-skeleton width="w-24" height="h-4" class="bg-gray-600" />
        </div>
        <div class="flex items-center gap-2">
            <x-skeleton width="w-4" height="h-4" class="bg-gray-600" />
            <x-skeleton width="w-28" height="h-4" class="bg-gray-600" />
        </div>
        <div class="flex items-center gap-2">
            <x-skeleton width="w-4" height="h-4" class="bg-gray-600" />
            <x-skeleton width="w-32" height="h-4" class="bg-gray-600" />
        </div>
        <div class="flex items-center gap-2">
            <x-skeleton width="w-4" height="h-4" class="bg-gray-600" />
            <x-skeleton width="w-20" height="h-4" class="bg-gray-600" />
        </div>
    </div>

    <!-- Description -->
    <div class="mb-4 space-y-2">
        <x-skeleton width="w-full" height="h-3" class="bg-gray-600" />
        <x-skeleton width="w-5/6" height="h-3" class="bg-gray-600" />
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-3">
        <x-skeleton width="w-16" height="h-8" rounded="rounded-md" class="bg-gray-600" />
        <x-skeleton width="w-24" height="h-8" rounded="rounded-md" class="bg-gray-600" />
        <x-skeleton width="w-20" height="h-8" rounded="rounded-md" class="bg-gray-600" />
    </div>
</div>