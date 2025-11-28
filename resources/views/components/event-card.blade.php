@props(['event'])

@php
// Protection contre les erreurs
if (!$event || !$event->chamber) {
return;
}

$chamber = $event->chamber;
$isLiked = auth()->check() ? $event->isLikedBy(auth()->user()) : false;
$availableSpots = $event->availableSpots();

// Déterminer si la chambre est vérifiée
$isUserChamber = auth()->check() ? auth()->user()->chambers->contains($chamber->id) : false;

// Déterminer le texte de localisation
if ($event->mode === 'online' || $event->mode === 'en_ligne') {
$locationText = 'En ligne';
} elseif ($event->mode === 'hybrid' || $event->mode === 'hybride') {
$locationText = 'Hybride';
} else {
// Mode présentiel
if ($event->city && $event->country) {
$locationText = "{$event->city}, {$event->country}";
} elseif ($event->address) {
$locationText = $event->address;
} elseif ($event->location) {
$locationText = $event->location;
} else {
$locationText = 'Lieu à confirmer';
}
}
@endphp

<article
    class="event-card bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-gray-700 transition-all duration-300"
    data-type="{{ $event->type ?? 'conference' }}" data-verified="{{ $chamber->verified ? 'true' : 'false' }}"
    data-available="{{ $availableSpots > 0 ? 'true' : 'false' }}" data-title="{{ strtolower($event->title) }}"
    data-description="{{ strtolower($event->description ?? '') }}" data-chamber="{{ strtolower($chamber->name) }}"
    data-date="{{ $event->date->format('Y-m-d') }}" data-participants="{{ $event->participants()->count() }}"
    data-max-participants="{{ $event->max_participants ?? 0 }}">
    <div class="p-5">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                @if($chamber->logo_path)
                <img src="{{ asset('storage/' . $chamber->logo_path) }}" alt="{{ $chamber->name }}"
                    class="w-12 h-12 rounded-xl object-cover flex-shrink-0 ring-2 ring-gray-800">
                @else
                <div
                    class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 ring-2 ring-gray-800">
                    <span class="text-white font-bold text-sm">{{ substr($chamber->name, 0, 2) }}</span>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-white truncate">{{ $chamber->name }}</h4>
                    <p class="text-xs text-gray-400 truncate">{{ $chamber->location ?? 'Localisation' }}</p>
                </div>
            </div>
            <button type="button" class="text-gray-400 hover:text-white transition-colors p-1 -mr-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </button>
        </div>

        <h3 class="text-xl font-bold text-white mb-4 line-clamp-2 leading-tight">{{ $event->title }}</h3>

        <div class="space-y-2.5 mb-4">
            <div class="flex items-center gap-2.5 text-sm text-gray-300">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $event->date->locale('fr')->isoFormat('DD MMM') }} à {{ $event->time }}</span>
            </div>

            <div class="flex items-center gap-2.5 text-sm text-gray-300">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate">{{ $locationText }}</span>
            </div>

            @if($event->max_participants)
            <div class="flex items-center gap-2.5 text-sm {{ $availableSpots > 0 ? 'text-gray-300' : 'text-red-400' }}">
                <svg class="w-5 h-5 {{ $availableSpots > 0 ? 'text-gray-400' : 'text-red-400' }} flex-shrink-0"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>
                    @if($availableSpots > 0)
                    {{ $availableSpots }} {{ $availableSpots > 1 ? 'places restantes' : 'place restante' }}
                    @else
                    Complet
                    @endif
                </span>
            </div>
            @endif
        </div>

        <p class="text-sm text-gray-400 leading-relaxed mb-5 line-clamp-3">
            {{ Str::limit($event->description, 150) }}
        </p>

        <div class="flex items-center gap-2 pt-4 border-t border-gray-800">
            <button type="button" onclick="toggleEventLike(this, {{ $event->id }})"
                class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-700 text-gray-400 hover:text-white hover:border-gray-600 text-sm font-medium transition-all duration-200">
                <svg class="w-4 h-4 {{ $isLiked ? 'fill-current' : '' }}"
                    fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="like-count">{{ $event->likes()->count() }}</span>
            </button>

            <button type="button" onclick="shareEvent({{ $event->id }}, '{{ $event->title }}')"
                class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-700 text-gray-400 hover:text-white hover:border-gray-600 text-sm font-medium transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
            </button>

            <a href="{{ route('events.show', $event->id) }}"
                class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-gray-700 text-gray-400 hover:text-white hover:border-gray-600 text-sm font-medium transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>

            @if(!$event->isFull())
            <a href="{{ route('events.booking', $event->id) }}"
                class="flex-1 flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-blue-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Réserver une place</span>
            </a>
            @else
            <button disabled
                class="flex-1 flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-gray-700 text-gray-400 text-sm font-semibold cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                <span>Complet</span>
            </button>
            @endif
        </div>
    </div>
</article>

@push('scripts')
<script>
    // Fonction pour gérer le like d'un événement
    window.toggleEventLike = function(button, eventId) {
        const icon = button.querySelector('svg');
        const likeCountElement = button.querySelector('.like-count');

        // Désactiver temporairement
        button.disabled = true;

        // Appel AJAX
        fetch(`/events/${eventId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Mettre à jour l'icône (remplie ou vide)
            if (data.liked) {
                icon.setAttribute('fill', 'currentColor');
                icon.classList.add('fill-current');
            } else {
                icon.setAttribute('fill', 'none');
                icon.classList.remove('fill-current');
            }

            // Mettre à jour le compteur
            if (likeCountElement) {
                likeCountElement.textContent = data.likes_count;
            }

            // Animation du bouton
            button.style.transform = 'scale(0.9)';
            setTimeout(() => {
                button.style.transform = 'scale(1)';
            }, 150);
        })
        .catch(error => {
            console.error('Erreur lors du like:', error);
            showToast('❌ Erreur lors de l\'action', 'error');
        })
        .finally(() => {
            // Réactiver le bouton
            button.disabled = false;
        });
    };

    window.shareEvent = function(eventId, eventTitle) {
        const eventUrl = `${window.location.origin}/events/${eventId}`;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(eventUrl).then(() => {
                showToast('Lien copié dans le presse-papiers!', 'success');
            }).catch(() => {
                showToast('Erreur lors de la copie du lien', 'error');
            });
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = eventUrl;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showToast('Lien copié dans le presse-papiers!', 'success');
            } catch (err) {
                showToast('Erreur lors de la copie du lien', 'error');
            }
            document.body.removeChild(textArea);
        }
    };

    window.showToast = function(message, type = 'info') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600';
        const icon = type === 'success'
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';

        toast.className = `fixed top-4 right-4 z-[9999] ${bgColor} text-white px-5 py-3 rounded-lg shadow-2xl flex items-center gap-3 transform transition-all duration-300 translate-x-full`;
        toast.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icon}
            </svg>
            <span class="font-medium">${message}</span>
        `;

        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full');
            });
        });

        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    };
</script>
@endpush