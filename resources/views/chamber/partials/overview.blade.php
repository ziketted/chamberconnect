<div data-chamber-tab="overview" class="p-4 sm:p-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left -->
        <div class="lg:col-span-7 space-y-6">
            <section class="space-y-2">
                <h3 class="text-lg font-semibold tracking-tight">About the Chamber</h3>
                <p class="text-sm text-neutral-700">{{ $chamber->description }}</p>
                <ul class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-neutral-700">
                    @foreach($chamber->features as $feature)
                    <li class="inline-flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-emerald-600"></i> {{ $feature }}
                    </li>
                    @endforeach
                </ul>
            </section>

            <section class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold tracking-tight">Upcoming Events</h3>
                    <a href="{{ route('chambers.events', $chamber) }}" class="text-sm font-medium text-[#E71D36] hover:underline">See all</a>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($upcomingEvents as $event)
                    <a href="{{ route('events.show', $event) }}" class="group relative overflow-hidden rounded-lg border border-neutral-200 hover:border-neutral-300">
                        <img src="{{ $event->image }}" alt="{{ $event->title }}" class="h-32 w-full object-cover">
                        <div class="absolute inset-0 bg-neutral-900/40"></div>
                        <div class="absolute inset-x-0 bottom-0 p-3">
                            <div class="text-white text-sm font-semibold">{{ $event->title }}</div>
                            <div class="text-xs text-neutral-200">{{ $event->date->format('M d') }} • {{ $event->location }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Right -->
        <div class="lg:col-span-5 space-y-6">
            <section class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
                <h3 class="text-sm font-semibold tracking-tight">Contact & Address</h3>
                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 text-neutral-700">
                            <i data-lucide="mail" class="h-4 w-4 text-neutral-500"></i> {{ $chamber->email }}
                        </div>
                        <div class="inline-flex items-center gap-2 text-neutral-700">
                            <i data-lucide="phone" class="h-4 w-4 text-neutral-500"></i> {{ $chamber->phone }}
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 text-neutral-700">
                            <i data-lucide="map-pin" class="h-4 w-4 text-neutral-500"></i> {{ $chamber->address }}
                        </div>
                        <div class="inline-flex items-center gap-2 text-neutral-700">
                            <i data-lucide="globe" class="h-4 w-4 text-neutral-500"></i> {{ $chamber->website }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-3">
                    <a href="{{ $chamber->directions_url }}" target="_blank" class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium hover:bg-neutral-50">
                        <i data-lucide="map" class="h-4 w-4"></i>
                        Get Directions
                    </a>
                    @if($chamber->is_accredited)
                    <div class="inline-flex items-center gap-2 rounded-full bg-neutral-100 px-3 py-1 text-xs text-neutral-800">
                        <i data-lucide="shield-check" class="h-4 w-4 text-[#E71D36]"></i>
                        Accredited
                    </div>
                    @endif
                </div>
            </section>

            <section class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
                <h3 class="text-sm font-semibold tracking-tight">Follow Us</h3>
                <div class="mt-3 flex items-center gap-2">
                    @foreach($chamber->social_links as $platform => $url)
                    <a href="{{ $url }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50" aria-label="{{ ucfirst($platform) }}">
                        <i data-lucide="{{ $platform }}" class="h-5 w-5"></i>
                    </a>
                    @endforeach
                </div>
            </section>

            <section class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold tracking-tight">Partner Companies</h3>
                    <a href="{{ route('chambers.partners', $chamber) }}" class="text-xs font-medium text-[#E71D36] hover:underline">All partners</a>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-3">
                    @foreach($partners->take(3) as $partner)
                    <div class="rounded-lg border border-neutral-200 p-3 text-center">
                        <span class="mx-auto inline-flex h-9 w-9 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-xs font-semibold tracking-tight">
                            {{ $partner->initials }}
                        </span>
                        <div class="mt-1 text-xs">{{ $partner->name }}</div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
