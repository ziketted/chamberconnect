@extends('layouts.app')

@section('content')
<!-- Banner -->
<div class="overflow-hidden rounded-2xl border border-neutral-200 dark:border-gray-700 shadow-sm">
    <div class="relative">
        <img src="{{ $chamber->cover_image_path ? asset('storage/' . $chamber->cover_image_path) : 'https://images.unsplash.com/photo-1642615835477-d303d7dc9ee9?w=1080&q=80' }}"
            alt="{{ $chamber->name }}" class="h-56 w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-black/0"></div>
        <div class="absolute bottom-4 left-4 right-4">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div class="flex items-end gap-4">
                    <!-- Logo de la chambre -->
                    @if($chamber->logo_path)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $chamber->logo_path) }}" alt="{{ $chamber->name }}"
                            class="h-16 w-16 rounded-lg border-2 border-white shadow-lg object-cover">
                    </div>
                    @endif
                    <div>
                        <h2 class="text-white text-3xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">
                            {{ $chamber->name }}
                        </h2>
                        <div class="mt-1 flex items-center gap-3 text-sm text-neutral-200">
                            @if($chamber->location)
                            <span class="inline-flex items-center gap-1">
                                <i data-lucide="map-pin" class="h-4 w-4"></i>
                                {{ $chamber->location }}
                            </span>
                            @endif
                            <span class="inline-flex items-center gap-1">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                {{ $membersCount }} {{ $membersCount > 1 ? 'membres' : 'membre' }}
                            </span>
                            @if($chamber->verified)
                            <span class="inline-flex items-center gap-1">
                                <i data-lucide="shield-check" class="h-4 w-4"></i>
                                Vérifiée
                            </span>
                            @endif
                            @if($chamber->state_number)
                            <span class="inline-flex items-center gap-1">
                                <i data-lucide="award" class="h-4 w-4"></i>
                                Agréée
                            </span>
                            @endif
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            @php($typeLabel = $chamber->type === 'bilateral' ? 'Bilatérale' : 'Nationale')
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-2.5 py-1 text-xs font-medium text-white backdrop-blur">
                                <i data-lucide="layers" class="h-3.5 w-3.5"></i>
                                {{ $typeLabel }}
                            </span>
                            @if($chamber->type === 'bilateral' && $chamber->embassy_country)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-2.5 py-1 text-xs font-medium text-white backdrop-blur">
                                <i data-lucide="flag" class="h-3.5 w-3.5"></i>
                                {{ $chamber->embassy_country }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button
                        class="inline-flex items-center gap-2 rounded-md border border-white/60 bg-white/10 px-3 py-2 text-sm font-semibold text-white backdrop-blur hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                        <i data-lucide="share-2" class="h-4 w-4"></i> Partager
                    </button>
                    @if(!$isMember)
                    <button onclick="joinChamber('{{ $chamber->slug }}')"
                        class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                        <i data-lucide="user-plus" class="h-4 w-4"></i> Rejoindre
                    </button>
                    @elseif($membershipStatus === 'pending')
                    <button disabled
                        class="inline-flex items-center gap-2 rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white cursor-not-allowed">
                        <i data-lucide="clock" class="h-4 w-4"></i> En attente
                    </button>
                    @else
                    <button
                        class="inline-flex items-center gap-2 rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white">
                        <i data-lucide="check" class="h-4 w-4"></i> Membre
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sub Nav -->
<div class="mt-6 rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
    <div class="flex flex-wrap items-center gap-1 border-b border-neutral-200 dark:border-gray-700 px-4 py-2">
        <button onclick="switchChamberTab('overview')" data-chamber-link="overview"
            class="cham-link active inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-100 dark:bg-gray-700"><i
                data-lucide="layout-dashboard" class="h-4 w-4 text-[#073066] dark:text-blue-400"></i> Overview</button>
        <button onclick="switchChamberTab('events')" data-chamber-link="events"
            class="cham-link inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-100 dark:bg-gray-700"><i
                data-lucide="calendar" class="h-4 w-4"></i> Events</button>
        <button onclick="switchChamberTab('members')" data-chamber-link="members"
            class="cham-link inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-100 dark:bg-gray-700"><i
                data-lucide="users" class="h-4 w-4"></i> Members</button>
        <button onclick="switchChamberTab('partners')" data-chamber-link="partners"
            class="cham-link inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 dark:text-gray-400 hover:bg-neutral-100 dark:bg-gray-700"><i
                data-lucide="handshake" class="h-4 w-4"></i> Partners</button>
    </div>

    <!-- Overview -->
    <div data-chamber-tab="overview" class="p-4 sm:p-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left -->
            <div class="lg:col-span-7 space-y-6">
                <section class="space-y-2">
                    <h3 class="text-lg font-semibold tracking-tight" style="letter-spacing:-0.01em;">À propos de la
                        chambre</h3>
                    <p
                        class="text-sm text-neutral-700 dark:text-gray-300 break-all line-clamp-4 max-h-24 overflow-hidden">
                        {{ $chamber->description ?: 'Cette chambre de commerce connecte les entreprises avec des
                        opportunités de croissance et de développement. Nous fournissons un accès aux informations
                        politiques, à l\'intelligence de marché et au réseautage pour catalyser une croissance durable.'
                        }}
                    </p>

                    @if($chamber->verified || $chamber->state_number || $chamber->certification_date)
                    <div
                        class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <h4 class="text-sm font-semibold text-green-800 dark:text-green-300 mb-2">Certifications et
                            agréments</h4>
                        <ul class="space-y-2 text-sm text-green-700 dark:text-green-300">
                            @if($chamber->verified)
                            <li class="inline-flex items-center gap-2">
                                <i data-lucide="check-circle" class="h-4 w-4 text-green-600"></i>
                                Chambre vérifiée et authentifiée
                            </li>
                            @endif
                            @if($chamber->state_number)
                            <li class="inline-flex items-center gap-2">
                                <i data-lucide="award" class="h-4 w-4 text-green-600"></i>
                                Agréée par l'État (N° {{ $chamber->state_number }})
                            </li>
                            @endif
                            @if($chamber->certification_date)
                            <li class="inline-flex items-center gap-2">
                                <i data-lucide="calendar-check" class="h-4 w-4 text-green-600"></i>
                                Certifiée le {{ $chamber->certification_date->format('d/m/Y') }}
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </section>

                <section class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold tracking-tight" style="letter-spacing:-0.01em;">Événements à
                            venir</h3>
                        <button onclick="switchChamberTab('events')"
                            class="text-sm font-medium text-[#073066] dark:text-blue-400 hover:underline">Voir
                            tous</button>
                    </div>
                    @if($chamber->events->count() > 0)
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($chamber->events->take(2) as $event)
                        <a href="#"
                            class="group relative overflow-hidden rounded-lg border border-neutral-200 dark:border-gray-700 hover:border-neutral-300">
                            <img src="{{ $event->image_path ? asset('storage/' . $event->image_path) : 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop' }}"
                                alt="{{ $event->title }}" class="h-32 w-full object-cover">
                            <div class="absolute inset-0 bg-neutral-900/40"></div>
                            <div class="absolute inset-x-0 bottom-0 p-3">
                                <div class="text-white text-sm font-semibold">{{ $event->title }}</div>
                                <div class="text-xs text-neutral-200">
                                    {{ $event->date ? $event->date->format('M j') : 'Date TBD' }} • {{ $event->location
                                    ?: 'Lieu TBD' }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="text-sm font-medium mb-2">Aucun événement programmé</h3>
                        <p class="text-xs">Les événements à venir apparaîtront ici.</p>
                    </div>
                    @endif
                </section>
            </div>

            <!-- Right -->
            <div class="lg:col-span-5 space-y-6">
                <section
                    class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
                    <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Contact & Adresse
                    </h3>
                    <div class="mt-3 space-y-3 text-sm">
                        @if($chamber->email)
                        <div class="inline-flex items-center gap-2 text-neutral-700 dark:text-gray-300">
                            <i data-lucide="mail" class="h-4 w-4 text-neutral-500 dark:text-gray-400"></i>
                            <a href="mailto:{{ $chamber->email }}"
                                class="text-[#073066] dark:text-blue-400 hover:underline">{{ $chamber->email }}</a>
                        </div>
                        @endif

                        @if($chamber->phone)
                        <div class="inline-flex items-center gap-2 text-neutral-700 dark:text-gray-300">
                            <i data-lucide="phone" class="h-4 w-4 text-neutral-500 dark:text-gray-400"></i>
                            <a href="tel:{{ $chamber->phone }}"
                                class="text-[#073066] dark:text-blue-400 hover:underline">{{ $chamber->phone }}</a>
                        </div>
                        @endif

                        @if($chamber->address)
                        <div class="inline-flex items-start gap-2 text-neutral-700 dark:text-gray-300">
                            <i data-lucide="map-pin" class="h-4 w-4 text-neutral-500 dark:text-gray-400 mt-0.5"></i>
                            <span>{{ $chamber->address }}</span>
                        </div>
                        @endif

                        @if($chamber->website)
                        <div class="inline-flex items-center gap-2 text-neutral-700 dark:text-gray-300">
                            <i data-lucide="globe" class="h-4 w-4 text-neutral-500 dark:text-gray-400"></i>
                            <a href="{{ $chamber->website }}" target="_blank"
                                class="text-[#073066] dark:text-blue-400 hover:underline">{{ str_replace(['http://',
                                'https://'], '', $chamber->website) }}</a>
                        </div>
                        @endif

                        @if(!$chamber->email && !$chamber->phone && !$chamber->address && !$chamber->website)
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <i data-lucide="info" class="h-8 w-8 mx-auto mb-2 text-gray-300 dark:text-gray-600"></i>
                            <p class="text-xs">Informations de contact non disponibles</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center gap-3 flex-wrap">
                        @if($chamber->address)
                        <button onclick="getDirections('{{ addslashes($chamber->address) }}')"
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:hover:bg-gray-700">
                            <i data-lucide="map" class="h-4 w-4"></i> Itinéraire
                        </button>
                        @endif

                        @if($chamber->verified)
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-xs text-green-800 dark:text-green-300">
                            <i data-lucide="shield-check" class="h-4 w-4"></i> Vérifiée
                        </div>
                        @endif

                        @if($chamber->state_number)
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs text-blue-800 dark:text-blue-300">
                            <i data-lucide="award" class="h-4 w-4"></i> Agréée
                        </div>
                        @endif
                    </div>
                </section>

                <section
                    class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
                    <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Informations
                        complémentaires</h3>
                    <div class="mt-3 space-y-3 text-sm text-neutral-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <i data-lucide="layers" class="h-4 w-4 text-neutral-500 dark:text-gray-400"></i>
                            <span class="font-medium">Type:</span>
                            <span class="ml-1">{{ $chamber->type === 'bilateral' ? 'Bilatérale' : 'Nationale' }}</span>
                        </div>
                        @if($chamber->type === 'bilateral' && $chamber->embassy_country)
                        <div class="flex items-center gap-2">
                            <i data-lucide="flag" class="h-4 w-4 text-neutral-500 dark:text-gray-400"></i>
                            <span class="font-medium">Pays:</span>
                            <span class="ml-1">{{ $chamber->embassy_country }}</span>
                        </div>
                        @endif
                        @if($chamber->type === 'bilateral' && $chamber->embassy_address)
                        <div class="flex items-start gap-2">
                            <i data-lucide="map-pin" class="h-4 w-4 text-neutral-500 dark:text-gray-400 mt-0.5"></i>
                            <div>
                                <div class="font-medium">Adresse de l'ambassade</div>
                                <div class="text-sm">{{ $chamber->embassy_address }}</div>
                                <div class="mt-2">
                                    <button onclick="getDirections('{{ addslashes($chamber->embassy_address) }}')"
                                        class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-2.5 py-1.5 text-xs font-medium hover:bg-neutral-50 dark:hover:bg-gray-700">
                                        <i data-lucide="map" class="h-3.5 w-3.5"></i>
                                        Itinéraire
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

                <section
                    class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
                    <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Suivez-nous</h3>
                    @if($chamber->social_links && count($chamber->social_links) > 0)
                    <div class="mt-3 flex items-center gap-2 flex-wrap">
                        @foreach($chamber->social_links as $platform => $url)
                        @if($url)
                        <a href="{{ $url }}" target="_blank"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 dark:border-gray-700 hover:bg-neutral-50 dark:hover:bg-gray-700 transition-colors"
                            aria-label="{{ ucfirst($platform) }}">
                            @if($platform === 'linkedin')
                            <i data-lucide="linkedin" class="h-5 w-5"></i>
                            @elseif($platform === 'twitter')
                            <i data-lucide="twitter" class="h-5 w-5"></i>
                            @elseif($platform === 'facebook')
                            <i data-lucide="facebook" class="h-5 w-5"></i>
                            @elseif($platform === 'instagram')
                            <i data-lucide="instagram" class="h-5 w-5"></i>
                            @elseif($platform === 'youtube')
                            <i data-lucide="youtube" class="h-5 w-5"></i>
                            @else
                            <i data-lucide="link" class="h-5 w-5"></i>
                            @endif
                        </a>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="mt-3 text-center py-4 text-gray-500 dark:text-gray-400">
                        <i data-lucide="link-2" class="h-8 w-8 mx-auto mb-2 text-gray-300 dark:text-gray-600"></i>
                        <p class="text-xs">Aucun lien social disponible</p>
                    </div>
                    @endif
                </section>

                <section
                    class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Entreprises
                            partenaires</h3>
                        <button onclick="switchChamberTab('partners')"
                            class="text-xs font-medium text-[#073066] dark:text-blue-400 hover:underline">Tous les
                            partenaires</button>
                    </div>
                    @if($chamber->partners->count() > 0)
                    <div class="mt-3 grid grid-cols-3 gap-3">
                        @foreach($chamber->partners->take(3) as $partner)
                        <div
                            class="rounded-lg border border-neutral-200 dark:border-gray-700 p-3 text-center hover:bg-neutral-50 dark:hover:bg-gray-700 transition-colors">
                            @if($partner->logo_path)
                            <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}"
                                class="mx-auto h-9 w-9 rounded-md object-cover">
                            @else
                            <span
                                class="mx-auto inline-flex h-9 w-9 items-center justify-center rounded-md bg-neutral-100 dark:bg-gray-700 text-neutral-900 dark:text-white text-xs font-semibold tracking-tight"
                                style="letter-spacing:-0.02em;">
                                {{ strtoupper(substr($partner->name, 0, 2)) }}
                            </span>
                            @endif
                            <div class="mt-1 text-xs">{{ $partner->name }}</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="mt-3 text-center py-6 text-gray-500 dark:text-gray-400">
                        <i data-lucide="handshake" class="h-8 w-8 mx-auto mb-2 text-gray-300 dark:text-gray-600"></i>
                        <p class="text-xs">Aucun partenaire enregistré</p>
                    </div>
                    @endif
                </section>
            </div>
        </div>
    </div>

    <!-- Events tab -->
    <div data-chamber-tab="events" class="hidden p-4 sm:p-6">
        @if($chamber->events->count() > 0)
        <div class="grid gap-5 sm:grid-cols-2">
            @foreach($chamber->events as $event)
            <article
                class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                {{-- <img
                    src="{{ $event->image_path ? asset('storage/' . $event->image_path) : 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1600&auto=format&fit=crop' }}"
                    class="h-40 w-full object-cover" alt="{{ $event->title }}"> --}}
                <div class="p-4">
                    <h4 class="text-base font-semibold tracking-tight" style="letter-spacing:-0.01em;">{{ $event->title
                        }}</h4>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">{{ $event->description ?: 'Aucune
                        description disponible.' }}</p>
                    <div class="mt-3 flex items-center gap-3 text-xs text-neutral-600 dark:text-gray-400">
                        @if($event->date)
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                            {{ $event->date->format('M j') }}
                        </span>
                        @endif
                        @if($event->time)
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                            {{ $event->time }}
                        </span>
                        @endif
                        @if($event->location)
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                            {{ $event->location }}
                        </span>
                        @endif
                        @if($event->type === 'online')
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="video" class="h-3.5 w-3.5"></i>
                            En ligne
                        </span>
                        @endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        @if(auth()->check())
                        @php($isBooked = $event->isBookedBy(auth()->user()))
                        @php($bookingStatus = $event->getBookingStatus(auth()->user()))
                        @if($isBooked)
                        <div class="flex items-center gap-2">
                            @if($bookingStatus === 'reserved')
                            <form action="{{ route('events.confirm', $event) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                    <i data-lucide="check" class="h-4 w-4"></i>
                                    Confirmer
                                </button>
                            </form>
                            @endif
                            @if($event->mode === 'online' && $event->lien_live && $bookingStatus === 'confirmed')
                            <a href="{{ $event->lien_live }}" target="_blank"
                                class="inline-flex items-center gap-2 rounded-md bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                                <i data-lucide="external-link" class="h-4 w-4"></i>
                                Rejoindre
                            </a>
                            @endif
                            <button type="button" onclick="openCancelModal({{ $event->id }}, '{{ $event->title }}')"
                                class="inline-flex items-center gap-2 rounded-md border border-orange-200 dark:border-orange-800 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                                <i data-lucide="x" class="h-4 w-4"></i>
                                Annuler
                            </button>
                            <form id="cancel-form-{{ $event->id }}" action="{{ route('events.cancel', $event) }}"
                                method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @else
                        @if($event->status === 'full')
                        <button disabled
                            class="inline-flex items-center gap-2 rounded-md bg-gray-400 px-3 py-2 text-sm font-medium text-white cursor-not-allowed">
                            <i data-lucide="users-x" class="h-4 w-4"></i>
                            Complet
                        </button>
                        @elseif($event->status !== 'cancelled')
                        <form action="{{ route('events.book', $event) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
                                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                                Réserver place
                            </button>
                        </form>
                        @endif
                        @endif
                        @else
                        <button onclick="openModal('signin-modal')"
                            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
                            <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                            Réserver place
                        </button>
                        @endif

                        <button onclick="viewEventDetails({{ $event->id }})"
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:hover:bg-gray-700">
                            <i data-lucide="eye" class="h-4 w-4"></i> Voir détails
                        </button>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium mb-2">Aucun événement disponible</h3>
            <p class="text-sm">Cette chambre n'a pas encore organisé d'événements.</p>
        </div>
        @endif
    </div>

    <!-- Members tab -->
    <div data-chamber-tab="members" class="hidden p-4 sm:p-6">
        @if($chamber->approvedMembers->count() > 0)
        <div
            class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
            <div class="border-b border-neutral-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between">
                <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Membres actifs ({{
                    $chamber->approvedMembers->count() }})</h3>
                <div class="relative">
                    <input type="text" id="members-search" placeholder="Rechercher des membres"
                        class="w-48 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-3 pr-9 py-1.5 text-xs focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    <span
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-neutral-400 dark:text-gray-400">
                        <i data-lucide="search" class="h-3.5 w-3.5"></i>
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-neutral-50 dark:bg-gray-700 text-neutral-600 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Membre</th>
                            <th class="px-4 py-2 text-left font-medium">Email</th>
                            <th class="px-4 py-2 text-left font-medium">Rôle</th>
                            <th class="px-4 py-2 text-left font-medium">Depuis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-gray-700" id="members-table-body">
                        @foreach($chamber->approvedMembers as $member)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-gray-700 member-row"
                            data-member-name="{{ strtolower($member->name) }}"
                            data-member-email="{{ strtolower($member->email) }}">
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=E71D36&color=fff"
                                        alt="{{ $member->name }}" class="h-8 w-8 rounded-full">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</div>
                                        @if($member->pivot->role === 'manager')
                                        <div class="text-xs text-orange-600 dark:text-orange-400">Gestionnaire</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <a href="mailto:{{ $member->email }}"
                                    class="text-[#073066] dark:text-blue-400 hover:underline">{{ $member->email }}</a>
                            </td>
                            <td class="px-4 py-2">
                                @if($member->pivot->role === 'manager')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                    <i data-lucide="crown" class="h-3 w-3 mr-1"></i>
                                    Gestionnaire
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                                    Membre
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                {{ $member->pivot->created_at ? $member->pivot->created_at->format('M Y') : 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                </path>
            </svg>
            <h3 class="text-lg font-medium mb-2">Aucun membre actif</h3>
            <p class="text-sm">Cette chambre n'a pas encore de membres approuvés.</p>
        </div>
        @endif
    </div>

    <!-- Partners tab -->
    <div data-chamber-tab="partners" class="hidden p-4 sm:p-6">
        @if($chamber->partners->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($chamber->partners as $partner)
            <div
                class="rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 text-center hover:bg-neutral-50 dark:hover:bg-gray-700 transition-colors">
                @if($partner->logo_path)
                <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}"
                    class="mx-auto h-10 w-10 rounded-md object-cover">
                @else
                <span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 dark:bg-gray-700 text-neutral-900 dark:text-white text-sm font-semibold tracking-tight"
                    style="letter-spacing:-0.02em;">
                    {{ strtoupper(substr($partner->name, 0, 2)) }}
                </span>
                @endif
                <div class="mt-2 text-sm">{{ $partner->name }}</div>
                @if($partner->website)
                <div class="mt-1">
                    <a href="{{ $partner->website }}" target="_blank"
                        class="text-xs text-[#073066] dark:text-blue-400 hover:underline">
                        Visiter le site
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6">
                </path>
            </svg>
            <h3 class="text-lg font-medium mb-2">Aucun partenaire disponible</h3>
            <p class="text-sm">Cette chambre n'a pas encore de partenaires enregistrés.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Chamber tabs
    function switchChamberTab(target) {
        document.querySelectorAll('[data-chamber-tab]').forEach(p => {
            p.classList.toggle('hidden', p.getAttribute('data-chamber-tab') !== target);
        });
        document.querySelectorAll('[data-chamber-link]').forEach(t => {
            const active = t.getAttribute('data-chamber-link') === target;
            t.classList.toggle('text-neutral-900 dark:text-white', active);
            t.classList.toggle('text-neutral-600 dark:text-gray-400', !active);
            t.querySelector('i')?.classList.toggle('text-[#073066] dark:text-blue-400', active);
        });
    }

    // Rejoindre une chambre
    function joinChamber(chamberSlug) {
        if (!document.querySelector('meta[name="csrf-token"]')) {
            showNotification('Erreur de sécurité. Veuillez recharger la page.', 'error');
            return;
        }
        if (!confirm('Voulez-vous vraiment rejoindre cette chambre ?')) {
            return;
        }

        const url = `${window.location.origin}/chambers/${encodeURIComponent(chamberSlug)}/join`;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(async (response) => {
            if (response.status === 401) {
                // non authentifié
                if (typeof openModal === 'function') openModal('signin-modal');
                return { success: false, message: 'Authentification requise.' };
            }
            let payload = {};
            try { payload = await response.json(); } catch (_) {}
            if (!response.ok) {
                throw new Error(payload.message || 'Erreur serveur');
            }
            return payload;
        })
        .then(data => {
            if (data && data.success) {
                showNotification('Demande d\'adhésion envoyée avec succès !', 'success');
                setTimeout(() => window.location.reload(), 1200);
            } else if (data && data.message) {
                showNotification(data.message, 'error');
            }
        })
        .catch(() => showNotification('Erreur lors de la demande d\'adhésion', 'error'));
    }

    // S'inscrire à un événement
    function registerForEvent(eventId) {
        if (!confirm('Voulez-vous vous inscrire à cet événement ?')) {
            return;
        }

        fetch(`/events/${eventId}/book`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Inscription à l\'événement réussie !', 'success');
            } else {
                showNotification(data.message || 'Erreur lors de l\'inscription', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'inscription à l\'événement', 'error');
        });
    }

    // Voir les détails d'un événement
    function viewEventDetails(eventId) {
        // Pour l'instant, on peut juste afficher une notification
        // Plus tard, tu peux rediriger vers une page de détails d'événement
        showNotification(`Détails de l'événement ${eventId} - Fonctionnalité à venir`, 'info');
    }

    // Obtenir des directions
    function getDirections(address) {
        const encodedAddress = encodeURIComponent(address);
        const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`;
        window.open(googleMapsUrl, '_blank');
    }

    // Recherche de membres
    document.addEventListener('DOMContentLoaded', function() {
        const membersSearch = document.getElementById('members-search');
        if (membersSearch) {
            membersSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const memberRows = document.querySelectorAll('.member-row');

                memberRows.forEach(row => {
                    const memberName = row.dataset.memberName;
                    const memberEmail = row.dataset.memberEmail;
                    const shouldShow = searchTerm === '' ||
                                     memberName.includes(searchTerm) ||
                                     memberEmail.includes(searchTerm);

                    row.style.display = shouldShow ? '' : 'none';
                });
            });
        }

        // Initialiser les icônes Lucide
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Fonction pour afficher des notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full max-w-sm`;

        if (type === 'success') {
            notification.classList.add('bg-green-600');
        } else if (type === 'error') {
            notification.classList.add('bg-red-600');
        } else {
            notification.classList.add('bg-blue-600');
        }

        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info'}" class="h-5 w-5"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:opacity-75">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animer l'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Supprimer après 5 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 5000);

        // Réinitialiser les icônes Lucide
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
</script>
@endpush
<!-- Modal pour les détails d'événement -->
<div id="event-details-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeEventDetailsModal()"></div>
        <div class="relative w-full max-w-2xl transform rounded-xl bg-white dark:bg-gray-800 shadow-xl transition-all">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Détails de l'événement</h3>
                <button onclick="closeEventDetailsModal()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="h-6 w-6"></i>
                </button>
            </div>
            <div id="event-details-content" class="p-6">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation d'annulation -->
<div id="cancel-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeCancelModal()"></div>
        <div class="relative w-full max-w-md transform rounded-xl bg-white dark:bg-gray-800 shadow-xl transition-all">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="h-5 w-5 text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Annuler la réservation</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Cette action est irréversible.</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    Êtes-vous sûr de vouloir annuler votre réservation pour "<span id="cancel-event-title"
                        class="font-medium"></span>" ?
                </p>
                <div class="flex gap-3 justify-end">
                    <button onclick="closeCancelModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Annuler
                    </button>
                    <button id="confirm-cancel-btn" onclick="confirmCancel()"
                        class="px-4 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-md">
                        Confirmer l'annulation
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentEventId = null;

// Fonction pour ouvrir les détails d'un événement
function viewEventDetails(eventId) {
    currentEventId = eventId;

    // Afficher le modal avec un loader
    document.getElementById('event-details-modal').classList.remove('hidden');
    document.getElementById('event-details-content').innerHTML = `
        <div class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#073066]"></div>
            <span class="ml-3 text-gray-600 dark:text-gray-400">Chargement...</span>
        </div>
    `;

    // Charger les détails via AJAX
    fetch(`/api/events/${eventId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayEventDetails(data.event);
            } else {
                document.getElementById('event-details-content').innerHTML = `
                    <div class="text-center py-8">
                        <i data-lucide="alert-circle" class="h-12 w-12 mx-auto mb-4 text-red-500"></i>
                        <p class="text-red-600 dark:text-red-400">Erreur lors du chargement des détails</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('event-details-content').innerHTML = `
                <div class="text-center py-8">
                    <i data-lucide="wifi-off" class="h-12 w-12 mx-auto mb-4 text-gray-400"></i>
                    <p class="text-gray-600 dark:text-gray-400">Erreur de connexion</p>
                </div>
            `;
        });
}

