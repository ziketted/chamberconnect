<!-- Skeleton pour la navigation -->
<nav class="animate-pulse">
    <div class="flex items-center justify-between p-4">
        <!-- Logo -->
        <x-skeleton width="w-32" height="h-8" />
        
        <!-- Menu items -->
        <div class="hidden md:flex space-x-6">
            @for($i = 0; $i < 4; $i++)
                <x-skeleton width="w-20" height="h-4" />
            @endfor
        </div>
        
        <!-- User menu -->
        <div class="flex items-center space-x-3">
            <x-skeleton width="w-8" height="h-8" rounded="rounded-full" />
            <x-skeleton width="w-24" height="h-4" />
        </div>
    </div>
</nav>