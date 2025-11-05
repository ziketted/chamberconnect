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
                <div class="mt-4">
                    <a href="{{ route('events.register', $event) }}" class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]">
                        <i data-lucide="ticket" class="h-4 w-4"></i> Register
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
