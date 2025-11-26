@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="mx-auto h-24 w-24 text-orange-500 mb-6">
            <i data-lucide="pause-circle" class="h-full w-full"></i>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
            Chambre temporairement indisponible
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            Cette chambre de commerce est actuellement suspendue
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="text-center">
                <!-- Logo de la chambre si disponible -->
                @if($chamber->logo_path)
                    <div class="mx-auto h-16 w-16 mb-4">
                        <img class="h-full w-full rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" 
                             src="{{ asset('storage/' . $chamber->logo_path) }}" 
                             alt="{{ $chamber->name }}">
                    </div>
                @else
                    <div class="mx-auto h-16 w-16 mb-4 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center border-2 border-gray-200 dark:border-gray-600">
                        <span class="text-white font-bold text-lg">{{ strtoupper(substr($chamber->name, 0, 2)) }}</span>
                    </div>
                @endif

                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    {{ $chamber->name }}
                </h3>

                @if($chamber->location)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center justify-center">
                        <i data-lucide="map-pin" class="h-4 w-4 mr-1"></i>
                        {{ $chamber->location }}
                    </p>
                @endif

                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="info" class="h-5 w-5 text-orange-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-orange-800 dark:text-orange-200">
                                Accès temporairement suspendu
                            </h3>
                            <div class="mt-2 text-sm text-orange-700 dark:text-orange-300">
                                <p>
                                    Cette chambre de commerce est actuellement indisponible pour des raisons administratives. 
                                    L'accès sera rétabli dès que possible.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($chamber->suspended_at)
                    <p class="text-xs text-gray-400 mb-4">
                        Suspendue le {{ $chamber->suspended_at->format('d/m/Y à H:i') }}
                    </p>
                @endif

                <div class="space-y-3">
                    <a href="{{ route('chambers') }}" 
                       class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#073066] hover:bg-[#052347] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                        Retour aux chambres
                    </a>

                    @if($chamber->email)
                        <a href="mailto:{{ $chamber->email }}" 
                           class="w-full flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i data-lucide="mail" class="h-4 w-4 mr-2"></i>
                            Contacter la chambre
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Suggestions d'autres chambres -->
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-4xl">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-6">
            Découvrez d'autres chambres de commerce
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $suggestedChambers = \App\Models\Chamber::where('verified', true)
                    ->where('is_suspended', false)
                    ->where('id', '!=', $chamber->id)
                    ->inRandomOrder()
                    ->take(3)
                    ->get();
            @endphp

            @foreach($suggestedChambers as $suggestedChamber)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        @if($suggestedChamber->logo_path)
                            <img class="h-10 w-10 rounded-full object-cover mr-3" 
                                 src="{{ asset('storage/' . $suggestedChamber->logo_path) }}" 
                                 alt="{{ $suggestedChamber->name }}">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($suggestedChamber->name, 0, 2)) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $suggestedChamber->name }}
                            </h4>
                            @if($suggestedChamber->location)
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $suggestedChamber->location }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $suggestedChamber->members->count() }} membres
                        </span>
                        <a href="{{ route('chamber.show', $suggestedChamber) }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            Découvrir →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les icônes Lucide
    lucide.createIcons();
});
</script>
@endpush
@endsection