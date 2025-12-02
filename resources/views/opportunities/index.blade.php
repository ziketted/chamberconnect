@extends('layouts.app')

@section('content')
<style>
    /* Animations personnalisées */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    .slide-in-left {
        animation: slideInLeft 1s ease-out forwards;
        opacity: 0;
    }

    .scale-in {
        animation: scaleIn 0.6s ease-out forwards;
        opacity: 0;
    }

    .roadmap-line {
        position: relative;
    }

    .roadmap-line::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateX(-50%);
        border-radius: 2px;
    }

    @media (max-width: 1024px) {
        .roadmap-line::before {
            left: 24px;
        }
    }

    .step-card {
        transition: all 0.3s ease;
    }

    .step-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
</style>

<!-- Hero Section avec Image -->
<div class="relative h-[60vh] overflow-hidden">
    <!-- Image de fond -->
    <div class="absolute inset-0">
        <img src="{{ asset('img/invest.jpg') }}" alt="Investir en RDC" class="w-full h-full object-cover">
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 via-blue-800/80 to-blue-900/90"></div>
        
        <!-- Animated shapes -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <!-- Contenu Hero -->
    <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
        <div class="max-w-3xl">
            <div>
                <span class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-semibold rounded-full mb-6 scale-in">
                    Guide Complet
                </span>
                <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight slide-in-left" style="animation-delay: 0.2s;">
                    Investissez en République Démocratique du Congo
                </h1>
                <p class="text-xl text-blue-100 mb-8 leading-relaxed fade-in-up" style="animation-delay: 0.4s;">
                    Découvrez les étapes clés et les institutions partenaires qui vous accompagneront dans votre projet d'investissement
                </p>
                <div class="flex flex-wrap gap-4 fade-in-up" style="animation-delay: 0.6s;">
                    <a href="#roadmap" class="inline-flex items-center gap-2 bg-white text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        <span>Découvrir la Roadmap</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 border-2 border-white/20 hover:scale-105">
                        <span>Créer un Compte</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</div>

