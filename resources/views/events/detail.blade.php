@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Événements</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400 truncate max-w-xs">{{ $event->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Cover Image / Header -->
        <div class="relative h-64 md:h-80 bg-gray-900">
            @if($event->cover_image_path)
                <img src="{{ asset('storage/' . $event->cover_image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover opacity-60">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-gray-900 opacity-90"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i data-lucide="calendar" class="w-24 h-24 text-white opacity-20"></i>
                </div>
            @endif
            
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-600 text-white">
                        {{ ucfirst($event->type) }}
                    </span>
                    @if($event->chamber)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-700/80 text-white backdrop-blur-sm">
                        <i data-lucide="building" class="w-3 h-3"></i>
                        {{ $event->chamber->name }}
                    </span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $event->title }}</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 md:divide-x divide-gray-200 dark:divide-gray-700">
            <!-- Main Content -->
            <div class="md:col-span-2 p-6 md:p-8 space-y-8">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400">
                            <i data-lucide="calendar" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Date et heure</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $event->date->format('d M Y') }}<br>
                                {{ $event->time }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-lg text-red-600 dark:text-red-400">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Lieu</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $event->location }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-600 dark:text-green-400">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Participants</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $event->participants()->count() }} / {{ $event->max_participants ?? 'Illimité' }}<br>
                                <span class="text-xs">
                                    @if($event->max_participants)
                                        {{ $event->max_participants - $event->participants()->count() }} places restantes
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600 dark:text-purple-400">
                            <i data-lucide="tag" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Prix</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $event->price ?? 'Gratuit' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">À propos de cet événement</h2>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {{ $event->description }}
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="p-6 md:p-8 bg-gray-50 dark:bg-gray-800/50">
                <div class="sticky top-6 space-y-4">
                    @if($event->status !== 'complet')
                        @if($event->isBookedBy(auth()->user()))
                        <div class="w-full p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 mb-3">
                                <i data-lucide="check" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-400 mb-1">Inscrit !</h3>
                            <p class="text-sm text-green-600 dark:text-green-300">Vous participez à cet événement.</p>
                        </div>
                        @else
                        <form action="{{ route('events.book', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors shadow-lg shadow-blue-600/20">
                                <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                                Réserver ma place
                            </button>
                        </form>
                        @endif
                    @else
                        <div class="w-full p-4 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-center">
                            <i data-lucide="users-x" class="w-8 h-8 mx-auto text-gray-400 mb-2"></i>
                            <span class="block font-medium text-gray-500 dark:text-gray-400">Complet</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="toggleEventLike(this, {{ $event->id }})" 
                            class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors {{ $event->isLikedBy(auth()->user()) ? 'text-red-500 border-red-500' : '' }}">
                            <i data-lucide="heart" class="w-4 h-4 {{ $event->isLikedBy(auth()->user()) ? 'fill-current' : '' }}"></i>
                            <span class="like-count">{{ $event->likes()->count() }}</span>
                        </button>
                        
                        <button onclick="shareEvent()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                            Partager
                        </button>
                    </div>

                    <!-- Organizer Mini Card -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Organisé par</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($event->chamber->logo_path)
                                    <img src="{{ asset('storage/' . $event->chamber->logo_path) }}" alt="{{ $event->chamber->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-white font-bold">{{ strtoupper(substr($event->chamber->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $event->chamber->name }}</div>
                                <a href="{{ route('chamber.show', $event->chamber) }}" class="text-xs text-blue-600 hover:underline dark:text-blue-400">Voir le profil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeShareModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                        <i data-lucide="share-2" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Partager cet événement
                        </h3>
                        <div class="mt-4 space-y-3">
                            <div class="flex rounded-md shadow-sm">
                                <input type="text" id="shareLink" readonly value="{{ route('events.detail', $event) }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white sm:text-sm">
                                <button onclick="copyShareLink()" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 dark:border-gray-600 rounded-r-md bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i data-lucide="copy" class="h-4 w-4"></i>
                                </button>
                            </div>
                            <div id="copyMessage" class="text-sm text-green-600 hidden">Lien copié !</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeShareModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function shareEvent() {
        document.getElementById('shareModal').classList.remove('hidden');
    }

    function closeShareModal() {
        document.getElementById('shareModal').classList.add('hidden');
        document.getElementById('copyMessage').classList.add('hidden');
    }

    function copyShareLink() {
        const copyText = document.getElementById("shareLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); 
        navigator.clipboard.writeText(copyText.value);
        
        document.getElementById('copyMessage').classList.remove('hidden');
        setTimeout(() => {
            closeShareModal();
        }, 1500);
    }
</script>
@endpush
@endsection
