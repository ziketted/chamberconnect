@extends('layouts.app')

@section('content')
<style>
    /* Animation fluides façon Glencore */
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        0% {
            opacity: 0;
            transform: scale(0.95);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .fade-in-up {
        animation: fadeInUp 1s ease-out forwards;
        opacity: 0;
    }

    .fade-in {
        animation: fadeIn 1.2s ease-out forwards;
        opacity: 0;
    }

    .scale-in {
        animation: scaleIn 0.8s ease-out forwards;
        opacity: 0;
    }

    .delay-100 {
        animation-delay: 0.1s;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }

    .delay-400 {
        animation-delay: 0.4s;
    }

    .delay-500 {
        animation-delay: 0.5s;
    }

    .delay-600 {
        animation-delay: 0.6s;
    }

    /* Hero overlay premium */
    .hero-overlay {
        background: linear-gradient(to right, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.6) 100%);
    }

    /* Scroll reveal */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }

    /* Pulse animation for exchange rate */
    @keyframes pulse-subtle {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.8;
        }
    }

    .pulse-subtle {
        animation: pulse-subtle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Hero Section Fullscreen - Style Glencore -->
<section class="relative h-[calc(100vh-64px)] w-full overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
        <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop"
            alt="Corporate Background" class="w-full h-full object-cover">
    </video>

    <!-- Overlay sombre premium -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>

    <!-- Contenu Hero -->
    <div class="relative h-full flex items-center">
        <div class="w-full max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="max-w-4xl">
                <!-- Badge institutionnel -->
                <div class="fade-in-up mb-8">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        {{ __('messages.accredited_chamber') }}
                    </span>
                </div>

                <!-- Titre premium -->
                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight tracking-tight mb-6 fade-in-up delay-100">
                    {{ __('messages.tagline') }}
                </h1>

                <!-- Description élégante -->
                <p class="text-lg sm:text-xl text-gray-200 leading-relaxed mb-8 max-w-2xl fade-in-up delay-200">
                    {{ __('messages.description') }}
                </p>

                <!-- Taux de change -->
                <div class="mb-8 fade-in-up delay-250">
                    <div
                        class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-3 rounded-lg hover:bg-white/15 transition-all duration-300 group">
                        <svg class="w-5 h-5 text-green-400 pulse-subtle" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-white">
                            <span class="text-sm opacity-80">Taux du jour:</span>
                            <span class="ml-2 font-bold text-lg group-hover:text-green-400 transition-colors">1 USD = {{
                                number_format($exchangeRate, 0, ',', ' ') }} CDF</span>
                        </div>
                    </div>
                </div>

                <!-- CTA Buttons Premium -->
                <div class="flex flex-wrap gap-4 fade-in-up delay-300">
                    <a href="{{ route('chambers') }}"
                        class="group inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-none font-semibold text-base transition-all duration-300 hover:translate-x-1">
                        <span>Découvrir les chambres</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    @guest
                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center gap-3 bg-white hover:bg-gray-100 text-gray-900 px-8 py-4 rounded-none font-semibold text-base transition-all duration-300 hover:translate-x-1">
                        <span>{{ __('messages.join_now') }}</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 fade-in delay-600">
        <div class="flex flex-col items-center gap-2 text-white/60 animate-bounce">
            <span class="text-[10px] uppercase tracking-[0.2em]">Découvrir</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7-7-7" />
            </svg>
        </div>
    </div>
</section>

<!-- About Section - Style Two Columns -->
<section class="bg-gray-50 dark:bg-gray-800 py-24 lg:py-32">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- Left Column - Content -->
            <div class="scroll-reveal">
                <!-- Section Header -->
                <div class="mb-8">
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-4 block">Pourquoi
                        Investir en RDC</span>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                        Rejoignez l'Écosystème d'Affaires le Plus Dynamique d'Afrique Centrale
                    </h2>
                </div>

                <!-- Description -->
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    La République Démocratique du Congo offre des opportunités d'investissement exceptionnelles.
                    Avec ses ressources naturelles abondantes, sa population jeune et dynamique, et son marché en pleine
                    expansion,
                    la RDC est la destination privilégiée des investisseurs visionnaires.
                </p>

                <!-- Key Benefits List -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4 group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Marché en Forte Croissance
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Plus de 100 millions d'habitants avec un pouvoir
                                d'achat croissant et une classe moyenne émergente.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Ressources Naturelles
                                Exceptionnelles</h3>
                            <p class="text-gray-600 dark:text-gray-400">Leader mondial en cobalt, cuivre, diamants et
                                autres minerais stratégiques pour l'économie mondiale.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Réseau d'Affaires Solide
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Connectez-vous avec des entrepreneurs locaux,
                                des investisseurs internationaux et des décideurs clés.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Accompagnement Personnalisé
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Support complet pour naviguer le climat des
                                affaires, de l'enregistrement à l'expansion de votre entreprise.</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('chambers') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:translate-x-1">
                        <span>Découvrir les opportunités</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Column - Image -->
            <div class="scroll-reveal relative" style="animation-delay: 0.2s;">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <!-- Main Image -->
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1200&auto=format&fit=crop"
                        alt="Investisseur professionnel en RDC" class="w-full h-[600px] object-cover">

                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                    <!-- Stats Overlay Card -->
                    <div
                        class="absolute bottom-8 left-8 right-8 bg-white dark:bg-gray-900 rounded-xl p-6 shadow-xl backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-3xl font-bold text-blue-600 mb-1">500+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Investisseurs</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-blue-600 mb-1">2M+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">USD Investis</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-blue-600 mb-1">25+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Secteurs</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-600 rounded-full opacity-20 blur-2xl"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-blue-400 rounded-full opacity-20 blur-2xl"></div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Features Section -->
<section class="bg-white dark:bg-gray-900 py-16">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
            <!-- Feature 1 - Networking -->
            <div class="scroll-reveal text-center group">
                <div
                    class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Networking Exclusif</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Événements mensuels, forums d'affaires et rencontres B2B avec des décideurs clés
                </p>
            </div>

            <!-- Feature 2 - Opportunities -->
            <div class="scroll-reveal text-center group" style="animation-delay: 0.1s;">
                <div
                    class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Opportunités d'Affaires</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Accès privilégié aux appels d'offres, partenariats internationaux et marchés émergents
                </p>
            </div>

            <!-- Feature 3 - Support -->
            <div class="scroll-reveal text-center group" style="animation-delay: 0.2s;">
                <div
                    class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Support Complet</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Accompagnement personnalisé, formations spécialisées et assistance réglementaire
                </p>
            </div>
        </div>

    </div>
</section>

<!-- Statistics Section Premium - Fullscreen -->
<section
    class="scroll-reveal relative bg-gradient-to-br from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 py-24 lg:py-32 overflow-hidden">
    <!-- Pattern background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('chambres.png') }}')">
        </div>
    </div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">ChamberConnect en Chiffres</h2>
            <p class="text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto">Notre impact sur l'écosystème entrepreneurial
                congolais</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-16">
            <div class="text-center group">
                <div
                    class="text-5xl lg:text-7xl font-bold text-white mb-4 transition-transform duration-300 group-hover:scale-110">
                    500+</div>
                <div class="text-lg lg:text-xl text-blue-100">Entreprises Membres</div>
            </div>
            <div class="text-center group">
                <div
                    class="text-5xl lg:text-7xl font-bold text-white mb-4 transition-transform duration-300 group-hover:scale-110">
                    150+</div>
                <div class="text-lg lg:text-xl text-blue-100">Événements Organisés</div>
            </div>
            <div class="text-center group">
                <div
                    class="text-5xl lg:text-7xl font-bold text-white mb-4 transition-transform duration-300 group-hover:scale-110">
                    2M+</div>
                <div class="text-lg lg:text-xl text-blue-100">USD d'Affaires Générées</div>
            </div>
            <div class="text-center group">
                <div
                    class="text-5xl lg:text-7xl font-bold text-white mb-4 transition-transform duration-300 group-hover:scale-110">
                    25+</div>
                <div class="text-lg lg:text-xl text-blue-100">Partenaires Internationaux</div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section - Prochains Événements -->
