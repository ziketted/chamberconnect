@extends('errors::layout')

@section('title', 'Session expirée')
@section('code', '419')

@section('message')
<div class="text-center space-y-6">
    <div class="mx-auto w-16 h-16 bg-blue-600/10 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>

    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Votre session a expiré</h1>

    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
        Pour des raisons de sécurité, votre session a expiré. Vous allez être redirigé vers la page de connexion dans
        <span id="countdown" class="font-semibold text-blue-600">5</span> secondes.
    </p>

    <div class="flex flex-col sm:flex-row gap-3 justify-center mt-6">
        <a href="{{ route('login') }}"
            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            Se reconnecter maintenant
        </a>

        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-3 text-sm font-semibold text-gray-900 dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Retour à l'accueil
        </a>
    </div>
</div>

<script>
    // Redirection automatique après 5 secondes
    let countdown = 5;
    const countdownElement = document.getElementById('countdown');

    const timer = setInterval(() => {
        countdown--;
        if (countdownElement) {
            countdownElement.textContent = countdown;
        }

        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = '{{ route('login') }}';
        }
    }, 1000);
</script>
@endsection
