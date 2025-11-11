@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('chamber.show', $chamber) }}" 
               class="inline-flex items-center gap-2 text-sm text-neutral-600 dark:text-gray-400 hover:text-neutral-900 dark:hover:text-white">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Retour à {{ $chamber->name }}
            </a>
        </div>
        <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Créer un événement</h1>
        <p class="text-sm text-neutral-600 dark:text-gray-400 mt-1">Organisez un événement pour votre chambre de commerce</p>
    </div>

    <form action="{{ route('chambers.events.store', $chamber) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Informations générales</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Titre de l'événement *
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                           placeholder="Ex: Forum des Investisseurs 2025">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Type d'événement *
                    </label>
                    <select id="type" name="type" required
                            class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                        <option value="">Sélectionner un type</option>
                        <option value="forum" {{ old('type') === 'forum' ? 'selected' : '' }}>Forum</option>
                        <option value="networking" {{ old('type') === 'networking' ? 'selected' : '' }}>Networking</option>
                        <option value="conference" {{ old('type') === 'conference' ? 'selected' : '' }}>Conférence</option>
                        <option value="meeting" {{ old('type') === 'meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="autres" {{ old('type') === 'autres' ? 'selected' : '' }}>Autres</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mode -->
                <div>
                    <label for="mode" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Mode de participation *
                    </label>
                    <select id="mode" name="mode" required
                            class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                        <option value="">Sélectionner un mode</option>
                        <option value="online" {{ old('mode') === 'online' ? 'selected' : '' }}>En ligne</option>
                        <option value="presentiel" {{ old('mode') === 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                        <option value="hybride" {{ old('mode') === 'hybride' ? 'selected' : '' }}>Hybride</option>
                    </select>
                    @error('mode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Date *
                    </label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Heure -->
                <div>
                    <label for="time" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Heure *
                    </label>
                    <input type="time" id="time" name="time" value="{{ old('time') }}" required
                           class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    @error('time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre maximum de participants -->
                <div>
                    <label for="max_participants" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Nombre maximum de participants
                    </label>
                    <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants') }}" min="1"
                           class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                           placeholder="Laisser vide pour illimité">
                    @error('max_participants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                              placeholder="Décrivez votre événement...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section Localisation -->
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Localisation</h2>
            
            <div class="space-y-4">
                <!-- Lien live (pour événements en ligne) -->
                <div id="online-fields" style="display: none;">
                    <label for="lien_live" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Lien de diffusion en direct *
                    </label>
                    <input type="url" id="lien_live" name="lien_live" value="{{ old('lien_live') }}"
                           class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                           placeholder="https://zoom.us/j/123456789 ou https://meet.google.com/abc-defg-hij">
                    @error('lien_live')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champs pour événements en présentiel -->
                <div id="physical-fields" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="country" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                                Pays *
                            </label>
                            <input type="text" id="country" name="country" value="{{ old('country') }}"
                                   class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                                   placeholder="République Démocratique du Congo">
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                                Ville *
                            </label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                   class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                                   placeholder="Kinshasa">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                                Adresse complète
                            </label>
                            <textarea id="address" name="address" rows="2"
                                      class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                                      placeholder="Adresse précise du lieu de l'événement">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="location" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                                Nom du lieu
                            </label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}"
                                   class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                                   placeholder="Ex: Hôtel Memling, Salle de conférence A">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image de couverture -->
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Image de couverture</h2>
            
            <div>
                <label for="cover" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                    Télécharger une image (optionnel)
                </label>
                <input type="file" id="cover" name="cover" accept="image/*"
                       class="w-full rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                <p class="mt-1 text-xs text-neutral-500 dark:text-gray-500">Formats acceptés: JPG, PNG, GIF. Taille maximale: 2MB</p>
                @error('cover')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('chamber.show', $chamber) }}" 
               class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#073066] px-4 py-2 text-sm font-medium text-white hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-[#073066]/20">
                <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                Créer l'événement
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeSelect = document.getElementById('mode');
    const onlineFields = document.getElementById('online-fields');
    const physicalFields = document.getElementById('physical-fields');
    const lienLiveInput = document.getElementById('lien_live');
    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');

    function toggleFields() {
        const mode = modeSelect.value;
        
        // Réinitialiser l'affichage
        onlineFields.style.display = 'none';
        physicalFields.style.display = 'none';
        
        // Supprimer les attributs required
        lienLiveInput.removeAttribute('required');
        countryInput.removeAttribute('required');
        cityInput.removeAttribute('required');
        
        if (mode === 'online') {
            onlineFields.style.display = 'block';
            lienLiveInput.setAttribute('required', 'required');
        } else if (mode === 'presentiel') {
            physicalFields.style.display = 'block';
            countryInput.setAttribute('required', 'required');
            cityInput.setAttribute('required', 'required');
        } else if (mode === 'hybride') {
            onlineFields.style.display = 'block';
            physicalFields.style.display = 'block';
            lienLiveInput.setAttribute('required', 'required');
            countryInput.setAttribute('required', 'required');
            cityInput.setAttribute('required', 'required');
        }
    }

    // Initialiser l'affichage
    toggleFields();
    
    // Écouter les changements
    modeSelect.addEventListener('change', toggleFields);
    
    // Initialiser Lucide
    lucide.createIcons();
});
</script>
@endpush
@endsection