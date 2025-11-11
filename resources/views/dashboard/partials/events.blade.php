<div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
    <div class="flex items-center justify-between border-b border-neutral-200 dark:border-gray-700 px-4 py-3">
        <div class="flex items-center gap-1">
            <button onclick="switchEventsTab('upcoming')" data-events-tab="upcoming" class="events-tab active inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-100 dark:bg-gray-700">
                <i data-lucide="calendar" class="h-4 w-4 text-[#073066] dark:text-blue-400"></i> Upcoming Events
            </button>
            <button onclick="switchEventsTab('past')" data-events-tab="past" class="events-tab inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-100 dark:bg-gray-700">
                <i data-lucide="history" class="h-4 w-4"></i> Past Events
            </button>
        </div>
        <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3.5 py-2 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500/40">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Post an Event
        </a>
    </div>

    <!-- Upcoming Events -->
    <div data-events-panel="upcoming" class="p-4 space-y-4">
        @foreach($upcomingEvents as $event)
        <article class="overflow-hidden rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="grid sm:grid-cols-3 gap-0">
                <img src="{{ $event->image }}" alt="{{ $event->title }}" class="h-40 w-full object-cover sm:col-span-1">
                <div class="sm:col-span-2 p-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-neutral-100 dark:bg-gray-700 px-2.5 py-1 text-xs font-medium text-neutral-800 dark:text-gray-100">
                            <i data-lucide="building-2" class="h-3.5 w-3.5"></i>
                            {{ $event->chamber->name }}
                        </span>
                        <button onclick="toggleBookmark(this)" class="rounded-full p-1.5 text-neutral-600 dark:text-gray-400 hover:bg-neutral-100 dark:hover:bg-gray-700 hover:text-[#073066] dark:hover:text-blue-400" aria-label="Favorite">
                            <i data-lucide="heart" class="h-4 w-4"></i>
                        </button>
                    </div>
                    <h3 class="mt-2 text-base font-semibold tracking-tight">{{ $event->title }}</h3>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">{{ $event->description }}</p>
                    <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-neutral-600 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="calendar" class="h-3.5 w-3.5"></i> {{ $event->date->format('M d, Y') }}
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="map-pin" class="h-3.5 w-3.5"></i> {{ $event->location }}
                        </span>
                        @if($event->is_verified)
                        <span class="inline-flex items-center gap-1 text-teal-600">
                            <i data-lucide="badge-check" class="h-3.5 w-3.5"></i> Verified
                        </span>
                        @endif
                    </div>
                    
                    <!-- Stats Section -->
                    <div class="mt-3 flex items-center gap-6">
                        <div class="flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-500 dark:text-gray-400">
                            <i data-lucide="heart" class="h-4 w-4"></i>
                            <span class="likes-count font-medium">{{ $event->likes_count ?? rand(5, 50) }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-sm text-neutral-500 dark:text-gray-500 dark:text-gray-400">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                            <span class="views-count font-medium">{{ $event->views_count ?? rand(20, 200) }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-3">
                        <button onclick="toggleLike(this)" data-likes="{{ $event->likes_count ?? rand(5, 50) }}" class="like-btn inline-flex items-center justify-center w-9 h-9 rounded-full text-neutral-400 dark:text-gray-500 dark:text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                            <i data-lucide="heart" class="h-4 w-4"></i>
                        </button>
                        <a href="{{ route('events.register', $event) }}" class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors shadow-sm">
                            <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                            Réserver place
                        </a>
                        <a href="{{ route('events.show', $event) }}" onclick="incrementViews(this)" data-views="{{ $event->views_count ?? rand(20, 200) }}" class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-50 dark:bg-gray-700 hover:border-neutral-300 transition-colors">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                            Voir plus
                        </a>
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Past Events -->
    <div data-events-panel="past" class="hidden p-4 space-y-4">
        @foreach($pastEvents as $event)
        <article class="overflow-hidden rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="grid sm:grid-cols-3 gap-0">
                <img src="{{ $event->image }}" alt="{{ $event->title }}" class="h-40 w-full object-cover sm:col-span-1">
                <div class="sm:col-span-2 p-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-neutral-100 dark:bg-gray-700 px-2.5 py-1 text-xs font-medium text-neutral-800 dark:text-gray-100">
                            <i data-lucide="building-2" class="h-3.5 w-3.5"></i>
                            {{ $event->chamber->name }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 border border-emerald-100">
                            <i data-lucide="check-circle2" class="h-3.5 w-3.5"></i>
                            Completed
                        </span>
                    </div>
                    <h3 class="mt-2 text-base font-semibold tracking-tight">{{ $event->title }}</h3>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">{{ $event->description }}</p>
                    <div class="mt-4">
                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:bg-gray-700">
                            <i data-lucide="file-text" class="h-4 w-4"></i>
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
