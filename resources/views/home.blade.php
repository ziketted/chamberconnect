@extends('layouts.app')

@section('content')
<style>
    @keyframes slideInFromLeft {
        0% {
            transform: translateX(-100%);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInFromRight {
        0% {
            transform: translateX(100%);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInFromBottom {
        0% {
            transform: translateY(50px);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeInScale {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .slide-in-left {
        animation: slideInFromLeft 1s ease-out forwards;
    }

    .slide-in-right {
        animation: slideInFromRight 1s ease-out forwards;
    }

    .slide-in-bottom {
        animation: slideInFromBottom 0.8s ease-out forwards;
    }

    .fade-in-scale {
        animation: fadeInScale 1.2s ease-out forwards;
    }

    .video-overlay {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(7, 48, 102, 0.3) 50%, rgba(0, 0, 0, 0.8) 100%);
    }

    .hero-content {
        animation-delay: 0.3s;
    }

    .hero-badge {
        animation-delay: 0.5s;
    }

    .hero-title {
        animation-delay: 0.7s;
    }

    .hero-description {
        animation-delay: 0.9s;
    }

    .hero-buttons {
        animation-delay: 1.1s;
    }
</style>

<div class="space-y-14">
    <!-- Hero with Video Background -->
    <div class="overflow-hidden rounded-2xl border border-neutral-200 shadow-sm">
        <div class="relative isolate">
            <!-- Video Background -->
            <video autoplay muted loop playsinline class="absolute inset-0 h-[460px] w-full object-cover">
                <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
                <!-- Fallback image if video doesn't load -->
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-[460px] w-full object-cover">
            </video>

            <!-- Animated Overlay -->
            <div class="absolute inset-0 video-overlay"></div>

            <!-- Content with Slide Animations -->
            <div class="relative z-10 flex h-[460px] items-center">
                <div class="max-w-2xl p-8 sm:p-12 hero-content slide-in-left">
                    <div
                        class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white ring-1 ring-white/20 backdrop-blur hero-badge slide-in-bottom">
                        <i data-lucide="shield-check" class="h-4 w-4 text-white"></i>
                        {{ __('messages.accredited_chamber') }}
                    </div>
                    <h1 class="text-white text-4xl sm:text-5xl font-semibold tracking-tight hero-title slide-in-left">
                        {{ __('messages.tagline') }}
                    </h1>
                    <p class="mt-3 text-neutral-200 text-base hero-description slide-in-left">
                        {{ __('messages.description') }}
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3 hero-buttons slide-in-bottom">
                        @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 transform hover:scale-105 transition-all duration-300">
                            <i data-lucide="compass" class="h-4 w-4"></i>
                            {{ __('messages.explore_chambers') }}
                        </a>
                        @else
                        <button onclick="openModal('signin-modal')"
                            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 transform hover:scale-105 transition-all duration-300">
                            <i data-lucide="compass" class="h-4 w-4"></i>
                            {{ __('messages.explore_chambers') }}
                        </button>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#fcb357] px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-[#fcb357]/30 hover:bg-[#f5a742] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70 transform hover:scale-105 transition-all duration-300">
                            <i data-lucide="user-plus" class="h-4 w-4"></i>
                            {{ __('messages.join_now') }}
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Application Section -->
    <section aria-labelledby="about-title" class="space-y-8">


        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Feature 1: Networking -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#073066]/10 rounded-xl flex items-center justify-center">
                        <i data-lucide="users" class="h-6 w-6 text-[#073066]"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Réseau Professionnel</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    Connectez-vous avec des entrepreneurs, investisseurs et décideurs. Participez à des événements
                    exclusifs et développez votre réseau d'affaires.
                </p>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Forums d'affaires mensuels
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Sessions de networking ciblées
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Rencontres B2B personnalisées
                    </li>
                </ul>
            </div>

            <!-- Feature 2: Business Opportunities -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#fcb357]/10 rounded-xl flex items-center justify-center">
                        <i data-lucide="trending-up" class="h-6 w-6 text-[#fcb357]"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Opportunités d'Affaires</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    Découvrez des opportunités exclusives, trouvez des partenaires stratégiques et accédez à des marchés
                    locaux et internationaux.
                </p>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Appels d'offres privilégiés
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Partenariats internationaux
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Accès aux marchés émergents
                    </li>
                </ul>
            </div>

            <!-- Feature 3: Support & Resources -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#b81010]/10 rounded-xl flex items-center justify-center">
                        <i data-lucide="shield-check" class="h-6 w-6 text-[#b81010]"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Accompagnement Expert</h3>
                </div>
                <p class="text-gray-600 mb-4">
                    Bénéficiez de l'expertise de nos conseillers, accédez à des formations spécialisées et obtenez un
                    soutien personnalisé pour votre croissance.
                </p>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Conseil stratégique personnalisé
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Formations et ateliers
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4 text-green-500"></i>
                        Support réglementaire
                    </li>
                </ul>
            </div>
        </div>

        <!-- Statistics Section -->
        <div
            class="relative bg-gradient-to-r from-[#073066]/90 to-[#052347]/90 rounded-2xl p-8 text-white overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-30 blur-sm"
                style="background-image: url('{{ asset('chambres.png') }}')"></div>
            <div class="relative z-10">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold mb-2">ChamberConnect en Chiffres</h3>
                    <p class="text-white/90">Notre impact sur l'écosystème entrepreneurial congolais</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">500+</div>
                        <div class="text-sm text-white/80">Entreprises Membres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">150+</div>
                        <div class="text-sm text-white/80">Événements Organisés</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">2M+</div>
                        <div class="text-sm text-white/80">USD d'Affaires Générées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">25+</div>
                        <div class="text-sm text-white/80">Partenaires Internationaux</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News & Updates -->
    <section aria-labelledby="news-title" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 id="news-title" class="text-2xl font-semibold tracking-tight">{{ __('messages.latest_news') }}</h2>
            <a href="#" class="text-sm font-medium text-[#073066] hover:underline">{{ __('messages.view_all') }}</a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card 1 -->
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1550948390-6eb7fa773072?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-40 w-full object-cover">
                <div class="p-5">
                    <h3 class="text-base font-semibold leading-snug">DRC Exports Surge as New Trade Policies Take Effect
                    </h3>
                    <p class="mt-2 text-sm text-neutral-600">Government-backed incentives are boosting exports across
                        key sectors...</p>
                    <div class="mt-3">
                        <a href="#"
                            class="inline-flex items-center gap-1 text-sm font-medium text-[#073066] hover:underline">
                            {{ __('messages.read_more') }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 2 -->
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-40 w-full object-cover">
                <div class="p-5">
                    <h3 class="text-base font-semibold leading-snug">Entrepreneurship Week: Workshops Announced</h3>
                    <p class="mt-2 text-sm text-neutral-600">From funding to export-readiness: practical sessions to
                        scale your business...</p>
                    <div class="mt-3">
                        <a href="#"
                            class="inline-flex items-center gap-1 text-sm font-medium text-[#073066] hover:underline">
                            {{ __('messages.read_more') }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 3 -->
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-40 w-full object-cover">
                <div class="p-5">
                    <h3 class="text-base font-semibold leading-snug">Market Outlook: Q4 Forecasts Signal Steady Growth
                    </h3>
                    <p class="mt-2 text-sm text-neutral-600">Analysts expect stabilizing supply chains to drive
                        consistent performance...</p>
                    <div class="mt-3">
                        <a href="#"
                            class="inline-flex items-center gap-1 text-sm font-medium text-[#073066] hover:underline">
                            {{ __('messages.read_more') }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Partners -->
    <section aria-labelledby="partners-title" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 id="partners-title" class="text-2xl font-semibold tracking-tight">{{ __('messages.our_partners') }}</h2>
            <span class="text-xs text-neutral-500">{{ __('messages.partners_subtitle') }}</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach(['AL' => 'Alto Labs', 'NV' => 'Novix', 'PR' => 'Prax', 'SE' => 'Seren', 'UX' => 'UXON', 'KO' =>
            'Kora'] as $initials => $name)
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center">
                <span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-[#fcb357]/10 text-[#073066] text-sm font-semibold tracking-tight">{{
                    $initials }}</span>
                <div class="mt-2 text-sm font-medium">{{ $name }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Testimonials -->
    <section aria-labelledby="testimonials-title" class="space-y-6">
        <h2 id="testimonials-title" class="text-2xl font-semibold tracking-tight">{{ __('messages.testimonials_title')
            }}</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Testimonial 1 -->
            <figure class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
                <blockquote class="text-sm text-neutral-700">"The platform helped us meet distributors within weeks. The
                    events calendar is a game-changer."</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400&auto=format&fit=crop"
                        alt="">
                    <div>
                        <div class="text-sm font-semibold">Amina K.</div>
                        <div class="text-xs text-neutral-500">Founder, Kivu Agro</div>
                    </div>
                </figcaption>
            </figure>

            <!-- Testimonial 2 -->
            <figure class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
                <blockquote class="text-sm text-neutral-700">"Networking has never been this efficient. We booked two
                    deals after the last forum."</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=400&auto=format&fit=crop"
                        alt="">
                    <div>
                        <div class="text-sm font-semibold">Jean P.</div>
                        <div class="text-xs text-neutral-500">COO, Lumumba Logistics</div>
                    </div>
                </figcaption>
            </figure>

            <!-- Testimonial 3 -->
            <figure class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
                <blockquote class="text-sm text-neutral-700">"A trusted hub for small businesses to scale and connect
                    with investors."</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=400&auto=format&fit=crop"
                        alt="">
                    <div>
                        <div class="text-sm font-semibold">Chantal M.</div>
                        <div class="text-xs text-neutral-500">CEO, KinTech Labs</div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm">
        <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-xl sm:text-2xl font-semibold tracking-tight">{{ __('messages.join_cta_title') }}</h3>
                <p class="mt-1 text-sm text-neutral-600">{{ __('messages.join_cta_description') }}</p>
            </div>
            @guest
            <a href="{{ route('register') }}"
                class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066]/50">
                <i data-lucide="rocket" class="h-4 w-4"></i>
                {{ __('messages.join_now') }}
            </a>
            @else
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066]/50">
                <i data-lucide="rocket" class="h-4 w-4"></i>
                {{ __('messages.explore_chambers') }}
            </a>
            @endguest
        </div>
    </section>
</div>
@endsection