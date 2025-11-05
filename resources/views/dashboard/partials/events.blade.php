<div class="rounded-xl border border-neutral-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-neutral-200 px-4 py-3">
        <div class="flex items-center gap-1">
            <button onclick="switchEventsTab('upcoming')" data-events-tab="upcoming" class="events-tab active inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-neutral-100">
                <i data-lucide="calendar" class="h-4 w-4 text-[#E71D36]"></i> Upcoming Events
            </button>
            <button onclick="switchEventsTab('past')" data-events-tab="past" class="events-tab inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 hover:bg-neutral-100">
                <i data-lucide="history" class="h-4 w-4"></i> Past Events
            </button>
        </div>
        <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3.5 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]/40">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Post an Event
        </a>
    </div>

    <!-- Upcoming Events -->
    <div data-events-panel="upcoming" class="p-4 space-y-4">
        @foreach($upcomingEvents as $event)
        <article class="overflow-hidden rounded-lg border border-neutral-200 bg-white shadow-sm hover:shadow-md transition-shadow">
            <div class="grid sm:grid-cols-3 gap-0">
                <img src="{{ $event->image }}" alt="{{ $event->title }}" class="h-40 w-full object-cover sm:col-span-1">
                <div class="sm:col-span-2 p-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-medium text-neutral-800">
                            <i data-lucide="building-2" class="h-3.5 w-3.5"></i>
                            {{ $event->chamber->name }}
                        </span>
                        <button onclick="toggleBookmark(this)" class="rounded-full p-1.5 text-neutral-600 hover:bg-neutral-100 hover:text-[#E71D36]" aria-label="Favorite">
                            <i data-lucide="heart" class="h-4 w-4"></i>
                        </button>
                    </div>
                    <h3 class="mt-2 text-base font-semibold tracking-tight">{{ $event->title }}</h3>
                    <p class="mt-1 text-sm text-neutral-600">{{ $event->description }}</p>
                    <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-neutral-600">
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
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('events.register', $event) }}" class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]/40">
                            <i data-lucide="ticket" class="h-4 w-4"></i>
                            Register
                        </a>
                        @if($event->is_booked)
                        <button class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-50">
                            <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                            Booked
                        </button>
                        @else
                        <a href="{{ route('events.book', $event) }}" class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-50">
                            <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                            Book
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Past Events -->
    <div data-events-panel="past" class="hidden p-4 space-y-4">
        @foreach($pastEvents as $event)
        <article class="overflow-hidden rounded-lg border border-neutral-200 bg-white shadow-sm hover:shadow-md transition-shadow">
            <div class="grid sm:grid-cols-3 gap-0">
                <img src="{{ $event->image }}" alt="{{ $event->title }}" class="h-40 w-full object-cover sm:col-span-1">
                <div class="sm:col-span-2 p-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-medium text-neutral-800">
                            <i data-lucide="building-2" class="h-3.5 w-3.5"></i>
                            {{ $event->chamber->name }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 border border-emerald-100">
                            <i data-lucide="check-circle2" class="h-3.5 w-3.5"></i>
                            Completed
                        </span>
                    </div>
                    <h3 class="mt-2 text-base font-semibold tracking-tight">{{ $event->title }}</h3>
                    <p class="mt-1 text-sm text-neutral-600">{{ $event->description }}</p>
                    <div class="mt-4">
                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium hover:bg-neutral-50">
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
