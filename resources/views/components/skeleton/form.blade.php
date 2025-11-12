<!-- Skeleton pour un formulaire -->
<div class="space-y-6 animate-pulse">
    @for($i = 0; $i < 5; $i++)
        <div>
            <!-- Label -->
            <x-skeleton width="w-24" height="h-4" class="mb-2" />
            <!-- Input field -->
            <x-skeleton width="w-full" height="h-10" rounded="rounded-md" />
        </div>
    @endfor
    
    <!-- Boutons d'action -->
    <div class="flex justify-end space-x-3 pt-4">
        <x-skeleton width="w-20" height="h-10" rounded="rounded-md" />
        <x-skeleton width="w-24" height="h-10" rounded="rounded-md" />
    </div>
</div>