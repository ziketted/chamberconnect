@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar (static hints/filters only) -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <h2 class="text-sm font-semibold">Mon rôle</h2>
                <p class="mt-1 text-xs text-neutral-600">Contrôlez la portée et les actions.</p>
                <div class="mt-3">
                    <span
                        class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700">Super
                        admin</span>
                </div>
                <div class="mt-2"><span class="text-xs text-neutral-600">Accès global aux chambres</span></div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white">
                <div class="border-b border-neutral-200 p-4">
                    <h2 class="text-sm font-semibold">Filtres</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Type d'activité</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button
                                    class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1.5 text-xs font-medium text-amber-800">Forum</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700">Atelier</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700">Participation</button>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Période</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-900">Cette
                                    semaine</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700">Ce
                                    mois</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700">Trimestre</button>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Localisation</label>
                            <div class="mt-2">
                                <select
                                    class="w-full rounded-md border border-neutral-200 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
                                    <option value="">Toutes les régions</option>
                                    <option value="afrique">Afrique</option>
                                    <option value="europe">Europe</option>
                                    <option value="amerique">Amérique</option>
                                    <option value="asie">Asie</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-medium text-neutral-700">Afficher uniquement "vérifiées"</label>
                            <button type="button"
                                class="relative inline-flex h-5 w-9 flex-shrink-0 rounded-full border-2 border-transparent bg-neutral-200"><span
                                    class="translate-x-0 pointer-events-none relative inline-block h-4 w-4 transform rounded-full bg-white shadow"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:col-span-9 space-y-6">
        <div class="space-y-4">
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </span>
                <input type="text" placeholder="Rechercher une chambre par nom, pays ou secteur d'activité..."
                    class="w-full rounded-xl border border-neutral-200 bg-white pl-10 pr-4 py-3 text-sm text-neutral-800 placeholder:text-neutral-400 shadow-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-neutral-700">Filtres rapides:</span>
                <button
                    class="inline-flex items-center rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Les
                    plus actives</button>
                <button
                    class="inline-flex items-center rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Récemment
                    créées</button>
                <button
                    class="inline-flex items-center rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Événements
                    à venir</button>
            </div>
        </div>

        <!-- Static illustrated chambers (API will hydrate later) -->
        <div class="space-y-4" id="chambers-list">
            @php($cards = [
            ['code' => 'CH CD', 'name' => 'Chambre Suisse — RDC', 'desc' => 'Plateforme de coopération économique entre
            la Suisse et la République', 'members' => 1842, 'events' => 5, 'verified' => true],
            ['code' => 'FR MA', 'name' => 'Chambre France — Maroc', 'desc' => 'Réseau d\'affaires franco-marocain,
            promotion des échanges et partenariats', 'members' => 2310, 'events' => 3, 'verified' => true],
            ['code' => 'CA CI', 'name' => 'Chambre Canada — Côte d\'Ivoire', 'desc' => 'Connecter les entreprises
            canadiennes et ivoiriennes autour d\'opportunités', 'members' => 1154, 'events' => 2, 'verified' => false],
            ['code' => 'BE CM', 'name' => 'Chambre Belgique — Cameroun', 'desc' => 'Faciliter les échanges
            belgo-camerounais et l\'accès aux marchés.', 'members' => 987, 'events' => 4, 'verified' => true],
            ])
            @foreach($cards as $c)
            <div
                class="group rounded-xl border border-neutral-200 bg-white p-6 hover:shadow-sm transition-all duration-200">
                <div class="flex items-start gap-6">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="relative">
                            <div
                                class="relative flex h-14 w-14 items-center justify-center rounded-lg bg-gradient-to-br from-[#E71D36] to-[#cf1a30] text-white shadow-sm">
                                <div class="flex flex-col items-center text-sm font-semibold leading-none">
                                    <span>{{ substr($c['code'], 0, 2) }}</span>
                                    <span class="mt-0.5 text-white/80">{{ substr($c['code'], -2) }}</span>
                                </div>
                            </div>
                            @if($c['verified'])
                            <div class="absolute -right-1 -top-1 rounded-full bg-white p-0.5 shadow-sm">
                                <div
                                    class="flex h-5 w-5 items-center justify-center rounded-full bg-blue-500 text-white">
                                    <i data-lucide="shield-check" class="h-3 w-3"></i>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-base font-medium">{{ $c['name'] }}</h3>
                                @if($c['verified'])
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700"><i
                                        data-lucide="shield-check" class="h-3.5 w-3.5"></i> Certified</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-neutral-600">{{ $c['desc'] }}</p>
                            <div class="mt-3 flex items-center flex-wrap gap-4">
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600"><i
                                            data-lucide="users" class="h-4 w-4 text-neutral-400"></i> {{
                                        number_format($c['members']) }} membres</span>
                                    <span class="inline-flex items-center gap-1.5 text-sm text-neutral-600"><i
                                            data-lucide="calendar" class="h-4 w-4 text-neutral-400"></i> {{ $c['events']
                                        }} événements</span>
                                </div>
                                @if($c['events'] > 0)
                                <div
                                    class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-800">
                                    <i data-lucide="calendar-clock" class="h-3.5 w-3.5"></i> Forum Export • 12 Nov
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/chamber/kinshasa"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-neutral-100 text-neutral-600 hover:bg-neutral-200 transition-colors"><i
                                data-lucide="layout-grid" class="h-4 w-4"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
    });
</script>
@endpush
@endsection
