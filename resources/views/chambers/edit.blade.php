@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Edit Chamber</h1>
        <p class="text-sm text-neutral-600 dark:text-gray-400">Update details, cover and social links.</p>
    </div>

    <form action="{{ route('chambers.update', $chamber) }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Name</label>
                <input name="name" value="{{ old('name', $chamber->name) }}" required
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Location</label>
                <input name="location" value="{{ old('location', $chamber->location) }}"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Type</label>
                <select name="type" id="chamber_type" x-data
                    x-on:change="document.dispatchEvent(new CustomEvent('type-changed',{detail:$event.target.value}))"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    <option value="national" @selected(old('type', $chamber->type ?? 'national') ===
                        'national')>National</option>
                    <option value="bilateral" @selected(old('type', $chamber->type ?? 'national') ===
                        'bilateral')>Bilatérale</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Pays (si bilatérale)</label>
                <select name="embassy_country" data-bilateral
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    <option value="">Sélectionnez un pays</option>
                    @foreach(config('countries') as $country)
                    <option value="{{ $country }}" @selected(old('embassy_country', $chamber->embassy_country) ===
                        $country)>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Address</label>
                <input name="address" value="{{ old('address', $chamber->address) }}"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Adresse de l'ambassade (si
                    bilatérale)</label>
                <input name="embassy_address" value="{{ old('embassy_address', $chamber->embassy_address) }}"
                    data-bilateral
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Téléphone de l'ambassade (si
                    bilatérale)</label>
                <input name="embassy_phone" value="{{ old('embassy_phone', $chamber->embassy_phone) }}" data-bilateral
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Site web de l'ambassade (si
                    bilatérale)</label>
                <input name="embassy_website" value="{{ old('embassy_website', $chamber->embassy_website) }}"
                    data-bilateral
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Website</label>
                <input name="website" value="{{ old('website', $chamber->website) }}"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" value="{{ old('email', $chamber->email) }}"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Phone</label>
                <input name="phone" value="{{ old('phone', $chamber->phone) }}"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
        </div>

        <div>
            <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Description</label>
            <textarea name="description" rows="4"
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">{{ old('description', $chamber->description) }}</textarea>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div
                x-data="{fileName: '', preview: '{{ $chamber->logo_path ? asset('storage/'.$chamber->logo_path) : '' }}'}">
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Logo</label>
                <label
                    class="mt-1 flex items-center justify-center rounded-lg border border-dashed border-neutral-300 dark:border-gray-600 bg-neutral-50 dark:bg-gray-700 px-4 py-6 text-center cursor-pointer hover:bg-neutral-100 dark:hover:bg-gray-600">
                    <input type="file" name="logo" accept="image/*" class="hidden"
                        @change="fileName = $event.target.files[0]?.name || ''; if ($event.target.files[0]) { const r=new FileReader(); r.onload=e=>preview=e.target.result; r.readAsDataURL($event.target.files[0]); }">
                    <div class="space-y-1">
                        <i data-lucide="image" class="h-6 w-6 text-neutral-500"></i>
                        <div class="text-xs text-neutral-600 dark:text-gray-300"
                            x-text="fileName || 'Glissez-déposez ou cliquez pour choisir'"></div>
                    </div>
                </label>
                <template x-if="preview">
                    <img :src="preview" class="mt-2 h-12 rounded-md object-cover" />
                </template>
            </div>
            <div
                x-data="{fileName: '', preview: '{{ $chamber->cover_image_path ? asset('storage/'.$chamber->cover_image_path) : '' }}'}">
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Cover Image</label>
                <label
                    class="mt-1 flex items-center justify-center rounded-lg border border-dashed border-neutral-300 dark:border-gray-600 bg-neutral-50 dark:bg-gray-700 px-4 py-6 text-center cursor-pointer hover:bg-neutral-100 dark:hover:bg-gray-600">
                    <input type="file" name="cover" accept="image/*" class="hidden"
                        @change="fileName = $event.target.files[0]?.name || ''; if ($event.target.files[0]) { const r=new FileReader(); r.onload=e=>preview=e.target.result; r.readAsDataURL($event.target.files[0]); }">
                    <div class="space-y-1">
                        <i data-lucide="image-plus" class="h-6 w-6 text-neutral-500"></i>
                        <div class="text-xs text-neutral-600 dark:text-gray-300"
                            x-text="fileName || 'Glissez-déposez ou cliquez pour choisir'"></div>
                    </div>
                </label>
                <template x-if="preview">
                    <img :src="preview" class="mt-2 h-20 w-full object-cover rounded-md" />
                </template>
            </div>
        </div>

        <div>
            <div class="text-sm font-semibold tracking-tight mb-2" style="letter-spacing:-0.01em;">Social Links</div>
            <div class="grid sm:grid-cols-3 gap-4">
                @php($s = $chamber->social_links ?? [])
                <div>
                    <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">LinkedIn</label>
                    <input name="social_links[linkedin]"
                        value="{{ old('social_links.linkedin', $s['linkedin'] ?? '') }}"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
                </div>
                <div>
                    <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Twitter</label>
                    <input name="social_links[twitter]" value="{{ old('social_links.twitter', $s['twitter'] ?? '') }}"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
                </div>
                <div>
                    <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Facebook</label>
                    <input name="social_links[facebook]"
                        value="{{ old('social_links.facebook', $s['facebook'] ?? '') }}"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('chamber.show', $chamber) }}"
                class="rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium hover:bg-neutral-50 dark:bg-gray-700">Cancel</a>
            <button class="rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">Save
                Changes</button>
        </div>
    </form>
    </form>

    <!-- Partners Section -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold tracking-tight">Partenaires</h2>
                <p class="text-sm text-neutral-600 dark:text-gray-400">Gérez les partenaires de la chambre.</p>
            </div>
            <button onclick="openPartnerModal()"
                class="inline-flex items-center rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                Ajouter un partenaire
            </button>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($chamber->partners as $partner)
            <div
                class="relative rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm group">
                <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="editPartner({{ json_encode($partner) }})"
                        class="rounded-md bg-neutral-100 p-1.5 text-neutral-600 hover:bg-neutral-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        <i data-lucide="pencil" class="h-4 w-4"></i>
                    </button>
                    <form action="{{ route('chambers.partners.destroy', [$chamber, $partner]) }}" method="POST"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-md bg-red-50 p-1.5 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                        </button>
                    </form>
                </div>

                <div class="flex items-start gap-4">
                    <div
                        class="h-12 w-12 flex-shrink-0 rounded-lg bg-neutral-100 dark:bg-gray-700 overflow-hidden flex items-center justify-center">
                        @if($partner->logo_path)
                        <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}"
                            class="h-full w-full object-cover">
                        @else
                        <span class="text-lg font-bold text-neutral-400">{{ substr($partner->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-medium text-neutral-900 dark:text-white">{{ $partner->name }}</h3>
                        @if($partner->website)
                        <a href="{{ $partner->website }}" target="_blank"
                            class="text-xs text-blue-600 hover:underline flex items-center gap-1 mt-1">
                            <i data-lucide="link" class="h-3 w-3"></i>
                            {{ parse_url($partner->website, PHP_URL_HOST) }}
                        </a>
                        @endif
                    </div>
                </div>
                @if($partner->description)
                <p class="mt-3 text-sm text-neutral-600 dark:text-gray-400 line-clamp-2">{{ $partner->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Partner Modal -->
<div id="partnerModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            onclick="closePartnerModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="partnerForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <input type="hidden" name="_method" id="methodInput" value="POST">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modalTitle">Ajouter un
                        partenaire</h3>
                    <button type="button" onclick="closePartnerModal()" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="h-6 w-6"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                        <input type="text" name="name" id="partnerName" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site web
                            (Domaine)</label>
                        <input type="url" name="website" id="partnerWebsite" placeholder="https://example.com"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="partnerDescription" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
                        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closePartnerModal()"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit"
                        class="rounded-md border border-transparent bg-[#073066] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPartnerModal() {
        document.getElementById('partnerModal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = 'Ajouter un partenaire';
        document.getElementById('partnerForm').action = "{{ route('chambers.partners.store', $chamber) }}";
        document.getElementById('methodInput').value = 'POST';
        document.getElementById('partnerForm').reset();
    }

    function editPartner(partner) {
        document.getElementById('partnerModal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = 'Modifier le partenaire';
        document.getElementById('partnerForm').action = `/chambers/{{ $chamber->slug }}/partners/${partner.id}`;
        document.getElementById('methodInput').value = 'PUT';

        document.getElementById('partnerName').value = partner.name;
        document.getElementById('partnerWebsite').value = partner.website || '';
        document.getElementById('partnerDescription').value = partner.description || '';
    }

    function closePartnerModal() {
        document.getElementById('partnerModal').classList.add('hidden');
    }
</script>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Afficher/masquer champs bilatérale
        const applyVisibility = (type) => {
            const isBilateral = type === 'bilateral';
            document.querySelectorAll('[data-bilateral]').forEach(el => {
                el.closest('div').style.display = isBilateral ? '' : 'none';
            });
        };
        const typeSelect = document.getElementById('chamber_type');
        if (typeSelect) {
            applyVisibility(typeSelect.value || 'national');
            document.addEventListener('type-changed', (e) => applyVisibility(e.detail));
        }
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush