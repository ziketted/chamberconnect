@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Tableau de bord SuperAdmin</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Bienvenue, {{ Auth::user()->name }}</p>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Chambres -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Chambres</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_chambers'] ?? 0 }}</p>
                    </div>
                    <i data-lucide="building-2" class="h-12 w-12 text-blue-500 opacity-20"></i>
                </div>
            </div>

            <!-- Demandes en attente -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandes en attente</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_chambers'] ?? 0 }}</p>
                    </div>
                    <i data-lucide="clock" class="h-12 w-12 text-yellow-500 opacity-20"></i>
                </div>
            </div>

            <!-- Gestionnaires actifs -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Gestionnaires</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_managers'] ?? 0 }}</p>
                    </div>
                    <i data-lucide="users" class="h-12 w-12 text-green-500 opacity-20"></i>
                </div>
            </div>

            <!-- Chambres agréées -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Agréées</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['certified_chambers'] ?? 0 }}</p>
                    </div>
                    <i data-lucide="check-circle" class="h-12 w-12 text-purple-500 opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Menu d'actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Gérer les chambres -->
            <a href="{{ route('super-admin.chambers.index') }}"
                class="block bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow hover:border-blue-500 border border-transparent">
                <div class="flex items-center mb-4">
                    <i data-lucide="building-2" class="h-8 w-8 text-blue-600 dark:text-blue-400 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Chambres</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Valider, agréer et gérer toutes les chambres du système.
                </p>
            </a>

            <!-- Gérer les gestionnaires -->
            <a href="{{ route('super-admin.managers.index') }}"
                class="block bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow hover:border-green-500 border border-transparent">
                <div class="flex items-center mb-4">
                    <i data-lucide="users" class="h-8 w-8 text-green-600 dark:text-green-400 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Gestionnaires</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Promouvoir ou rétrograder des utilisateurs en gestionnaires.
                </p>
            </a>

            <!-- Envoyer des notifications -->
            <a href="{{ route('super-admin.notifications.index') }}"
                class="block bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow hover:border-purple-500 border border-transparent">
                <div class="flex items-center mb-4">
                    <i data-lucide="mail" class="h-8 w-8 text-purple-600 dark:text-purple-400 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Envoyer des messages en masse aux gestionnaires et chambres.
                </p>
            </a>
        </div>

        <!-- Demandes en attente -->
        @php
            $pendingRequests = \App\Models\Chamber::where('verified', false)->latest()->take(5)->get();
        @endphp
        @if($pendingRequests->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">📬 Demandes récentes en attente</h2>
                <a href="{{ route('super-admin.chambers.index', ['filter_status' => 'pending']) }}"
                    class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                    Voir toutes →
                </a>
            </div>
            
            <div class="space-y-3">
                @foreach($pendingRequests as $request)
                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $request->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Demandé le {{ $request->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    <a href="{{ route('super-admin.chambers.show-request', $request->id) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <i data-lucide="eye" class="h-4 w-4 inline mr-1"></i>
                        Examiner
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Statistiques et Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Distribution des statuts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">État des Chambres</h3>
                <div class="relative h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Croissance mensuelle -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Croissance des Chambres (12 mois)</h3>
                <div class="relative h-64">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

            <!-- Top Chambres -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top 5 Chambres par Membres</h3>
                <div class="relative h-64">
                    <canvas id="topChambersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Scripts Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#9ca3af' : '#4b5563';
                const gridColor = isDark ? '#374151' : '#e5e7eb';

                // Configuration commune
                Chart.defaults.color = textColor;
                Chart.defaults.borderColor = gridColor;

                // 1. Graphique de distribution des statuts (Donut)
                new Chart(document.getElementById('statusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Vérifiées', 'En attente', 'Suspendues'], // Suspendues = Total - (Vérifiées + En attente) approx ou 0 si pas de data
                        datasets: [{
                            data: [
                                {{ $stats['verified_chambers'] }},
                                {{ $stats['pending_chambers'] }},
                                {{ $stats['total_chambers'] - ($stats['verified_chambers'] + $stats['pending_chambers']) }} 
                            ],
                            backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: textColor }
                            }
                        }
                    }
                });

                // 2. Graphique de croissance (Bar)
                new Chart(document.getElementById('growthChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($labels) !!},
                        datasets: [{
                            label: 'Nouvelles Chambres',
                            data: {!! json_encode($growthData) !!},
                            backgroundColor: '#3B82F6',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: { color: textColor, stepSize: 1 }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: textColor }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });

                // 3. Top Chambres (Horizontal Bar)
                const topChambers = {!! json_encode($topChambers) !!};
                new Chart(document.getElementById('topChambersChart'), {
                    type: 'bar',
                    indexAxis: 'y',
                    data: {
                        labels: topChambers.map(c => c.name),
                        datasets: [{
                            label: 'Membres',
                            data: topChambers.map(c => c.members_count),
                            backgroundColor: '#8B5CF6',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: { color: textColor }
                            },
                            y: {
                                grid: { display: false },
                                ticks: { color: textColor }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            });
        </script>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection
