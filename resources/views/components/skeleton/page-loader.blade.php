@props([
    'layout' => 'dashboard', // dashboard, list, grid
    'showSidebar' => true,
    'showHeader' => true
])

<!-- Skeleton pour une page complète -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @if($showHeader)
        <!-- Header skeleton -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <x-skeleton width="w-8" height="h-8" rounded="rounded-lg" />
                    <x-skeleton width="w-32" height="h-6" />
                </div>
                <div class="flex items-center gap-3">
                    <x-skeleton width="w-8" height="h-8" rounded="rounded-full" />
                    <x-skeleton width="w-8" height="h-8" rounded="rounded-full" />
                    <x-skeleton width="w-8" height="h-8" rounded="rounded-full" />
                </div>
            </div>
        </div>
    @endif

    <div class="flex">
        @if($showSidebar)
            <!-- Sidebar skeleton -->
            <div class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 min-h-screen p-4">
                <div class="space-y-4">
                    <!-- Navigation items -->
                    @for($i = 0; $i < 6; $i++)
                        <div class="flex items-center gap-3 p-2">
                            <x-skeleton width="w-5" height="h-5" rounded="rounded" />
                            <x-skeleton width="w-24" height="h-4" />
                        </div>
                    @endfor
                </div>
            </div>
        @endif

        <!-- Main content -->
        <div class="flex-1 p-6">
            @if($layout === 'dashboard')
                <!-- Dashboard layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Main content -->
                    <div class="lg:col-span-8">
                        <!-- Page title -->
                        <div class="mb-6">
                            <x-skeleton width="w-48" height="h-8" class="mb-2" />
                            <x-skeleton width="w-64" height="h-4" />
                        </div>

                        <!-- Stats cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            @for($i = 0; $i < 3; $i++)
                                <x-skeleton.stat-card />
                            @endfor
                        </div>

                        <!-- Main content area -->
                        <div class="space-y-4">
                            @for($i = 0; $i < 4; $i++)
                                <x-skeleton.event-card variant="compact" />
                            @endfor
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-4 space-y-4">
                        <x-skeleton.content-section :items="3" />
                        <x-skeleton.content-section :items="4" variant="compact" />
                    </div>
                </div>

            @elseif($layout === 'grid')
                <!-- Grid layout -->
                <div class="mb-6">
                    <x-skeleton width="w-48" height="h-8" class="mb-2" />
                    <x-skeleton width="w-64" height="h-4" />
                </div>
                
                <x-skeleton.grid :cols="3" :items="9" type="chamber" />

            @else
                <!-- List layout -->
                <div class="mb-6">
                    <x-skeleton width="w-48" height="h-8" class="mb-2" />
                    <x-skeleton width="w-64" height="h-4" />
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                    @for($i = 0; $i < 8; $i++)
                        <x-skeleton.list-item />
                    @endfor
                </div>
            @endif
        </div>
    </div>
</div>