// Fonction pour afficher les détails de l'événement
function displayEventDetails(event) {
    const isBooked = event.is_booked;
    const bookingStatus = event.booking_status;

    const content = `
        <div class="space-y-6">
            <!-- Image de couverture -->
            ${event.cover_image_path ? `
                <img src="/storage/${event.cover_image_path}" alt="${event.title}"
                     class="w-full h-48 object-cover rounded-lg">
            ` : `
                <div class="w-full h-48 bg-gradient-to-br from-[#073066] to-[#052347] rounded-lg flex items-center justify-center">
                    <div class="text-center text-white">
                        <i data-lucide="${getEventIcon(event.type)}" class="h-16 w-16 mx-auto mb-2"></i>
                        <p class="text-lg font-medium">${event.type.charAt(0).toUpperCase() + event.type.slice(1)}</p>
                    </div>
                </div>
            `}

            <!-- Titre et statut -->
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">${event.title}</h2>
                    <div class="flex items-center gap-2">
                        ${event.chamber.verified ? `
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                <i data-lucide="shield-check" class="h-3 w-3"></i>
                                Chambre agréée
                            </span>
                        ` : ''}
                        ${event.status === 'full' ? `
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">
                                <i data-lucide="users-x" class="h-3 w-3"></i>
                                Complet
                            </span>
                        ` : ''}
                        ${isBooked ? `
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                <i data-lucide="check-circle" class="h-3 w-3"></i>
                                ${bookingStatus === 'confirmed' ? 'Confirmé' : 'Réservé'}
                            </span>
                        ` : ''}
                    </div>
                </div>
            </div>

            <!-- Informations principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <i data-lucide="calendar" class="h-4 w-4 text-gray-500"></i>
                        <span class="text-gray-900 dark:text-white font-medium">${formatDate(event.date)}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i data-lucide="clock" class="h-4 w-4 text-gray-500"></i>
                        <span class="text-gray-900 dark:text-white">${event.time}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i data-lucide="${event.mode === 'online' ? 'monitor' : 'map-pin'}" class="h-4 w-4 text-gray-500"></i>
                        <span class="text-gray-900 dark:text-white">
                            ${event.mode === 'online' ? 'En ligne' : `${event.city}, ${event.country}`}
                        </span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <i data-lucide="users" class="h-4 w-4 text-gray-500"></i>
                        <span class="text-gray-900 dark:text-white">
                            ${event.participants_count}${event.max_participants ? `/${event.max_participants}` : ''} participants
                        </span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i data-lucide="tag" class="h-4 w-4 text-gray-500"></i>
                        <span class="text-gray-900 dark:text-white">${event.type.charAt(0).toUpperCase() + event.type.slice(1)}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <i data-lucide="building" class="h-4 w-4 text-gray-500"></i>
                        <span class="text-gray-900 dark:text-white">${event.chamber.name}</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            ${event.description ? `
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">${event.description}</p>
                </div>
            ` : ''}

            <!-- Adresse complète si présentiel -->
            ${event.mode !== 'online' && event.address ? `
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Adresse</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">${event.address}</p>
                </div>
            ` : ''}

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                ${generateEventActions(event, isBooked, bookingStatus)}
            </div>
        </div>
    `;

    document.getElementById('event-details-content').innerHTML = content;

    // Réinitialiser les icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// Fonction pour générer les actions selon le statut
function generateEventActions(event, isBooked, bookingStatus) {
    if (!event.is_authenticated) {
        return `
            <button onclick="openModal('signin-modal')"
                class="flex-1 inline-flex items-center justify-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                Réserver une place
            </button>
        `;
    }

    if (isBooked) {
        let actions = '';

        if (bookingStatus === 'reserved') {
            actions += `
                <form action="/events/${event.id}/confirm" method="POST" class="flex-1">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                    <input type="hidden" name="_method" value="PATCH">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                        <i data-lucide="check" class="h-4 w-4"></i>
                        Confirmer participation
                    </button>
                </form>
            `;
        }

        if (event.mode === 'online' && event.lien_live && bookingStatus === 'confirmed') {
            actions += `
                <a href="${event.lien_live}" target="_blank"
                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-md bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                    <i data-lucide="external-link" class="h-4 w-4"></i>
                    Rejoindre l'événement
                </a>
            `;
        }

        actions += `
            <button onclick="openCancelModal(${event.id}, '${event.title}')"
                class="inline-flex items-center justify-center gap-2 rounded-md border border-orange-200 dark:border-orange-800 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                <i data-lucide="x" class="h-4 w-4"></i>
                Annuler réservation
            </button>
        `;

        return actions;
    } else {
        if (event.status === 'full') {
            return `
                <button disabled
                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-md bg-gray-400 px-4 py-2.5 text-sm font-medium text-white cursor-not-allowed">
                    <i data-lucide="users-x" class="h-4 w-4"></i>
                    Événement complet
                </button>
            `;
        } else {
            return `
                <form action="/events/${event.id}/book" method="POST" class="flex-1">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#052347] transition-colors">
                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                        Réserver une place
                    </button>
                </form>
            `;
        }
    }
}

// Fonction pour fermer le modal des détails
function closeEventDetailsModal() {
    document.getElementById('event-details-modal').classList.add('hidden');
    currentEventId = null;
}

// Fonction pour ouvrir le modal d'annulation
function openCancelModal(eventId, eventTitle) {
    currentEventId = eventId;
    document.getElementById('cancel-event-title').textContent = eventTitle;
    document.getElementById('cancel-modal').classList.remove('hidden');
}

// Fonction pour fermer le modal d'annulation
function closeCancelModal() {
    document.getElementById('cancel-modal').classList.add('hidden');
    currentEventId = null;
}

// Fonction pour confirmer l'annulation
function confirmCancel() {
    if (currentEventId) {
        document.getElementById(`cancel-form-${currentEventId}`).submit();
    }
}

// Fonctions utilitaires
function getEventIcon(type) {
    const icons = {
        'forum': 'users',
        'networking': 'network',
        'conference': 'presentation',
        'meeting': 'calendar',
        'autres': 'calendar-check'
    };
    return icons[type] || 'calendar-check';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    return date.toLocaleDateString('fr-FR', options);
}

// Fonction pour rejoindre une chambre
function joinChamber(chamberId) {
    if (!document.querySelector('meta[name="csrf-token"]')) {
        alert('Erreur de sécurité. Veuillez recharger la page.');
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;

    // Désactiver le bouton et afficher un loader
    button.disabled = true;
    button.innerHTML = '<i data-lucide="loader-2" class="h-4 w-4 animate-spin"></i> Traitement...';

    fetch(`/chambers/${chamberId}/join`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recharger la page pour mettre à jour l'interface
            window.location.reload();
        } else {
            alert(data.message || 'Erreur lors de l\'adhésion');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur de connexion');
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// Fonction pour obtenir des directions
function getDirections(address) {
    const encodedAddress = encodeURIComponent(address);
    const url = `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`;
    window.open(url, '_blank');
}

// Fonction pour changer d'onglet
function switchChamberTab(tabName) {
    // Masquer tous les onglets
    document.querySelectorAll('[data-chamber-tab]').forEach(tab => {
        tab.classList.add('hidden');
    });

    // Afficher l'onglet sélectionné
    const targetTab = document.querySelector(`[data-chamber-tab="${tabName}"]`);
    if (targetTab) {
        targetTab.classList.remove('hidden');
    }

    // Mettre à jour les liens de navigation
    document.querySelectorAll('.cham-link').forEach(link => {
        link.classList.remove('active');
        link.classList.add('text-neutral-600', 'dark:text-gray-400');
        link.classList.remove('text-neutral-900', 'dark:text-white');
    });

    const activeLink = document.querySelector(`[data-chamber-link="${tabName}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
        activeLink.classList.remove('text-neutral-600', 'dark:text-gray-400');
        activeLink.classList.add('text-neutral-900', 'dark:text-white');
    }
}

// Fonction de recherche des membres
document.addEventListener('DOMContentLoaded', function() {
    const membersSearch = document.getElementById('members-search');
    if (membersSearch) {
        membersSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const memberRows = document.querySelectorAll('.member-row');

            memberRows.forEach(row => {
                const memberName = row.getAttribute('data-member-name') || '';
                const memberEmail = row.getAttribute('data-member-email') || '';

                if (memberName.includes(searchTerm) || memberEmail.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

// Fermer les modals avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventDetailsModal();
        closeCancelModal();
    }
});
</script>

@endsection
