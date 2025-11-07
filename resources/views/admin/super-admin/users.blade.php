@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Utilisateurs</h1>
        <p class="mt-2 text-gray-600">Gérez les rôles et permissions des utilisateurs</p>
    </div>

    <!-- Users List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Utilisateur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Entreprise
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rôle
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Chambres
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($user->avatar)
                                <img class="h-10 w-10 rounded-full" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $user->company ?? 'Non spécifiée' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->isSuperAdmin())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i data-lucide="shield" class="h-3 w-3 mr-1"></i>
                                Super Admin
                            </span>
                        @elseif($user->isChamberManager())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i data-lucide="briefcase" class="h-3 w-3 mr-1"></i>
                                Gestionnaire
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                                Utilisateur
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($user->chambers->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->chambers as $chamber)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-green-100 text-green-800">
                                        {{ $chamber->name }}
                                        @if($chamber->pivot->role === 'manager')
                                            <i data-lucide="crown" class="h-3 w-3 ml-1"></i>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400">Aucune chambre</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if(!$user->isSuperAdmin())
                            <div class="flex space-x-2">
                                @if($user->isChamberManager())
                                    <form method="POST" action="{{ route('admin.users.demote', $user) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-orange-600 hover:text-orange-900" 
                                                onclick="return confirm('Rétrograder cet utilisateur ?')"
                                                title="Rétrograder en utilisateur">
                                            <i data-lucide="arrow-down" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.promote', $user) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-blue-600 hover:text-blue-900"
                                                onclick="return confirm('Promouvoir en gestionnaire de chambre ?')"
                                                title="Promouvoir en gestionnaire">
                                            <i data-lucide="arrow-up" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400">Super Admin</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Aucun utilisateur trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection