@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Rôle -->
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <h2 class="text-sm font-semibold">Mon rôle</h2>
                <p class="mt-1 text-xs text-neutral-600">Contrôlez la portée et les actions.</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <span
                        class="inline-flex items-center rounded-md bg-[#E71D36]/10 px-2 py-1 text-xs font-medium text-[#E71D36]">
                        Super admin
                    </span>
                    <span
                        class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                        Accès global aux chambres
                    </span>
                </div>
                @if(Auth::user()->is_admin ?? false)
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('chambers.create') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]"><i
                            data-lucide="plus" class="h-4 w-4"></i> Créer une chambre</a>
                    <a href="{{ route('admin.chambers.admins') }}"
                        class="inline-flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 text-sm font-medium hover:bg-neutral-50"><i
                            data-lucide="users" class="h-4 w-4"></i> Gérer les administrateurs</a>
                </div>
                @endif
            </div>

            <!-- Filtres -->
            <div class="rounded-xl border border-neutral-200 bg-white">
                <div class="border-b border-neutral-200 p-4">
                    <h2 class="text-sm font-semibold">Filtres</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <!-- Type d'activité -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Type d'activité</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-900 hover:bg-neutral-200">Forum</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Atelier</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Participation</button>
                            </div>
                        </div>

                        <!-- Période -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700">Période</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-900 hover:bg-neutral-200">Cette
                                    semaine</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Ce
                                    mois</button>
                                <button
                                    class="inline-flex items-center rounded-md bg-neutral-100 px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-200">Trimestre</button>
                            </div>
                        </div>

                        <!-- Chambres vérifiées -->
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-medium text-neutral-700">Afficher uniquement "vérifiées"</label>
                            <button type="button"
                                class="relative inline-flex h-5 w-9 flex-shrink-0 rounded-full border-2 border-transparent bg-neutral-200"
                                role="switch" aria-checked="false">
                                <span
                                    class="translate-x-0 pointer-events-none relative inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                                    <span
                                        class="opacity-0 duration-100 ease-out absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                        aria-hidden="true">
                                        <i data-lucide="check" class="h-3 w-3 text-[#E71D36]"></i>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chambres populaires -->
            <div class="rounded-xl border border-neutral-200 bg-white">
                <div class="border-b border-neutral-200 p-4">
                    <h2 class="text-sm font-semibold">Chambres populaires</h2>
                </div>
                <div class="divide-y divide-neutral-200">
                    <!-- CCI Abidjan -->
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1550948390-6eb7fa773072?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">CCI Abidjan</div>
                                <div class="text-xs text-neutral-500">12 forums à venir</div>
                            </div>
                        </div>
                        <button
                            class="rounded-md border border-neutral-200 px-3 py-1 text-xs font-medium hover:bg-neutral-50">Suivre</button>
                    </div>

                    <!-- Chambre de Dakar -->
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">Chambre de Dakar</div>
                                <div class="text-xs text-neutral-500">8 forums à venir</div>
                            </div>
                        </div>
                        <button
                            class="rounded-md border border-neutral-200 px-3 py-1 text-xs font-medium hover:bg-neutral-50">Suivre</button>
                    </div>

                    <!-- CCI Paris -->
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">CCI Paris</div>
                                <div class="text-xs text-neutral-500">5 forums à venir</div>
                            </div>
                        </div>
                        <button
                            class="rounded-md border border-neutral-200 px-3 py-1 text-xs font-medium hover:bg-neutral-50">Suivre</button>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:col-span-9 space-y-6">
        <!-- Create Post -->
        <div class="rounded-xl border border-neutral-200 bg-white p-4">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=User" alt="" class="h-10 w-10 rounded-full object-cover">
                <div class="flex-1">
                    <input type="text" placeholder="Annoncer un forum, atelier, participation..."
                        class="w-full rounded-md border border-neutral-200 bg-neutral-50 px-4 py-2 text-sm placeholder:text-neutral-500 focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button
                    class="inline-flex items-center gap-2 rounded-md bg-neutral-100 px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-neutral-200">
                    <i data-lucide="message-square" class="h-4 w-4"></i>
                    Forum
                </button>
                <button
                    class="inline-flex items-center gap-2 rounded-md bg-neutral-100 px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-neutral-200">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    Atelier
                </button>
                <button
                    class="inline-flex items-center gap-2 rounded-md bg-neutral-100 px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-neutral-200">
                    <i data-lucide="calendar" class="h-4 w-4"></i>
                    Participation
                </button>
            </div>
        </div>

        <!-- Events Feed -->
        <div class="space-y-4">
            <!-- Event 1 -->
            <article class="rounded-xl border border-neutral-200 bg-white">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1550948390-6eb7fa773072?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">Chambre de Commerce d'Abidjan</div>
                                <div class="text-xs text-neutral-500">16 octobre • 10:00 GMT</div>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#E71D36]/10 px-2.5 py-1 text-xs font-medium text-[#E71D36]">
                            Forum
                        </span>
                    </div>

                    <div class="mt-3">
                        <h3 class="text-base font-semibold">Forum régional sur les opportunités d'exportation et les
                            partenariats public-privé</h3>
                        <p class="mt-1 text-sm text-neutral-600">Interventions des ministères, incubateurs et
                            entreprises.</p>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Export
                        </span>
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            PPP
                        </span>
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Régional
                        </span>
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            <i data-lucide="users" class="mr-1 h-3 w-3"></i>
                            Tous les membres
                        </span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button
                            class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]">
                            S'inscrire
                        </button>
                        <button
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 text-sm font-medium hover:bg-neutral-50">
                            Partager
                        </button>
                    </div>
                </div>
            </article>

            <!-- Event 2 -->
            <article class="rounded-xl border border-neutral-200 bg-white">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">Chambre de Commerce de Dakar</div>
                                <div class="text-xs text-neutral-500">20 octobre • 14:00 GMT</div>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#E71D36]/10 px-2.5 py-1 text-xs font-medium text-[#E71D36]">
                            Forum
                        </span>
                    </div>

                    <div class="mt-3">
                        <h3 class="text-base font-semibold">Forum sur l'industrialisation, la logistique portuaire et
                            les zones économiques spéciales</h3>
                        <p class="mt-1 text-sm text-neutral-600">Networking B2B & B2G.</p>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Industrie
                        </span>
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Logistique
                        </span>
                        <span
                            class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            <i data-lucide="users" class="mr-1 h-3 w-3"></i>
                            Tous les membres
                        </span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button
                            class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]">
                            S'inscrire
                        </button>
                        <button
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 text-sm font-medium hover:bg-neutral-50">
                            Partager
                        </button>
                    </div>
                </div>
            </article>
        </div>
    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialiser les icônes Lucide
        lucide.createIcons({
            attrs: {
                'stroke-width': 1.5
            }
        });
    });
</script>
@endpush
@endsection
