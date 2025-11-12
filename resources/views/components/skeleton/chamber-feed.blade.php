<!-- Skeleton pour une chambre dans le feed principal -->
<article class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 animate-pulse">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-skeleton width="w-10" height="h-10" rounded="rounded-lg" />
                <div>
                    <x-skeleton width="w-32" height="h-4" class="mb-1" />
                    <x-skeleton width="w-24" height="h-3" />
                </div>
            </div>
            <x-skeleton width="w-20" height="h-6" rounded="rounded-full" />
        </div>

        <div class="mt-3">
            <x-skeleton width="w-48" height="h-5" class="mb-2" />
            <div class="space-y-2">
                <x-skeleton width="w-full" height="h-4" />
                <x-skeleton width="w-3/4" height="h-4" />
            </div>
        </div>

        <div class="mt-3 flex flex-wrap gap-2">
            <x-skeleton width="w-16" height="h-6" rounded="rounded-md" />
            <x-skeleton width="w-20" height="h-6" rounded="rounded-md" />
            <x-skeleton width="w-24" height="h-6" rounded="rounded-md" />
        </div>

        <div class="mt-4 flex gap-2">
            <x-skeleton width="w-32" height="h-9" rounded="rounded-md" />
            <x-skeleton width="w-28" height="h-9" rounded="rounded-md" />
        </div>
    </div>
</article>