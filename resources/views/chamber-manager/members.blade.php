@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Membres — {{ $chamber->name }}</h1>
            <p class="text-sm text-neutral-600 dark:text-gray-400">Valider, retirer ou changer le rôle des membres.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('chamber-manager.dashboard', $chamber) }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-neutral-300 dark:border-gray-600 text-sm text-neutral-800 dark:text-gray-200 hover:bg-neutral-100 dark:hover:bg-gray-700">
                <i data-lucide="layout-dashboard" class="h-4 w-4"></i> Tableau de bord
            </a>
            <a href="{{ route('chambers.members.create', $chamber) }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-[#073066] text-white text-sm hover:bg-[#052347]">
                <i data-lucide="user-plus" class="h-4 w-4"></i> Ajouter un membre
            </a>
        </div>
    </div>

    <!-- Pending requests -->
    <div
        class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden mb-8">
        <div class="p-4 border-b border-neutral-200 dark:border-gray-700">
            <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Demandes en attente</h3>
        </div>
        <div class="p-4">
            @if($pendingMembers->isEmpty())
            <p class="text-sm text-neutral-600 dark:text-gray-400">Aucune demande d’adhésion en attente.</p>
            @else
            <ul class="space-y-3">
                @foreach($pendingMembers as $pm)
                <li class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $pm->name }}</p>
                        <p class="text-xs text-neutral-600 dark:text-gray-400">{{ $pm->email }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('chambers.members.approve', [$chamber, $pm]) }}">
                            @csrf
                            <button
                                class="px-2 py-1 text-xs rounded-md bg-green-600 text-white hover:bg-green-700">Valider</button>
                        </form>
                        <form method="POST" action="{{ route('chambers.members.reject', [$chamber, $pm]) }}">
                            @csrf
                            <button
                                class="px-2 py-1 text-xs rounded-md bg-rose-600 text-white hover:bg-rose-700">Refuser</button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <!-- All members -->
    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="p-4 border-b border-neutral-200 dark:border-gray-700">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Tous les membres</h3>
                <div class="relative">
                    <input type="text" id="manager-members-search" placeholder="Rechercher des membres"
                        class="w-56 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-8 pr-3 py-1.5 text-xs focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    <span
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2 text-neutral-400 dark:text-gray-400">
                        <i data-lucide="search" class="h-3.5 w-3.5"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-neutral-600 dark:text-gray-300">
                    <tr>
                        <th class="py-2 pr-4">Membre</th>
                        <th class="py-2 pr-4">Poste</th>
                        <th class="py-2 pr-4">Rôle</th>
                        <th class="py-2 pr-4">Statut</th>
                        <th class="py-2 pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-neutral-800 dark:text-gray-100">
                    @foreach($members as $m)
                    <tr class="border-t border-neutral-100 dark:border-gray-700 js-member-row cursor-pointer hover:bg-neutral-50 dark:hover:bg-gray-700"
                        data-user-id="{{ $m->id }}" data-name="{{ strtolower($m->name) }}"
                        data-email="{{ strtolower($m->email) }}">
                        <td class="py-3 pr-4">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $m->name }}</span>
                                <span class="text-xs text-neutral-500">{{ $m->email }}</span>
                            </div>
                        </td>
                        <td class="py-3 pr-4">
                            <div class="group flex items-center gap-2">
                                <span class="text-sm text-neutral-700 dark:text-gray-300 js-position-display-{{ $m->id }}">{{ $m->pivot->position ?? '-' }}</span>
                                <button onclick="editPosition({{ $m->id }}, '{{ addslashes($m->pivot->position ?? '') }}')" 
                                    class="opacity-0 group-hover:opacity-100 p-1 text-neutral-400 hover:text-blue-600 transition-opacity">
                                    <i data-lucide="pencil" class="h-3 w-3"></i>
                                </button>
                            </div>
                        </td>
                        <td class="py-3 pr-4">
                            <form method="POST" action="{{ route('chambers.members.change-role', [$chamber, $m]) }}"
                                class="flex items-center gap-2 js-change-role" data-user-id="{{ $m->id }}">
                                @csrf
                                @method('PATCH')
                                <select name="role"
                                    class="rounded-md border-neutral-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm">
                                    <option value="member" @selected($m->pivot->role === 'member')>Membre</option>
                                    <option value="manager" @selected($m->pivot->role === 'manager')>Gestionnaire
                                    </option>
                                </select>
                                <button
                                    class="px-2 py-1 text-xs rounded-md bg-neutral-100 dark:bg-gray-700 hover:bg-neutral-200 dark:hover:bg-gray-600">Appliquer</button>
                            </form>
                        </td>
                        <td class="py-3 pr-4">
                            @if($m->pivot->status === 'approved')
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Actif</span>
                            @elseif($m->pivot->status === 'pending')
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">En
                                attente</span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-neutral-100 text-neutral-800 dark:bg-gray-700 dark:text-gray-300">{{
                                $m->pivot->status }}</span>
                            @endif
                        </td>
                        <td class="py-3 pr-4">
                            <div class="flex items-center gap-2">
                                @if($m->pivot->status === 'pending')
                                <form method="POST" action="{{ route('chambers.members.approve', [$chamber, $m]) }}">
                                    @csrf
                                    <button
                                        class="px-2 py-1 text-xs rounded-md bg-green-600 text-white hover:bg-green-700">Valider</button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('chambers.members.remove', [$chamber, $m]) }}"
                                    class="js-remove-member" data-member-name="{{ $m->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="px-2 py-1 text-xs rounded-md bg-rose-600 text-white hover:bg-rose-700 js-remove-btn">Retirer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // AJAX role change
    document.querySelectorAll('.js-change-role').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = form.action;
            const formData = new FormData(form);
            try {
                const res = await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const data = await res.json();
                if (res.ok && data.success) {
                    showToast('Rôle mis à jour', 'success');
                } else {
                    showToast(data.message || 'Erreur lors de la mise à jour', 'error');
                }
            } catch {
                showToast('Erreur réseau', 'error');
        }
    });
});
    // Member details
    document.querySelectorAll('.js-member-row').forEach(row => {
        row.addEventListener('click', async (e) => {
            if (e.target.closest('form') || e.target.closest('button') || e.target.tagName === 'SELECT') return;
            const userId = row.dataset.userId;
            const url = `{{ route('chambers.members.details', [$chamber, 'USER_ID']) }}`.replace('USER_ID', userId);
            try {
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
                const data = await res.json();
                if (res.ok && data.success) {
                    openMemberModal(data.member);
                } else {
                    showToast('Impossible de charger les détails', 'error');
                }
            } catch {
                showToast('Erreur réseau', 'error');
            }
        });
    });
    function openMemberModal(member) {
        const modal = document.getElementById('member-modal');
        const body = document.getElementById('member-modal-body');
        body.innerHTML = `
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-[#073066] text-white flex items-center justify-center font-semibold">
                        ${(member.name||'U').slice(0,1).toUpperCase()}
                    </div>
                    <div>
                        <div class="font-medium text-neutral-900 dark:text-white">${member.name||''}</div>
                        <div class="text-neutral-600 dark:text-gray-300">${member.email||''}</div>
                        ${member.phone ? `<a href="tel:${member.phone}" class="text-[#073066] dark:text-blue-400 hover:underline block">${member.phone}</a>` : ''}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mt-2">
                    <div class="rounded-md border border-neutral-200 dark:border-gray-700 p-3">
                        <div class="text-xs text-neutral-500 dark:text-gray-400">Rôle</div>
                        <div class="text-sm font-medium">${member.role}</div>
                    </div>
                    <div class="rounded-md border border-neutral-200 dark:border-gray-700 p-3">
                        <div class="text-xs text-neutral-500 dark:text-gray-400">Statut</div>
                        <div class="text-sm font-medium">${member.status}</div>
                    </div>
                    <div class="rounded-md border border-neutral-200 dark:border-gray-700 p-3">
                        <div class="text-xs text-neutral-500 dark:text-gray-400">Confirmés</div>
                        <div class="text-sm font-medium">${member.events_confirmed}</div>
                    </div>
                    <div class="rounded-md border border-neutral-200 dark:border-gray-700 p-3">
                        <div class="text-xs text-neutral-500 dark:text-gray-400">Réservés</div>
                        <div class="text-sm font-medium">${member.events_reserved}</div>
                    </div>
                </div>
                <div class="rounded-md border border-neutral-200 dark:border-gray-700 p-3">
                    <div class="text-xs text-neutral-500 dark:text-gray-400">Société</div>
                    <div class="text-sm font-medium">${member.company || '-'}</div>
                </div>
                <div class="rounded-md border border-neutral-200 dark:border-gray-700 p-3">
                    <div class="text-xs text-neutral-500 dark:text-gray-400">Nationalité</div>
                    <div class="text-sm font-medium">${member.nationality || '-'}</div>
                </div>
            </div>
        `;
        modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
    function showToast(message, type='info') {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 z-50 px-4 py-2 rounded-md text-white shadow-lg';
        toast.style.backgroundColor = type === 'success' ? '#16a34a' : (type === 'error' ? '#dc2626' : '#2563eb');
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(()=>toast.remove(), 2500);
    }
    document.getElementById('member-modal-close')?.addEventListener('click', () => {
        document.getElementById('member-modal').classList.add('hidden');
    });
    document.getElementById('member-modal')?.addEventListener('click', (e) => {
        if (e.target.id === 'member-modal') e.target.classList.add('hidden');
    });

    // Remove confirmation modal logic
    const removeModal = document.getElementById('remove-modal');
    const removeBody = document.getElementById('remove-modal-body');
    let pendingRemoveForm = null;
    document.querySelectorAll('.js-remove-member .js-remove-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const form = e.target.closest('form');
            pendingRemoveForm = form;
            const name = form.dataset.memberName || 'ce membre';
            removeBody.innerHTML = `
                <p class="text-sm text-neutral-700 dark:text-gray-300">Êtes-vous sûr de vouloir retirer <span class="font-semibold">${name}</span> de cette chambre ?</p>
                <p class="text-xs text-neutral-500 dark:text-gray-400 mt-2">Cette action est irréversible et supprimera l'accès du membre aux ressources de la chambre.</p>
            `;
            removeModal.classList.remove('hidden');
        });
    });
    document.getElementById('remove-cancel')?.addEventListener('click', ()=> removeModal.classList.add('hidden'));
    document.getElementById('remove-confirm')?.addEventListener('click', ()=> {
        if (pendingRemoveForm) pendingRemoveForm.submit();
    });
    removeModal?.addEventListener('click', (e)=> { if (e.target.id === 'remove-modal') removeModal.classList.add('hidden'); });

    // Search in members table
    const searchInput = document.getElementById('manager-members-search');
    if (searchInput) {
        const rows = Array.from(document.querySelectorAll('tbody tr.js-member-row'));
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const show = q === '' || name.includes(q) || email.includes(q);
                row.style.display = show ? '' : 'none';
            });
        });
    }
});
</script>
@endpush