<div class="bg-gradient-to-br from-gray-50 to-blue-50/30 dark:from-gray-900 dark:to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header avec Taux de Change -->
        <div id="roadmap" class="mb-12 fade-in-up">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Titre Principal -->
                <div>
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-4 block">Guide d'Investissement</span>
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-3">
                        Votre Parcours d'Investissement en RDC
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        Suivez ces étapes pour réussir votre implantation en République Démocratique du Congo
                    </p>
                </div>

                <!-- Taux de Change Card -->
                <div class="lg:flex-shrink-0">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 rounded-xl p-6 shadow-lg float-animation">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-100">Taux du Jour</span>
                        </div>
                        <div class="text-2xl font-bold text-white">
                            1 USD = {{ number_format($exchangeRate, 2, ',', ' ') }} CDF
                        </div>
                        <div class="text-xs text-blue-100 mt-1">
                            Mis à jour en temps réel
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Introduction -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg mb-12 fade-in-up border border-gray-200 dark:border-gray-700" style="animation-delay: 0.1s;">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Comment Utiliser Ce Guide</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Cette roadmap vous guide étape par étape dans votre parcours d'investissement en RDC. 
                        Chaque institution partenaire joue un rôle crucial à différentes étapes. 
                        Suivez ce parcours pour maximiser vos chances de succès et naviguer efficacement dans l'écosystème d'affaires congolais.
                    </p>
                </div>
            </div>
        </div>

        <!-- Roadmap -->
        <div class="relative roadmap-line py-8">
            
            <!-- Étape 1: ANAPI -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="lg:w-1/2 lg:text-right lg:pr-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4 lg:justify-end">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/anapi.png') }}" alt="ANAPI" class="w-full h-full object-contain">
                                </div>
                                <div class="text-left lg:text-right">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">ANAPI</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Point de Départ</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Agence Nationale pour la Promotion des Investissements</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Enregistrement de votre entreprise</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Accompagnement administratif</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Guichet unique pour investisseurs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            1
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pl-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Documents Nécessaires</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Passeport ou pièce d'identité
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Plan d'affaires
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Preuve de capital
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 2: DGI -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.3s;">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-8">
                    <div class="lg:w-1/2 lg:text-left lg:pl-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/dgi.png') }}" alt="DGI" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">DGI</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Fiscalité</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Direction Générale des Impôts</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Obtention du numéro fiscal (NIF)</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Conseil sur obligations fiscales</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Régime fiscal adapté</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            2
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pr-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Avantages Fiscaux</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Exonérations possibles
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Régimes préférentiels
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Support déclarations
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 3: BCC -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.4s;">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="lg:w-1/2 lg:text-right lg:pr-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4 lg:justify-end">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/bcc.png') }}" alt="BCC" class="w-full h-full object-contain">
                                </div>
                                <div class="text-left lg:text-right">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">BCC</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Opérations Bancaires</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Banque Centrale du Congo</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Ouverture compte bancaire professionnel</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Opérations de change USD/CDF</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Transferts internationaux</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            3
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pl-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Services Bancaires</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Compte en USD et CDF
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Taux de change officiel
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Virements internationaux
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 4: Ministère du Commerce -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.5s;">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-8">
                    <div class="lg:w-1/2 lg:text-left lg:pl-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/commerce.png') }}" alt="Commerce" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ministère du Commerce</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Licences</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Licence d'import-export</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Autorisation commerciale</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Conformité réglementaire</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            4
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pr-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Autorisations</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Licence commerciale
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Permis d'exploitation
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Certificats requis
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 5: DGDA -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.6s;">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="lg:w-1/2 lg:text-right lg:pr-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4 lg:justify-end">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/dgda.jpg') }}" alt="DGDA" class="w-full h-full object-contain">
                                </div>
                                <div class="text-left lg:text-right">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">DGDA</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Douanes</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Direction Générale des Douanes et Accises</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Dédouanement marchandises</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Procédures import-export</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Tarifs douaniers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            5
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pl-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Import/Export</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Déclarations douanières
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Facilitation passages
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Conseil tarifs
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 6: AZES / ZELCAF -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.7s;">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-8">
                    <div class="lg:w-1/2 lg:text-left lg:pl-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/azes.jpg') }}" alt="AZES" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">AZES / ZELCAF</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Zones Spéciales</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Zones Économiques Spéciales</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Avantages fiscaux exceptionnels</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Infrastructure moderne</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Services intégrés</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            6
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pr-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Avantages ZES</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Exonération fiscale 5-10 ans
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Infrastructure clé en main
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Guichet unique sur site
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 7: FPI / SEGUCE -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.8s;">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="lg:w-1/2 lg:text-right lg:pr-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4 lg:justify-end">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/fpi.png') }}" alt="FPI" class="w-full h-full object-contain">
                                </div>
                                <div class="text-left lg:text-right">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">FPI / SEGUCE</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Support & Croissance</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Fédération PME & Entrepreneuriat</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Networking et partenariats</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Accès au financement</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Formation continue</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            7
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pl-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Accompagnement</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Mentorat d'entrepreneurs
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Programmes de financement
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Réseau d'affaires
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 8: ANADEC -->
            <div class="mb-16 fade-in-up" style="animation-delay: 0.9s;">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-8">
                    <div class="lg:w-1/2 lg:text-left lg:pl-12">
                        <div class="step-card bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-white dark:bg-gray-700 border-2 border-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 p-2">
                                    <img src="{{ asset('img/partenaires/anadec.png') }}" alt="ANADEC" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">ANADEC</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Formation</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <strong class="text-gray-900 dark:text-white">Agence Nationale de Développement des Compétences</strong>
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Formation du personnel local</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Agrément professionnelle</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Développement des compétences</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold border-4 border-white dark:border-gray-900 shadow-lg">
                            8
                        </div>
                    </div>
                    <div class="lg:w-1/2 lg:pr-12">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-5 border border-blue-100 dark:border-blue-800">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Ressources Humaines</h4>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Formation sur mesure
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Agrément reconnue
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Recrutement facilité
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Call to Action Final -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 rounded-xl p-12 text-center shadow-lg fade-in-up" style="animation-delay: 1s;">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                Prêt à Investir en RDC
            </h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Rejoignez ChamberConnect et bénéficiez d'un accompagnement personnalisé à chaque étape de votre parcours d'investissement
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-3 bg-white text-blue-600 hover:bg-gray-50 px-8 py-4 rounded-lg font-semibold text-base transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Créer un Compte
                </a>
                <a href="{{ route('chambers') }}" class="inline-flex items-center justify-center gap-3 bg-blue-500 hover:bg-blue-400 text-white px-8 py-4 rounded-lg font-semibold text-base transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Découvrir les Chambres
                </a>
                @else
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-3 bg-white text-blue-600 hover:bg-gray-50 px-8 py-4 rounded-lg font-semibold text-base transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Mon Tableau de Bord
                </a>
                @endguest
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Intersection Observer pour les animations au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Smooth scroll pour le lien "Découvrir la Roadmap"
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endsection
