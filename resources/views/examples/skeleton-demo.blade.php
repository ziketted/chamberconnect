@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Démonstration des Skeletons</h1>
    
    <!-- Skeleton de base -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Skeleton de base</h2>
        <div class="space-y-4">
            <x-skeleton width="w-full" height="h-4" />
            <x-skeleton width="w-3/4" height="h-4" />
            <x-skeleton width="w-1/2" height="h-4" />
        </div>
    </section>
    
    <!-- Cartes de chambre -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Cartes de chambre</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @for($i = 0; $i < 6; $i++)
                <x-skeleton.chamber-card />
            @endfor
        </div>
    </section>
    
    <!-- Statistiques du dashboard -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Statistiques du dashboard</h2>
        <x-skeleton.dashboard-stats />
    </section>
    
    <!-- Cartes utilisateur -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Cartes utilisateur</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @for($i = 0; $i < 4; $i++)
                <x-skeleton.user-card />
            @endfor
        </div>
    </section>
    
    <!-- Cartes d'événement -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Cartes d'événement</h2>
        <div class="space-y-4">
            @for($i = 0; $i < 3; $i++)
                <x-skeleton.event-card />
            @endfor
        </div>
    </section>
    
    <!-- Tableau -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Tableau</h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Rôle</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 5; $i++)
                        <x-skeleton.table-row :columns="4" />
                    @endfor
                </tbody>
            </table>
        </div>
    </section>
    
    <!-- Liste d'éléments -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Liste d'éléments</h2>
        <div class="space-y-3">
            @for($i = 0; $i < 5; $i++)
                <x-skeleton.list-item />
            @endfor
        </div>
    </section>
    
    <!-- Formulaire -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Formulaire</h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <x-skeleton.form />
        </div>
    </section>
</div>
@endsection