<section class="bg-gray-50 dark:bg-gray-800 py-24 lg:py-32">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <!-- Section Header -->
        <div class="flex items-end justify-between mb-16 scroll-reveal">
            <div>
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-4 block">Actualités</span>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">Événements à Venir</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">Découvrez les prochains événements organisés
                    par nos chambres</p>
            </div>
            @auth
            <a href="{{ route('events') }}"
                class="hidden sm:flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                Voir tout
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            @else
            <button onclick="openModal('signin-modal')" title="Connectez-vous pour voir tous les événements"
                class="hidden sm:flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition-all duration-300 hover:gap-3 group">
                <span>Voir tout</span>
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </button>
            @endauth
        </div>

        <!-- Events Grid -->
        @if($upcomingEvents->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
            @foreach($upcomingEvents as $index => $event)
            <article
                class="scroll-reveal group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700"
                style="animation-delay: {{ $index * 0.1 }}s;">
                <!-- Event Image -->
                <div class="relative overflow-hidden aspect-[16/10]">
                    @if($event->cover_image_path)
                    <img src="{{ asset('storage/' . $event->cover_image_path) }}" alt="{{ $event->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div
                        class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif

                    <!-- Chamber Logo Badge (Top Left) -->
                    @if($event->chamber)
                    <div class="absolute top-4 left-4">
                        <div
                            class="w-12 h-12 rounded-full overflow-hidden bg-white dark:bg-gray-800 shadow-lg border-2 border-white dark:border-gray-700 backdrop-blur-sm">
                            @if($event->chamber->logo_path)
                            <img src="{{ asset('storage/' . $event->chamber->logo_path) }}"
                                alt="{{ $event->chamber->name }}" class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center\'><span class=\'text-xs font-bold text-white\'>{{ strtoupper(substr($event->chamber->name, 0, 2)) }}</span></div>';">
                            @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                <span class="text-sm font-bold text-white">
                                    {{ strtoupper(substr($event->chamber->name, 0, 2)) }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Event Status Badge -->
                    <div class="absolute top-4 right-4">
                        @if($event->status === 'full')
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-500 text-white text-xs font-semibold shadow-lg">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            Complet
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-500 text-white text-xs font-semibold shadow-lg">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Places disponibles
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Event Content -->
                <div class="p-6">
                    <!-- Date & Location -->
                    <div class="flex items-center gap-4 mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                        </div>
                        @if($event->location)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate">{{ Str::limit($event->location, 20) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Event Title -->
                    <h3
                        class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $event->title }}
                    </h3>

                    <!-- Event Description -->
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4 line-clamp-2">
                        {{ Str::limit(strip_tags($event->description), 100) }}
                    </p>

                    <!-- Chamber Badge -->
                    @if($event->chamber)
                    <div
                        class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700 group/chamber">
                        <div
                            class="relative w-10 h-10 rounded-full overflow-hidden bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 flex-shrink-0 transition-transform duration-300 group-hover/chamber:scale-110">
                            @if($event->chamber->logo_path)
                            <img src="{{ asset('storage/' . $event->chamber->logo_path) }}"
                                alt="{{ $event->chamber->name }}" class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center\'><span class=\'text-xs font-bold text-white\'>{{ strtoupper(substr($event->chamber->name, 0, 2)) }}</span></div>';">
                            @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                <span class="text-xs font-bold text-white">
                                    {{ strtoupper(substr($event->chamber->name, 0, 2)) }}
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white block truncate group-hover/chamber:text-blue-600 dark:group-hover/chamber:text-blue-400 transition-colors">
                                {{ $event->chamber->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                Organisateur
                            </span>
                        </div>
                    </div>
                    @endif

                    <!-- Event Stats & CTA -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ $event->participants_count }}/{{ $event->max_participants }}</span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', $event) }}"
                            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors text-sm">
                            Voir détails
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <!-- No Events Message -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucun événement à venir</h3>
            <p class="text-gray-600 dark:text-gray-400">Revenez bientôt pour découvrir nos prochains événements</p>
        </div>
        @endif
    </div>
