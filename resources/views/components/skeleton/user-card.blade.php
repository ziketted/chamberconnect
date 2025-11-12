<!-- Skeleton pour une carte utilisateur -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 animate-pulse">
    <div class="flex items-center space-x-4">
        <!-- Avatar skeleton -->
        <x-skeleton width="w-12" height="h-12" rounded="rounded-full" />
        
        <div class="flex-1 min-w-0">
            <!-- Nom -->
            <x-skeleton width="w-32" height="h-4" class="mb-2" />
            <!-- Email -->
            <x-skeleton width="w-48" height="h-3" />
        </div>
        
        <!-- Badge de rôle -->
        <x-skeleton width="w-20" height="h-6" rounded="rounded-full" />
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
            <x-skeleton width="w-24" height="h-3" />
            <x-skeleton width="w-16" height="h-3" />
        </div>
    </div>
</div>