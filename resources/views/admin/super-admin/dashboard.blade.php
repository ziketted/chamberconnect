@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tableau de bord Super Admin</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Gérez les chambres, utilisateurs et agréments</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Chambres -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="building" class="h-8 w-8 text-[#073066] dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Chambres</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_chambers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Chambres Agréées -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="shield-check" class="h-8 w-8 text-[#fcb357]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Chambres Agréées</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['verified_chambers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Chambres en Attente -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="clock" class="h-8 w-8 text-[#b81010]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">En Attente</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['pending_chambers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Utilisateurs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="users" class="h-8 w-8 text-[#073066] dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Gestionnaires -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="briefcase" class="h-8 w-8 text-[#fcb357]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Gestionnaires</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['chamber_managers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Utilisateurs Normaux -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="user" class="h-8 w-8 text-gray-600 dark:text-gray-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['regular_users'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Alert -->
    @if($stats['pending_chambers'] > 0)
        <div class="mb-8 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        {{ $stats['pending_chambers'] }} demande(s) de création en attente
                    </h3>
                    <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                        Des utilisateurs ont soumis des demandes de création de chambres qui nécessitent votre validation.
                    </p>
                </div>
                <div class="ml-3">
                    <a href="{{ route('admin.chambers.pending-requests') }}" 
                       class="inline-flex items-center px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Examiner
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.chambers.pending-requests') }}" 
           class="bg-yellow-600 text-white rounded-lg p-4 hover:bg-yellow-700 transition-colors relative">
            <div class="flex items-center">
                <i data-lucide="clock" class="h-5 w-5 mr-2"></i>
                Demandes en attente
                @if($stats['pending_chambers'] > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center">
                        {{ $stats['pending_chambers'] }}
                    </span>
                @endif
            </div>
        </a>

        <a href="{{ route('chambers.create') }}" 
           class="bg-[#073066] text-white rounded-lg p-4 hover:bg-[#052347] transition-colors">
            <div class="flex items-center">
                <i data-lucide="plus" class="h-5 w-5 mr-2"></i>
                Créer une chambre
            </div>
        </a>

        <a href="{{ route('admin.chambers') }}" 
           class="bg-[#fcb357] text-white rounded-lg p-4 hover:bg-[#f5a742] transition-colors">
            <div class="flex items-center">
                <i data-lucide="building" class="h-5 w-5 mr-2"></i>
                Gérer les chambres
            </div>
        </a>

        <a href="{{ route('admin.users') }}" 
           class="bg-[#073066] text-white rounded-lg p-4 hover:bg-[#052347] transition-colors">
            <div class="flex items-center">
                <i data-lucide="users" class="h-5 w-5 mr-2"></i>
                Gérer les utilisateurs
            </div>
        </a>
    </div>
</div>
@endsection