<!-- Member details modal -->
<div id="member-modal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 shadow-xl">
        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-gray-700 p-4">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">Détails du membre</h3>
            <button id="member-modal-close" class="text-neutral-500 hover:text-neutral-700 dark:text-gray-400">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <div id="member-modal-body" class="p-4"></div>
    </div>
</div>

<!-- Remove confirmation modal -->
<div id="remove-modal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 shadow-xl">
        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-gray-700 p-4">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">Retirer le membre</h3>
            <button id="remove-cancel" class="text-neutral-500 hover:text-neutral-700 dark:text-gray-400">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <div id="remove-modal-body" class="p-4"></div>
        <div class="flex items-center justify-end gap-2 p-4 border-t border-neutral-200 dark:border-gray-700">
            <button id="remove-cancel"
                class="inline-flex items-center rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm font-medium text-neutral-800 dark:text-gray-200 hover:bg-neutral-50 dark:hover:bg-gray-700">
                Annuler
            </button>
            <button id="remove-confirm"
                class="inline-flex items-center rounded-md bg-rose-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-rose-700">
                Confirmer
            </button>
        </div>
    </div>
</div>

<!-- Position Modal -->
<div id="position-modal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 shadow-xl">
        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-gray-700 p-4">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">Modifier le poste</h3>
            <button onclick="closePositionModal()" class="text-neutral-500 hover:text-neutral-700 dark:text-gray-400">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <form id="position-form" method="POST" class="p-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="position-input" class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-1">Poste</label>
                <input type="text" id="position-input" name="position" class="w-full rounded-md border border-neutral-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-1 focus:ring-[#073066]" placeholder="Ex: Président, Secrétaire...">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closePositionModal()" class="px-3 py-2 rounded-md border border-neutral-300 dark:border-gray-600 text-sm text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700">Annuler</button>
                <button type="submit" class="px-3 py-2 rounded-md bg-[#073066] text-white text-sm hover:bg-[#052347]">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function editPosition(userId, currentPosition) {
        const modal = document.getElementById('position-modal');
        const form = document.getElementById('position-form');
        const input = document.getElementById('position-input');
        
        // Update form action URL
        form.action = `{{ route('chambers.members.position', [$chamber, 'USER_ID']) }}`.replace('USER_ID', userId);
        input.value = currentPosition;
        
        modal.classList.remove('hidden');
        input.focus();

        // Handle form submission via AJAX
        form.onsubmit = async (e) => {
            e.preventDefault();
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PATCH',
                        position: input.value
                    })
                });
                
                const data = await res.json();
                
                if (res.ok && data.success) {
                    // Update UI
                    const displayEl = document.querySelector(`.js-position-display-${userId}`);
                    if (displayEl) {
                        displayEl.textContent = data.position || '-';
                        // Update the onclick handler with new position
                        const btn = displayEl.nextElementSibling;
                        if (btn) {
                            btn.setAttribute('onclick', `editPosition(${userId}, '${data.position || ''}')`);
                        }
                    }
                    showToast('Poste mis à jour', 'success');
                    closePositionModal();
                } else {
                    showToast(data.message || 'Erreur lors de la mise à jour', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Erreur réseau', 'error');
            }
        };
    }

    function closePositionModal() {
        document.getElementById('position-modal').classList.add('hidden');
    }
</script>
@endpush