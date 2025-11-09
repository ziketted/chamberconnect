@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord Super Admin</h1>
        <p class="mt-2 text-gray-600">Gérez les chambres, utilisateurs et agréments</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Chambres -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="building" class="h-8 w-8 text-[#073066]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Chambres</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_chambers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Chambres Agréées -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="shield-check" class="h-8 w-8 text-[#fcb357]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Chambres Agréées</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['verified_chambers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Chambres en Attente -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="clock" class="h-8 w-8 text-[#b81010]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En Attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_chambers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Utilisateurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="users" class="h-8 w-8 text-[#073066]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Gestionnaires -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="briefcase" class="h-8 w-8 text-[#fcb357]"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Gestionnaires</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['chamber_managers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Utilisateurs Normaux -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="user" class="h-8 w-8 text-gray-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['regular_users'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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

        <a href="{{ route('admin.chambers.admins') }}" 
           class="bg-[#b81010] text-white rounded-lg p-4 hover:bg-[#9a0e0e] transition-colors">
            <div class="flex items-center">
                <i data-lucide="settings" class="h-5 w-5 mr-2"></i>
                Configuration
            </div>
        </a>
    </div>
</div>
@endsection
