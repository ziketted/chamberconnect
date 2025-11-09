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
                    @if(Auth::user()->isSuperAdmin())
                        <span class="inline-flex items-center rounded-md bg-[#b81010]/10 px-2 py-1 text-xs font-medium text-[#b81010]">
                            <i data-lucide="shield" class="mr-1 h-3 w-3"></i>
                            Super Admin
                        </span>
                        <span class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Accès global aux chambres
                        </span>
                    @elseif(Auth::user()->isChamberManager())
                        <span class="inline-flex items-center rounded-md bg-[#fcb357]/10 px-2 py-1 text-xs font-medium text-[#fcb357]">
                            <i data-lucide="briefcase" class="mr-1 h-3 w-3"></i>
                            Gestionnaire de chambre
                        </span>
                        <span class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Gestion des chambres assignées
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-800">
                            <i data-lucide="user" class="mr-1 h-3 w-3"></i>
                            Utilisateur
                        </span>
                        <span class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            Membre des chambres
                        </span>
                    @endif
                </div>
                
                <!-- Debug Info (temporaire) -->
                <div class="mt-2 p-2 bg-gray-100 rounded text-xs">
                    <strong>Debug:</strong> is_admin = {{ Auth::user()->is_admin ?? 'null' }}
                </div>
                
                @if(Auth::user()->isSuperAdmin())
                <div class="mt-4 flex flex-col gap-2">
                    @if(Route::has('admin.dashboard'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                            <i data-lucide="shield-check" class="h-4 w-4"></i> 
                            Administration
                        </a>
                    @endif
                    @if(Route::has('chambers.create'))
                        <a href="{{ route('chambers.create') }}"
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 text-sm font-medium hover:bg-neutral-50">
                            <i data-lucide="plus" class="h-4 w-4"></i> 
                            Créer une chambre
                        </a>
                    @endif
                </div>
                @elseif(Auth::user()->isChamberManager())
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('chamber-manager.dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-[#fcb357] px-3 py-2 text-sm font-semibold text-white hover:bg-[#f5a742]">
                        <i data-lucide="briefcase" class="h-4 w-4"></i> 
                        Tableau de bord gestionnaire
                    </a>
                </div>
                @else
                <div class="mt-4 flex flex-col gap-2">
                    <div class="text-sm text-gray-600">
                        Connectez-vous avec un compte administrateur pour accéder aux fonctions de gestion.
                    </div>
                    <div class="text-xs text-gray-500">
                        Test: admin@chamberconnect.cd / admin123
                    </div>
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
                                        <i data-lucide="check" class="h-3 w-3 text-[#073066]"></i>
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
                    @forelse($popular_chambers as $chamber)
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $chamber->logo_path ?? 'https://ui-avatars.com/api/?name=' . urlencode($chamber->name) . '&background=E71D36&color=fff' }}"
                                alt="{{ $chamber->name }}" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">{{ $chamber->name }}</div>
                                <div class="text-xs text-neutral-500">{{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}</div>
                            </div>
                        </div>
                        @if($chamber->verified)
                            <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                                Vérifiée
                            </span>
                        @else
                            <button class="rounded-md border border-neutral-200 px-3 py-1 text-xs font-medium hover:bg-neutral-50">
                                Suivre
                            </button>
                        @endif
                    </div>
                    @empty
                    <div class="p-4 text-center text-sm text-gray-500">
                        Aucune chambre disponible
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:col-span-9 space-y-6">
        @if(!auth()->user()->isSuperAdmin())
        <!-- Create Post -->
        <div class="rounded-xl border border-neutral-200 bg-white p-4">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=User" alt="" class="h-10 w-10 rounded-full object-cover">
                <div class="flex-1">
                    <input type="text" placeholder="Annoncer un forum, atelier, participation..."
                        class="w-full rounded-md border border-neutral-200 bg-neutral-50 px-4 py-2 text-sm placeholder:text-neutral-500 focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20">
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
        @endif

        <!-- Chambres Feed -->
        <div class="space-y-4">
            @forelse($chambers as $chamber)
            <article class="rounded-xl border border-neutral-200 bg-white">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $chamber->logo_path ?? 'https://ui-avatars.com/api/?name=' . urlencode($chamber->name) . '&background=E71D36&color=fff' }}"
                                alt="{{ $chamber->name }}" class="h-10 w-10 rounded-lg object-cover">
                            <div>
                                <div class="text-sm font-medium">{{ $chamber->name }}</div>
                                <div class="text-xs text-neutral-500">{{ $chamber->location ?? 'Localisation non définie' }}</div>
                            </div>
                        </div>
                        @if(auth()->user()->isSuperAdmin())
                            @if($chamber->verified && $chamber->state_number)
                                <!-- Chambre agréée avec numéro d'état -->
                                <div class="flex flex-col items-end gap-1">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800">
                                        <i data-lucide="check-circle" class="h-3 w-3"></i>
                                        Agréée
                                    </span>
                                    <span class="text-xs text-gray-600">N° État: {{ $chamber->state_number }}</span>
                                </div>
                            @else
                                <!-- Chambre non agréée - bouton pour ouvrir le modal -->
                                <button type="button" onclick="openCertificationModal('{{ $chamber->slug }}')" 
                                    class="inline-flex items-center gap-1.5 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-medium text-orange-800 hover:bg-orange-200">
                                    <i data-lucide="shield-check" class="h-3 w-3"></i>
                                    Agréer la chambre
                                </button>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#073066]/10 px-2.5 py-1 text-xs font-medium text-[#073066]">
                                Chambre
                            </span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <h3 class="text-base font-semibold">{{ $chamber->name }}</h3>
                        <p class="mt-1 text-sm text-neutral-600">{{ $chamber->description ?? 'Description non disponible' }}</p>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        @if($chamber->verified)
                            <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                                Vérifiée
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-md bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700">
                                <i data-lucide="clock" class="mr-1 h-3 w-3"></i>
                                En attente
                            </span>
                        @endif
                        
                        @if($chamber->location)
                            <span class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                                <i data-lucide="map-pin" class="mr-1 h-3 w-3"></i>
                                {{ $chamber->location }}
                            </span>
                        @endif
                        
                        <span class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700">
                            <i data-lucide="users" class="mr-1 h-3 w-3"></i>
                            {{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}
                        </span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        @if(auth()->user()->isSuperAdmin())
                            <button class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                <i data-lucide="user-plus" class="h-4 w-4"></i>
                                Ajouter un gestionnaire
                            </button>
                            <span class="inline-flex items-center gap-2 rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                {{ $chamber->members_count }} {{ $chamber->members_count > 1 ? 'membres' : 'membre' }}
                            </span>
                        @else
                            <button class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                                S'inscrire
                            </button>
                        @endif
                        <a href="{{ route('chamber.show', $chamber) }}" 
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 text-sm font-medium hover:bg-neutral-50">
                            Voir la chambre
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="rounded-xl border border-neutral-200 bg-white p-8 text-center">
                <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i data-lucide="building" class="h-6 w-6 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune chambre trouvée</h3>
                <p class="text-sm text-gray-500 mb-4">Il n'y a pas encore de chambres de commerce enregistrées.</p>
                @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('chambers.create') }}" 
                        class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Créer la première chambre
                    </a>
                @endif
            </div>
            @endforelse
        </div>
    </main>
