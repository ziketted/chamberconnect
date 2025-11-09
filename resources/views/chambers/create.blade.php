@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Create a Chamber</h1>
        <p class="text-sm text-neutral-600">Define details, upload cover and social links.</p>
    </div>

    <form action="{{ route('chambers.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        @csrf

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-neutral-700">Name</label>
                <input name="name" required
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Location</label>
                <input name="location"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Address</label>
                <input name="address"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Website</label>
                <input name="website"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Email</label>
                <input type="email" name="email"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Phone</label>
                <input name="phone"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
            </div>
        </div>

        <div>
            <label class="text-xs font-medium text-neutral-700">Description</label>
            <textarea name="description" rows="4"
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20"></textarea>
        </div>

        <!-- Upload Section -->
        <div class="grid sm:grid-cols-2 gap-6">
            <!-- Logo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo de la chambre</label>
                <div class="relative">
                    <div id="logo-dropzone" class="group relative flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                        <div id="logo-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500 group-hover:text-gray-600">
                                <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 2MB)</p>
                        </div>
                        <div id="logo-preview" class="hidden absolute inset-0 rounded-lg overflow-hidden">
                            <img id="logo-image" class="w-full h-full object-cover" alt="Logo preview">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button type="button" id="logo-remove" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="logo-input" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>
                </div>
            </div>

            <!-- Cover Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                <div class="relative">
                    <div id="cover-dropzone" class="group relative flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                        <div id="cover-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM3 3l1.5 1.5M16.5 16.5L15 15"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500 group-hover:text-gray-600">
                                <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 5MB)</p>
                        </div>
                        <div id="cover-preview" class="hidden absolute inset-0 rounded-lg overflow-hidden">
                            <img id="cover-image" class="w-full h-full object-cover" alt="Cover preview">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button type="button" id="cover-remove" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="cover-input" name="cover" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="text-sm font-semibold tracking-tight mb-2" style="letter-spacing:-0.01em;">Social Links</div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-xs font-medium text-neutral-700">LinkedIn</label>
                    <input name="social_links[linkedin]"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
                </div>
                <div>
                    <label class="text-xs font-medium text-neutral-700">Twitter</label>
                    <input name="social_links[twitter]"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
                </div>
                <div>
                    <label class="text-xs font-medium text-neutral-700">Facebook</label>
                    <input name="social_links[facebook]"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('chambers') }}"
                class="rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium hover:bg-neutral-50">Cancel</a>
            <button class="rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">Create
                Chamber</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration pour les deux zones de upload
    const uploadConfigs = [
        {
            inputId: 'logo-input',
            dropzoneId: 'logo-dropzone',
            placeholderId: 'logo-placeholder',
            previewId: 'logo-preview',
            imageId: 'logo-image',
            removeId: 'logo-remove',
            maxSize: 2 * 1024 * 1024 // 2MB
        },
        {
            inputId: 'cover-input',
            dropzoneId: 'cover-dropzone',
            placeholderId: 'cover-placeholder',
            previewId: 'cover-preview',
            imageId: 'cover-image',
            removeId: 'cover-remove',
            maxSize: 5 * 1024 * 1024 // 5MB
        }
    ];

    uploadConfigs.forEach(config => {
        const input = document.getElementById(config.inputId);
        const dropzone = document.getElementById(config.dropzoneId);
        const placeholder = document.getElementById(config.placeholderId);
        const preview = document.getElementById(config.previewId);
        const image = document.getElementById(config.imageId);
        const removeBtn = document.getElementById(config.removeId);

        // Gestion du drag & drop
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-[#073066]', 'bg-red-50');
        });

        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-[#073066]', 'bg-red-50');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-[#073066]', 'bg-red-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0], config);
            }
        });

        // Gestion du clic sur l'input
        input.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0], config);
            }
        });

        // Bouton de suppression
        removeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            removeFile(config);
        });
    });

    function handleFile(file, config) {
        // Vérification du type de fichier
        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner un fichier image valide.');
            return;
        }

        // Vérification de la taille
        if (file.size > config.maxSize) {
            const maxSizeMB = config.maxSize / (1024 * 1024);
            alert(`Le fichier est trop volumineux. Taille maximale: ${maxSizeMB}MB`);
            return;
        }

        // Lecture et affichage de l'image
        const reader = new FileReader();
        reader.onload = (e) => {
            const placeholder = document.getElementById(config.placeholderId);
            const preview = document.getElementById(config.previewId);
            const image = document.getElementById(config.imageId);

            image.src = e.target.result;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeFile(config) {
        const input = document.getElementById(config.inputId);
        const placeholder = document.getElementById(config.placeholderId);
        const preview = document.getElementById(config.previewId);
        const image = document.getElementById(config.imageId);

        // Réinitialiser l'input
        input.value = '';
        
        // Réinitialiser l'affichage
        image.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }

    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="name"]').value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Le nom de la chambre est obligatoire.');
            return;
        }

        // Afficher un indicateur de chargement
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Création en cours...
        `;

        // Réactiver le bouton après 10 secondes pour éviter le blocage
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }, 10000);
    });
});
</script>
@endpush

@endsection


