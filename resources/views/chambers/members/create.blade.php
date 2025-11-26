@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Ajouter un membre — {{ $chamber->name }}</h1>
            <p class="text-sm text-neutral-600 dark:text-gray-400">Sélectionnez un utilisateur existant pour l'ajouter à cette chambre.</p>
        </div>
        <a href="{{ route('chambers.manage-members', $chamber) }}"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-neutral-300 dark:border-gray-600 text-sm text-neutral-800 dark:text-gray-200 hover:bg-neutral-100 dark:hover:bg-gray-700">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Retour
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Erreur</h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($availableUsers->isEmpty())
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center">
            <i data-lucide="users" class="h-12 w-12 mx-auto text-neutral-400 dark:text-gray-500 mb-4"></i>
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">Aucun utilisateur disponible</h3>
            <p class="text-sm text-neutral-600 dark:text-gray-400">
                Tous les utilisateurs sont déjà membres de cette chambre.
            </p>
        </div>
    @else
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
            <form action="{{ route('chambers.members.store', $chamber) }}" method="POST">
                @csrf
                
                <!-- User Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Sélectionner un utilisateur
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="user-filter" 
                               placeholder="Rechercher par nom ou email..."
                               class="w-full rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20 mb-3"
                               autocomplete="off">
                    </div>
                    
                    <div id="users-list" class="border border-neutral-300 dark:border-gray-600 rounded-md max-h-64 overflow-y-auto">
                        @foreach($availableUsers as $user)
                            <label class="user-item flex items-center gap-3 p-3 hover:bg-neutral-50 dark:hover:bg-gray-700 cursor-pointer border-b border-neutral-100 dark:border-gray-700 last:border-0"
                                   data-name="{{ strtolower($user->name) }}"
                                   data-email="{{ strtolower($user->email) }}">
                                <input type="radio" 
                                       name="email" 
                                       value="{{ $user->email }}" 
                                       required
                                       class="h-4 w-4 text-[#073066] border-neutral-300 dark:border-gray-600 focus:ring-[#073066]">
                                <div class="flex-1">
                                    <div class="font-medium text-neutral-900 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-sm text-neutral-500 dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-2 text-xs text-neutral-500 dark:text-gray-400">
                        {{ $availableUsers->count() }} utilisateur(s) disponible(s)
                    </p>
                </div>

                <!-- Role Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-gray-300 mb-2">
                        Rôle dans la chambre
                    </label>
                    <select name="role" required
                        class="w-full rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                        <option value="member">Membre</option>
                        <option value="manager">Gestionnaire</option>
                    </select>
                    <p class="mt-1 text-xs text-neutral-500 dark:text-gray-400">
                        Les gestionnaires peuvent gérer les membres et le contenu de la chambre.
                    </p>
                </div>

                <!-- Submit buttons -->
                <div class="flex justify-end gap-2">
                    <a href="{{ route('chambers.manage-members', $chamber) }}"
                        class="rounded-md border border-neutral-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-neutral-800 dark:text-gray-200 hover:bg-neutral-50 dark:hover:bg-gray-700">
                        Annuler
                    </a>
                    <button type="submit"
                        class="rounded-md bg-[#073066] hover:bg-[#052347] px-4 py-2 text-sm font-semibold text-white">
                        Ajouter le membre
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterInput = document.getElementById('user-filter');
    const userItems = document.querySelectorAll('.user-item');
    
    if (filterInput && userItems.length > 0) {
        filterInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            userItems.forEach(item => {
                const name = item.dataset.name || '';
                const email = item.dataset.email || '';
                const matches = query === '' || name.includes(query) || email.includes(query);
                
                item.style.display = matches ? 'flex' : 'none';
            });
        });
    }
});
</script>
@endpush

@endsection
