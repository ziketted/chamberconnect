<!-- Skeleton pour les statistiques du dashboard -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @for($i = 0; $i < 4; $i++)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 animate-pulse">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <x-skeleton width="w-24" height="h-4" class="mb-2" />
                    <x-skeleton width="w-16" height="h-8" />
                </div>
                <x-skeleton width="w-12" height="h-12" rounded="rounded-lg" />
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <x-skeleton width="w-20" height="h-3" />
            </div>
        </div>
    @endfor
</div>