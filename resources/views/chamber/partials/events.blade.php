<div data-chamber-tab="events" class="hidden p-4 sm:p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        @foreach($events as $event)
        <article class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            <img src="{{ $event->image }}" class="h-40 w-full object-cover" alt="{{ $event->title }}">
            <div class="p-4">
                <h4 class="text-base font-semibold tracking-tight">{{ $event->title }}</h4>
                <p class="mt-1 text-sm text-neutral-600">{{ $event->description }}</p>
                <div class="mt-3 flex items-center gap-3 text-xs text-neutral-600">
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="calendar" class="h-3.5 w-3.5"></i> {{ $event->date->format('M d') }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="clock" class="h-3.5 w-3.5"></i> {{ $event->time }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="map-pin" class="h-3.5 w-3.5"></i> {{ $event->location }}
                    </span>
                </div>
                
                <!-- Stats Section -->
                <div class="mt-3 flex items-center gap-6">
                    <div class="flex items-center gap-1.5 text-sm text-neutral-500">
                        <i data-lucide="heart" class="h-4 w-4"></i>
                        <span class="likes-count font-medium">{{ $event->likes_count ?? rand(5, 50) }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-sm text-neutral-500">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                        <span class="views-count font-medium">{{ $event->views_count ?? rand(20, 200) }}</span>
                    </div>
                </div>
                
                <div class="mt-4 flex flex-wrap gap-3">
                    <button onclick="toggleLike(this)" data-likes="{{ $event->likes_count ?? rand(5, 50) }}" class="like-btn inline-flex items-center justify-center w-9 h-9 rounded-full text-neutral-400 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                        <i data-lucide="heart" class="h-4 w-4"></i>
                    </button>
                    <a href="{{ route('events.register', $event) }}" class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors shadow-sm">
                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                        Réserver place
                    </a>
                    <a href="{{ route('events.show', $event) }}" onclick="incrementViews(this)" data-views="{{ $event->views_count ?? rand(20, 200) }}" class="inline-flex items-center gap-2 rounded-md border border-neutral-200 bg-white px-4 py-2.5 text-sm font-medium text-neutral-600 hover:bg-neutral-50 hover:border-neutral-300 transition-colors">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                        Voir plus
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
