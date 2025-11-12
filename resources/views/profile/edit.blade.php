@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Photo de profil -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <div class="flex flex-col items-center text-center">
                    <div class="relative">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                            alt="{{ Auth::user()->name }}" class="h-24 w-24 rounded-xl object-cover">
                        <button
                            class="absolute bottom-0 right-0 rounded-full bg-white dark:bg-gray-800 p-1 shadow-sm hover:bg-neutral-50 dark:bg-gray-700">
                            <i data-lucide="camera" class="h-4 w-4 text-neutral-600 dark:text-gray-400"></i>
                        </button>
                    </div>
                    <h2 class="mt-4 text-base font-semibold">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-neutral-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">Paramètres du compte</h3>
                </div>
                <div class="divide-y divide-neutral-200 dark:divide-gray-700">
                    <a href="#profile-info"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-50 dark:hover:bg-gray-700">
                        <i data-lucide="user" class="h-5 w-5 text-neutral-400 dark:text-gray-400"></i>
                        Informations personnelles
                    </a>
                    <a href="#security"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-neutral-900 dark:text-white hover:bg-neutral-50 dark:hover:bg-gray-700">
                        <i data-lucide="shield" class="h-5 w-5 text-neutral-400 dark:text-gray-400"></i>
                        Sécurité
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-200 transition-colors">
                            <i data-lucide="log-out" class="h-5 w-5"></i>
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:col-span-9 space-y-6">
        <!-- Informations personnelles -->
        <section id="profile-info" class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
            <div class="border-b border-neutral-200 dark:border-gray-700 px-6 py-4">
                <h3 class="text-base font-semibold text-neutral-900 dark:text-white">Informations personnelles</h3>
                <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">Mettez à jour vos informations personnelles.</p>
            </div>
            <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-6">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Nom complet</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Adresse email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Numéro de
                            téléphone</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                    </div>

                    <!-- Entreprise -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Entreprise</label>
                        <input type="text" name="company" id="company"
                            value="{{ old('company', Auth::user()->company ?? '') }}"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-neutral-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500/50">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Enregistrer les modifications
                    </button>

                    @if (session('status') === 'profile-updated')
                    <p class="text-sm text-emerald-600">Enregistré.</p>
                    @endif
                </div>
            </form>
        </section>

        <!-- Sécurité -->
        <section id="security" class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
            <div class="border-b border-neutral-200 dark:border-gray-700 px-6 py-4">
                <h3 class="text-base font-semibold text-neutral-900 dark:text-white">Sécurité</h3>
                <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">Mettez à jour votre mot de passe pour sécuriser votre compte.
                </p>
            </div>
            <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-6">
                @csrf
                @method('put')

                <div class="space-y-4">
                    <!-- Mot de passe actuel -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Mot de passe
                            actuel</label>
                        <input type="password" name="current_password" id="current_password"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                        @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Nouveau mot de
                            passe</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Confirmer
                            le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400">
                        @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-neutral-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500/50">
                        <i data-lucide="key" class="h-4 w-4"></i>
                        Mettre à jour le mot de passe
                    </button>

                    @if (session('status') === 'password-updated')
                    <p class="text-sm text-emerald-600">Mot de passe mis à jour.</p>
                    @endif
                </div>
            </form>
        </section>

        <!-- Zone dangereuse -->
        <section class="rounded-xl border border-orange-200 dark:border-orange-800/50 bg-white dark:bg-gray-800 overflow-hidden">
            <div class="border-b border-orange-200 dark:border-orange-800/50 px-6 py-4">
                <h3 class="text-base font-semibold text-orange-700 dark:text-orange-400">Zone dangereuse</h3>
                <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">Actions irréversibles concernant votre compte.</p>
            </div>
            <div class="p-6">
                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800/50 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-triangle" class="h-5 w-5 text-orange-600 dark:text-orange-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <h4 class="text-sm font-medium text-orange-800 dark:text-orange-300">Suppression définitive</h4>
                            <p class="text-sm text-orange-700 dark:text-orange-400 mt-1">Une fois votre compte supprimé, toutes vos données seront définitivement effacées et ne pourront pas être récupérées.</p>
                        </div>
                    </div>
                </div>
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-orange-300 dark:hover:border-orange-600 hover:text-orange-700 dark:hover:text-orange-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500/50">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                    Supprimer le compte
                </button>
            </div>
        </section>
    </main>
</div>

<!-- Modal de confirmation de suppression -->
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">Êtes-vous sûr de vouloir supprimer votre compte ?</h2>
        <p class="mt-2 text-sm text-neutral-600 dark:text-gray-400">Une fois votre compte supprimé, toutes ses ressources et données seront
            définitivement effacées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer
            définitivement votre compte.</p>

        <div class="mt-6">
            <label for="password" class="sr-only">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe"
                class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-neutral-900 dark:text-gray-100 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 placeholder-gray-500 dark:placeholder-gray-400" />
            @error('password', 'userDeletion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <button type="button" x-on:click="$dispatch('close')"
                class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:bg-gray-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500/50">
                Annuler
            </button>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500/50">
                <i data-lucide="trash-2" class="h-4 w-4"></i>
                Supprimer le compte
            </button>
        </div>
    </form>
</x-modal>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons({
            attrs: {
                'stroke-width': 1.5
            }
        });
    });
</script>
@endpush
@endsection
