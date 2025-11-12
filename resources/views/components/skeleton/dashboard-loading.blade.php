@props([
    'showSidebar' => true,
    'showEvents' => true,
    'showChambers' => true
])

<!-- Skeleton de chargement pour le dashboard -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    @if($showSidebar)
        <!-- Sidebar Gauche - Mes Chambres -->
        <aside class="lg:col-span-3">
            <div class="sticky top-[88px] space-y-4">
                <!-- Statistiques rapides -->
                <x-skeleton.content-section 
                    :show-header="true" 
                    :items="2" 
                    variant="compact" 
                />

                <!-- Mes Chambres -->
                <x-skeleton.content-section 
                    :show-header="true" 
                    :show-actions="true" 
                    :items="3" 
                />
            </div>
        </aside>
    @endif

    <!-- Contenu Principal -->
    <main class="{{ $showSidebar ? 'lg:col-span-6' : 'lg:col-span-9' }}">
        <!-- Header avec recherche -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <x-skeleton width="w-48" height="h-8" />
            </div>
            
            <!-- Barre de recherche -->
            <div class="relative">
                <x-skeleton width="w-full" height="h-12" rounded="rounded-xl" />
            </div>
        </div>

        <!-- Filtres rapides -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <x-skeleton width="w-20" height="h-4" class="mr-2" />
            @for($i = 0; $i < 6; $i++)
                <x-skeleton width="w-16" height="h-8" rounded="rounded-full" />
            @endfor
        </div>

        @if($showEvents)
            <!-- Liste des événements -->
            <div class="space-y-4">
                @for($i = 0; $i < 4; $i++)
                    <x-skeleton.event-card />
                @endfor
            </div>
        @endif
    </main>

    @if($showChambers)
        <!-- Sidebar Droite -->
        <aside class="lg:col-span-3">
            <div class="sticky top-[88px] space-y-4">
                <!-- Chambres Suggérées -->
                <x-skeleton.content-section 
                    :show-header="true" 
                    :show-actions="true" 
                    :items="3" 
                />

                <!-- Section Investir -->
                <x-skeleton.content-section 
                    :show-header="true" 
                    :show-actions="true" 
                    :items="4" 
                    variant="compact" 
                />
            </div>
        </aside>
    @endif
</div>