</section>

<!-- Partners Section - Professional Design -->
<section class="bg-white dark:bg-gray-900 py-24 lg:py-32">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <!-- Section Header -->
        <div class="mb-16 scroll-reveal text-center">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-4 block">Nos Partenaires
                Institutionnels</span>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Ils Nous Font Confiance
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                En partenariat avec les principales institutions publiques et privées de la RDC pour faciliter vos
                démarches et sécuriser vos investissements
            </p>
        </div>

        <!-- Partners Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 lg:gap-12">
            <!-- Partner 1: ANAPI -->
            <div class="scroll-reveal group relative">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/anapi.png') }}"
                            alt="ANAPI - Agence Nationale pour la Promotion des Investissements"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Agence Nationale pour la Promotion des Investissements
                        </p>
                        <p class="text-xs text-gray-300 leading-relaxed">Facilite l'enregistrement des entreprises et
                            accompagne les investisseurs dans leurs démarches administratives et réglementaires en RDC.
                        </p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    ANAPI</p>
            </div>

            <!-- Partner 2: BCC -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.1s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/bcc.png') }}" alt="BCC - Banque Centrale du Congo"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Banque Centrale du Congo</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Régule la politique monétaire, supervise le
                            système bancaire et facilite les opérations de change pour les investisseurs internationaux.
                        </p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    BCC</p>
            </div>

            <!-- Partner 3: DGI -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.2s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/dgi.png') }}" alt="DGI - Direction Générale des Impôts"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Direction Générale des Impôts</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Gère la fiscalité des entreprises, délivre les
                            numéros d'identification fiscale et accompagne les investisseurs dans leurs obligations
                            fiscales.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    DGI</p>
            </div>

            <!-- Partner 4: DGDA -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.3s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/dgda.jpg') }}"
                            alt="DGDA - Direction Générale des Douanes et Accises"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Direction Générale des Douanes et Accises</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Facilite les procédures douanières pour
                            l'import-export et accompagne les entreprises dans la conformité réglementaire des échanges
                            commerciaux.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    DGDA</p>
            </div>

            <!-- Partner 5: FPI -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.4s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/fpi.png') }}" alt="FPI - Fédération des PME"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Fédération des Petites et Moyennes Entreprises</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Représente et défend les intérêts des PME,
                            offre des services de formation et facilite l'accès au financement pour les petites
                            entreprises.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    FPI</p>
            </div>

            <!-- Partner 6: Commerce -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.5s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/commerce.png') }}" alt="Ministère du Commerce"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Ministère du Commerce</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Élabore et met en œuvre la politique
                            commerciale nationale, délivre les licences d'import-export et régule les activités
                            commerciales en RDC.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    Ministère du Commerce</p>
            </div>

            <!-- Partner 7: ANADEC -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.6s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/anadec.png') }}" alt="ANADEC"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Agence Nationale de Développement des Compétences</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Forme et certifie les professionnels, développe
                            les compétences locales et accompagne les entreprises dans le renforcement des capacités
                            humaines.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    ANADEC</p>
            </div>

            <!-- Partner 8: AZES -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.7s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/azes.jpg') }}" alt="AZES"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Agence des Zones Économiques Spéciales</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Gère les zones économiques spéciales, offre des
                            incitations fiscales et facilite l'implantation d'entreprises dans des zones à fort
                            potentiel de développement.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    AZES</p>
            </div>

            <!-- Partner 9: ZELCAF -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.8s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/zelcaf.jpg') }}" alt="ZELCAF"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Zone Économique Libre de Kinshasa</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Zone franche offrant des avantages fiscaux et
                            douaniers exceptionnels, infrastructure moderne et services intégrés pour les investisseurs
                            internationaux.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    ZELCAF</p>
            </div>

            <!-- Partner 10: SEGUCE RDC -->
            <div class="scroll-reveal group relative" style="animation-delay: 0.9s;">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="aspect-square flex items-center justify-center">
                        <img src="{{ asset('img/partenaires/seguce.png') }}" alt="SEGUCE RDC"
                            class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <div
                        class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-5 rounded-2xl transition-opacity duration-300">
                    </div>

                    <!-- Tooltip -->
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-4 py-3 bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 w-72 z-20 shadow-2xl pointer-events-none">
                        <p class="font-bold mb-1.5 text-blue-400">Secrétariat Général à l'Entrepreneuriat</p>
                        <p class="text-xs text-gray-300 leading-relaxed">Coordonne les politiques d'entrepreneuriat,
                            soutient les startups et PME, et facilite l'accès aux programmes de financement et
                            d'accompagnement pour les jeunes entrepreneurs.</p>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                            <div class="border-6 border-transparent border-t-gray-900 dark:border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-center mt-4 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    SEGUCE RDC</p>
            </div>
        </div>

        <!-- Trust Badge -->
        <div class="mt-16 text-center scroll-reveal">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-blue-50 dark:bg-blue-900/20 rounded-full">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                    Partenariats officiels pour faciliter vos démarches administratives et commerciales
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section - Premium -->
<section class="bg-gray-50 dark:bg-gray-800 py-24 lg:py-32">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-16 scroll-reveal">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-4 block">Témoignages</span>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">{{
                __('messages.testimonials_title') }}</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8 lg:gap-10">
            <!-- Testimonial 1 -->
            <figure
                class="scroll-reveal bg-white dark:bg-gray-900 rounded-2xl p-8 hover:shadow-xl transition-shadow duration-300">
                <svg class="w-10 h-10 text-blue-600 mb-6" fill="currentColor" viewBox="0 0 32 32">
                    <path
                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                </svg>
                <blockquote class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    "The platform helped us meet distributors within weeks. The events calendar is a game-changer."
                </blockquote>
                <figcaption class="flex items-center gap-4">
                    <img class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400&auto=format&fit=crop"
                        alt="Amina K.">
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">Amina K.</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Founder, Kivu Agro</div>
                    </div>
                </figcaption>
            </figure>

            <!-- Testimonial 2 -->
            <figure
                class="scroll-reveal bg-white dark:bg-gray-900 rounded-2xl p-8 hover:shadow-xl transition-shadow duration-300"
                style="animation-delay: 0.1s;">
                <svg class="w-10 h-10 text-blue-600 mb-6" fill="currentColor" viewBox="0 0 32 32">
                    <path
                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                </svg>
                <blockquote class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    "Networking has never been this efficient. We booked two deals after the last forum."
                </blockquote>
                <figcaption class="flex items-center gap-4">
                    <img class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                        src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=400&auto=format&fit=crop"
                        alt="Jean P.">
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">Jean P.</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">COO, Lumumba Logistics</div>
                    </div>
                </figcaption>
            </figure>

            <!-- Testimonial 3 -->
            <figure
                class="scroll-reveal bg-white dark:bg-gray-900 rounded-2xl p-8 hover:shadow-xl transition-shadow duration-300"
                style="animation-delay: 0.2s;">
                <svg class="w-10 h-10 text-blue-600 mb-6" fill="currentColor" viewBox="0 0 32 32">
                    <path
                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                </svg>
                <blockquote class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    "A trusted hub for small businesses to scale and connect with investors."
                </blockquote>
                <figcaption class="flex items-center gap-4">
                    <img class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                        src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=400&auto=format&fit=crop"
                        alt="Chantal M.">
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">Chantal M.</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">CEO, KinTech Labs</div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
</section>

<!-- Final CTA Section - Premium Glencore Style -->
<section class="bg-gradient-to-br from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 py-24 lg:py-32">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="max-w-4xl mx-auto text-center scroll-reveal">
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                {{ __('messages.join_cta_title') }}
            </h2>
            <p class="text-xl lg:text-2xl text-blue-100 mb-10 leading-relaxed">
                {{ __('messages.join_cta_description') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center gap-3 bg-white text-blue-600 hover:bg-gray-50 px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    {{ __('messages.join_now') }}
                </a>
                @else
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center gap-3 bg-white text-blue-600 hover:bg-gray-50 px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                    {{ __('messages.explore_chambers') }}
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Scroll Reveal Script -->
<script>
    // Intersection Observer pour les animations au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    document.addEventListener('DOMContentLoaded', () => {
        // Observer tous les éléments avec la classe scroll-reveal
        const scrollRevealElements = document.querySelectorAll('.scroll-reveal');
        scrollRevealElements.forEach(el => observer.observe(el));
    });
</script>
@endsection
