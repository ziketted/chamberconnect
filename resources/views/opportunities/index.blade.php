@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Main Content -->
    <main class="lg:col-span-9">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-semibold">Opportunités</h1>
                </div>
            </div>

            <!-- Barre de recherche -->
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 dark:text-gray-500 dark:text-gray-400">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </span>
                <input type="text" 
                    placeholder="Rechercher des opportunités..." 
                    class="w-full rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-4 py-3 text-sm text-neutral-800 dark:text-gray-100 placeholder:text-neutral-400 dark:text-gray-500 dark:text-gray-400 shadow-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
            </div>
        </div>

        <!-- Contenu à venir -->
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center">
            <div class="mx-auto max-w-md">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#073066]/10 dark:bg-blue-500/20 text-[#073066] dark:text-blue-400 dark:text-blue-400 mx-auto">
                    <i data-lucide="briefcase" class="h-6 w-6"></i>
                </div>
                <h2 class="mt-4 text-lg font-semibold">Opportunités à venir</h2>
                <p class="mt-2 text-sm text-neutral-600 dark:text-gray-400">Cette section est en cours de développement. Revenez bientôt pour découvrir les opportunités commerciales de nos chambres.</p>
            </div>
        </div>
    </main>

    <!-- Sidebar -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-6">
            <!-- Filtres -->
            <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="border-b border-neutral-200 dark:border-gray-700 p-4">
                    <h2 class="text-sm font-semibold">Filtres</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <!-- Type -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Type d'opportunité</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-gray-700 px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300">Partenariat</button>
                                <button class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-gray-700 px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300">Investissement</button>
                                <button class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-gray-700 px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300">Commercial</button>
                            </div>
                        </div>

                        <!-- Secteur -->
                        <div>
                            <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Secteur d'activité</label>
                            <div class="mt-2">
                                <select class="w-full rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-neutral-800 dark:text-gray-100 focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                                    <option value="">Tous les secteurs</option>
                                    <option value="tech">Technologies</option>
                                    <option value="agri">Agriculture</option>
                                    <option value="mining">Mines</option>
                                    <option value="energy">Énergie</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

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