</div>

<!-- Modal d'agrément pour super admin -->
@if(auth()->user()->isSuperAdmin())
<div id="certificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="certificationForm" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="shield-check" class="h-6 w-6 text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Agréer la chambre
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="state_number" class="block text-sm font-medium text-gray-700">
                                        Numéro d'état officiel
                                    </label>
                                    <input type="text" name="state_number" id="state_number" required
                                        placeholder="Ex: CCI-DK-2024-002"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#073066] focus:ring-[#073066] sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Format recommandé: CCI-[VILLE]-[ANNÉE]-[NUMÉRO]</p>
                                </div>
                                
                                <div>
                                    <label for="certification_date" class="block text-sm font-medium text-gray-700">
                                        Date d'agrément
                                    </label>
                                    <input type="date" name="certification_date" id="certification_date" required
                                        value="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#073066] focus:ring-[#073066] sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">
                                        Notes (optionnel)
                                    </label>
                                    <textarea name="notes" id="notes" rows="3"
                                        placeholder="Commentaires sur l'agrément..."
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#073066] focus:ring-[#073066] sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                        Agréer la chambre
                    </button>
                    <button type="button" onclick="closeCertificationModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

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

    // Fonctions pour le modal d'agrément
    window.openCertificationModal = function(chamberSlug) {
        console.log('Opening modal for:', chamberSlug);
        const modal = document.getElementById('certificationModal');
        const form = document.getElementById('certificationForm');
        
        if (!modal || !form) {
            console.error('Modal ou formulaire non trouvé');
            return;
        }
        
        // Définir l'action du formulaire avec le slug de la chambre
        form.action = `/admin/chambers/${chamberSlug}/certify`;
        
        // Générer un numéro d'état suggéré basé sur le slug
        const currentYear = new Date().getFullYear();
        let suggestedNumber = '';
        
        if (chamberSlug.includes('abidjan')) {
            suggestedNumber = `CCI-AB-${currentYear}-001`;
        } else if (chamberSlug.includes('dakar')) {
            suggestedNumber = `CCI-DK-${currentYear}-002`;
        } else if (chamberSlug.includes('paris')) {
            suggestedNumber = `CCI-PA-${currentYear}-003`;
        } else {
            // Générer un numéro générique
            const randomNum = Math.floor(Math.random() * 999) + 1;
            suggestedNumber = `CCI-XX-${currentYear}-${randomNum.toString().padStart(3, '0')}`;
        }
        
        document.getElementById('state_number').value = suggestedNumber;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCertificationModal() {
        const modal = document.getElementById('certificationModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Réinitialiser le formulaire
        document.getElementById('certificationForm').reset();
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('certificationModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCertificationModal();
        }
    });
</script>
@endpush
@endsection
