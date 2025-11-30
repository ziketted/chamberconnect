@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-4">
            <!-- Photo de profil avec upload professionnel -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <div class="border-b border-neutral-200 dark:border-gray-700 px-4 py-3">
                    <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">Photo de profil</h3>
                    <p class="text-xs text-neutral-600 dark:text-gray-400 mt-0.5">Cliquez ou glissez pour modifier</p>
                </div>
                <div class="p-4">
                    <form id="profile-photo-form" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col items-center">
                            <!-- Avatar avec hover effect -->
                            <div class="relative group cursor-pointer" id="photo-upload-trigger">
                                <div class="relative w-32 h-32 rounded-2xl overflow-hidden bg-gradient-to-br from-[#2563eb] to-[#1e40af] border-4 border-white dark:border-gray-800 shadow-lg transition-all duration-300 group-hover:shadow-xl group-hover:scale-105">
                                    @if(Auth::user()->avatar || Auth::user()->profile_photo_path)
                                        <img id="profile-preview" src="{{ asset('storage/' . (Auth::user()->avatar ?? Auth::user()->profile_photo_path)) }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div id="profile-preview" class="w-full h-full flex items-center justify-center">
                                            <span class="text-white text-4xl font-bold">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <!-- Overlay au hover -->
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <div class="text-center">
                                            <i data-lucide="camera" class="h-8 w-8 text-white mx-auto mb-2"></i>
                                            <p class="text-white text-xs font-medium">Changer la photo</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Input file caché -->
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden">
                            </div>
                            
                            <!-- Informations -->
                            <div class="mt-4 text-center">
                                <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h4>
                                <p class="text-sm text-neutral-600 dark:text-gray-400 mt-0.5">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <!-- Instructions -->
                            <div class="mt-4 w-full">
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/50 rounded-lg p-3">
                                    <div class="flex items-start gap-2">
                                        <i data-lucide="info" class="h-4 w-4 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0"></i>
                                        <div class="text-xs text-blue-700 dark:text-blue-300">
                                            <p class="font-medium">Formats acceptés : JPG, PNG, GIF</p>
                                            <p class="mt-1 text-blue-600 dark:text-blue-400">Taille maximale : 2 Mo</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="mt-4 flex gap-2 w-full" id="photo-actions" style="display: none;">
                                <button type="button" id="upload-btn" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] px-4 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                    <i data-lucide="upload" class="h-4 w-4"></i>
                                    Enregistrer
                                </button>
                                <button type="button" id="cancel-btn" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-neutral-300 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-600 transition-colors">
                                    <i data-lucide="x" class="h-4 w-4"></i>
                                    Annuler
                                </button>
                            </div>
                            
                            <!-- Message de succès/erreur -->
                            <div id="upload-message" class="mt-3 w-full" style="display: none;"></div>
                        </div>
                    </form>
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
                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] px-5 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#2563eb] dark:focus-visible:ring-blue-500/50">
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
                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1e40af] px-5 py-2.5 text-sm font-semibold text-white hover:shadow-lg hover:scale-105 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#2563eb] dark:focus-visible:ring-blue-500/50">
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

        // Éléments du DOM
        const photoUploadTrigger = document.getElementById('photo-upload-trigger');
        const profilePhotoInput = document.getElementById('profile_photo');
        const profilePreview = document.getElementById('profile-preview');
        const photoActions = document.getElementById('photo-actions');
        const uploadBtn = document.getElementById('upload-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const uploadMessage = document.getElementById('upload-message');
        const profilePhotoForm = document.getElementById('profile-photo-form');
        
        let selectedFile = null;
        let originalPreview = profilePreview.innerHTML;

        // Clic sur l'avatar pour ouvrir le sélecteur de fichier
        photoUploadTrigger.addEventListener('click', () => {
            profilePhotoInput.click();
        });

        // Gestion de la sélection de fichier
        profilePhotoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                handleFileSelection(file);
            }
        });

        // Drag and drop
        photoUploadTrigger.addEventListener('dragover', (e) => {
            e.preventDefault();
            photoUploadTrigger.classList.add('ring-2', 'ring-[#073066]', 'ring-offset-2');
        });

        photoUploadTrigger.addEventListener('dragleave', () => {
            photoUploadTrigger.classList.remove('ring-2', 'ring-[#073066]', 'ring-offset-2');
        });

        photoUploadTrigger.addEventListener('drop', (e) => {
            e.preventDefault();
            photoUploadTrigger.classList.remove('ring-2', 'ring-[#073066]', 'ring-offset-2');
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                handleFileSelection(file);
            }
        });

        // Fonction pour gérer la sélection de fichier
        function handleFileSelection(file) {
            // Validation de la taille (2 Mo max)
            const maxSize = 2 * 1024 * 1024; // 2 Mo
            if (file.size > maxSize) {
                showMessage('La taille du fichier ne doit pas dépasser 2 Mo.', 'error');
                return;
            }

            // Validation du type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                showMessage('Format non supporté. Utilisez JPG, PNG ou GIF.', 'error');
                return;
            }

            selectedFile = file;

            // Prévisualisation
            const reader = new FileReader();
            reader.onload = (e) => {
                // Si c'est une div avec initiale, on la remplace par une image
                if (profilePreview.tagName === 'DIV') {
                    const img = document.createElement('img');
                    img.id = 'profile-preview';
                    img.className = 'w-full h-full object-cover';
                    img.src = e.target.result;
                    profilePreview.parentNode.replaceChild(img, profilePreview);
                } else {
                    profilePreview.src = e.target.result;
                }
                
                // Afficher les boutons d'action
                photoActions.style.display = 'flex';
                lucide.createIcons();
            };
            reader.readAsDataURL(file);
        }

        // Bouton Enregistrer
        uploadBtn.addEventListener('click', async () => {
            if (!selectedFile) return;

            const formData = new FormData();
            formData.append('profile_photo', selectedFile);
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            // Désactiver le bouton pendant l'upload
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<i data-lucide="loader-2" class="h-4 w-4 animate-spin"></i> Envoi...';
            lucide.createIcons();

            try {
                const response = await fetch('{{ route("profile.photo.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showMessage('Photo de profil mise à jour avec succès !', 'success');
                    photoActions.style.display = 'none';
                    selectedFile = null;
                    
                    // Mettre à jour toutes les images de profil sur la page et dans le header
                    const newPhotoUrl = data.photo_url + '?t=' + new Date().getTime();
                    document.querySelectorAll('img[alt="{{ Auth::user()->name }}"]').forEach(img => {
                        img.src = newPhotoUrl;
                    });
                    
                    // Recharger la page après 1 seconde pour rafraîchir toutes les instances
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showMessage(data.message || 'Une erreur est survenue.', 'error');
                    cancelUpload();
                }
            } catch (error) {
                showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
                cancelUpload();
            } finally {
                uploadBtn.disabled = false;
                uploadBtn.innerHTML = '<i data-lucide="upload" class="h-4 w-4"></i> Enregistrer';
                lucide.createIcons();
            }
        });

        // Bouton Annuler
        cancelBtn.addEventListener('click', cancelUpload);

        function cancelUpload() {
            // Recharger la page pour restaurer l'aperçu original
            window.location.reload();
        }

        function showMessage(message, type) {
            const bgColor = type === 'success' ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800/50' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800/50';
            const textColor = type === 'success' ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300';
            const iconColor = type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
            const icon = type === 'success' ? 'check-circle' : 'alert-circle';

            uploadMessage.innerHTML = `
                <div class="${bgColor} border rounded-lg p-3">
                    <div class="flex items-start gap-2">
                        <i data-lucide="${icon}" class="h-4 w-4 ${iconColor} mt-0.5 flex-shrink-0"></i>
                        <p class="text-xs ${textColor} font-medium">${message}</p>
                    </div>
                </div>
            `;
            uploadMessage.style.display = 'block';
            lucide.createIcons();

            setTimeout(() => {
                uploadMessage.style.display = 'none';
            }, 5000);
        }
    });
</script>
@endpush
@endsection
