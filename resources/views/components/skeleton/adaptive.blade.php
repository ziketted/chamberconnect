@props([
    'type' => 'chamber', // chamber, event, list, stat
    'count' => 3,
    'responsive' => true
])

<!-- Skeleton adaptatif qui change selon l'espace disponible -->
<div class="skeleton-adaptive" data-type="{{ $type }}" data-count="{{ $count }}">
    @if($type === 'chamber')
        <!-- Chambres suggérées - adaptatif -->
        <div class="space-y-4">
            @for($i = 0; $i < $count; $i++)
                <!-- Version desktop/tablet -->
                <div class="hidden md:block">
                    <x-skeleton.chamber-card variant="default" />
                </div>
                
                <!-- Version mobile -->
                <div class="block md:hidden">
                    <x-skeleton.chamber-card variant="compact" />
                </div>
            @endfor
        </div>

    @elseif($type === 'event')
        <!-- Événements - adaptatif -->
        <div class="space-y-4">
            @for($i = 0; $i < $count; $i++)
                <!-- Version desktop -->
                <div class="hidden lg:block">
                    <x-skeleton.event-card variant="default" />
                </div>
                
                <!-- Version tablet -->
                <div class="hidden md:block lg:hidden">
                    <x-skeleton.event-card variant="compact" />
                </div>
                
                <!-- Version mobile -->
                <div class="block md:hidden">
                    <x-skeleton.event-card variant="list" />
                </div>
            @endfor
        </div>

    @elseif($type === 'stats')
        <!-- Statistiques - grille responsive -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($count, 4) }} gap-4">
            @for($i = 0; $i < $count; $i++)
                <x-skeleton.stat-card />
            @endfor
        </div>

    @else
        <!-- Liste générique -->
        <div class="space-y-2">
            @for($i = 0; $i < $count; $i++)
                <!-- Version desktop -->
                <div class="hidden md:block">
                    <x-skeleton.list-item variant="default" />
                </div>
                
                <!-- Version mobile -->
                <div class="block md:hidden">
                    <x-skeleton.list-item variant="compact" />
                </div>
            @endfor
        </div>
    @endif
</div>

@if($responsive)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour adapter les skeletons selon la taille de l'écran
    function adaptSkeletons() {
        const containers = document.querySelectorAll('.skeleton-adaptive');
        
        containers.forEach(container => {
            const type = container.dataset.type;
            const rect = container.getBoundingClientRect();
            const width = rect.width;
            
            // Adapter selon la largeur disponible
            if (width < 300) {
                // Très petit espace - version minimale
                container.classList.add('skeleton-minimal');
                container.classList.remove('skeleton-compact', 'skeleton-default');
            } else if (width < 500) {
                // Espace moyen - version compacte
                container.classList.add('skeleton-compact');
                container.classList.remove('skeleton-minimal', 'skeleton-default');
            } else {
                // Grand espace - version par défaut
                container.classList.add('skeleton-default');
                container.classList.remove('skeleton-minimal', 'skeleton-compact');
            }
        });
    }
    
    // Adapter au chargement
    adaptSkeletons();
    
    // Adapter lors du redimensionnement
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(adaptSkeletons, 100);
    });
});
</script>
@endpush

@push('styles')
<style>
/* Styles pour les skeletons adaptatifs */
.skeleton-adaptive.skeleton-minimal .skeleton-default-only {
    display: none;
}

.skeleton-adaptive.skeleton-compact .skeleton-default-only {
    display: none;
}

.skeleton-adaptive.skeleton-minimal .skeleton-compact-only {
    display: none;
}

/* Animation de shimmer améliorée */
@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

.skeleton-adaptive .animate-pulse {
    animation: shimmer 2s infinite linear;
}

/* Responsive breakpoints personnalisés */
@media (max-width: 300px) {
    .skeleton-adaptive .chamber-card {
        padding: 0.5rem;
    }
    
    .skeleton-adaptive .event-card {
        padding: 0.75rem;
    }
}
</style>
@endpush
@endif