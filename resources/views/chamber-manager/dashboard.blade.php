@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Tableau de bord — {{ $chamber->name }}</h1>
            <p class="text-sm text-neutral-600 dark:text-gray-400">Vue analytique et actions rapides.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('chambers.manage-members', $chamber) }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-neutral-300 dark:border-gray-600 text-sm text-neutral-800 dark:text-gray-200 hover:bg-neutral-100 dark:hover:bg-gray-700">
                <i data-lucide="users" class="h-4 w-4"></i> Gérer les membres
            </a>
            <a href="{{ route('chambers.events.create', $chamber) }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-[#073066] text-white text-sm hover:bg-[#052347]">
                <i data-lucide="calendar-plus" class="h-4 w-4"></i> Nouvel événement
            </a>
            <a href="{{ route('chambers.edit', $chamber) }}"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-neutral-300 dark:border-gray-600 text-sm text-neutral-800 dark:text-gray-200 hover:bg-neutral-100 dark:hover:bg-gray-700">
                <i data-lucide="settings" class="h-4 w-4"></i> Paramètres
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Total des membres</p>
            <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">{{ $kpiCards['total_members'] }}</p>
        </div>
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Demandes en attente</p>
            <p class="mt-1 text-2xl font-semibold text-amber-600 dark:text-amber-400">{{ $kpiCards['pending_requests']
                }}</p>
        </div>
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Événements à venir</p>
            <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">{{ $kpiCards['upcoming_events'] }}
            </p>
        </div>
        <div class="rounded-lg border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <p class="text-sm text-neutral-600 dark:text-gray-400">Taux de participation moyen</p>
            <p class="mt-1 text-2xl font-semibold text-neutral-900 dark:text-white">{{
                $kpiCards['average_participation'] }}%</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-3">Évolution des membres (12 mois)</h3>
            <div class="relative h-72 md:h-80">
                <canvas id="membersHistogram" class="absolute inset-0 h-full w-full"></canvas>
            </div>
        </div>
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-3">Répartition des rôles</h3>
            <div class="relative h-72 md:h-80">
                <canvas id="rolesPie" class="absolute inset-0 h-full w-full"></canvas>
            </div>
        </div>
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-3">Taux de participation (6 derniers
                événements)</h3>
            <div class="relative h-72 md:h-80">
                <canvas id="participationLine" class="absolute inset-0 h-full w-full"></canvas>
            </div>
        </div>
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
            <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-3">Répartition géographique (Top 5)</h3>
            <div class="relative h-72 md:h-80">
                <canvas id="geoBar" class="absolute inset-0 h-full w-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Members table -->
    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="p-4 border-b border-neutral-200 dark:border-gray-700">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Membres et activité</h3>
                <div class="relative">
                    <input type="text" id="dashboard-members-search" placeholder="Rechercher des membres"
                        class="w-56 rounded-md border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-8 pr-3 py-1.5 text-xs focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20">
                    <span
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2 text-neutral-400 dark:text-gray-400">
                        <i data-lucide="search" class="h-3.5 w-3.5"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-neutral-600 dark:text-gray-300">
                    <tr>
                        <th class="py-2 pr-4">Membre</th>
                        <th class="py-2 pr-4">Rôle</th>
                        <th class="py-2 pr-4">Inscription</th>
                        <th class="py-2 pr-4">Événements participés</th>
                        <th class="py-2 pr-4">Statut</th>
                    </tr>
                </thead>
                <tbody class="text-neutral-800 dark:text-gray-100">
                    @foreach($detailedMembers as $m)
                    <tr class="border-t border-neutral-100 dark:border-gray-700 js-dm-row"
                        data-name="{{ strtolower($m['name']) }}" data-email="{{ strtolower($m['email']) }}"
                        data-role="{{ strtolower($m['role']) }}" data-status="{{ strtolower($m['status']) }}">
                        <td class="py-3 pr-4">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $m['name'] }}</span>
                                <span class="text-xs text-neutral-500">{{ $m['email'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 pr-4 capitalize">{{ $m['role'] }}</td>
                        <td class="py-3 pr-4">{{ \Carbon\Carbon::parse($m['joined_at'])->format('d/m/Y') }}</td>
                        <td class="py-3 pr-4">{{ $m['events_participated'] }}</td>
                        <td class="py-3 pr-4">
                            @if($m['status'] === 'approved')
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Actif</span>
                            @elseif($m['status'] === 'pending')
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">En
                                attente</span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs bg-neutral-100 text-neutral-800 dark:bg-gray-700 dark:text-gray-300">{{
                                $m['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Side sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <div
            class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
            <div class="p-4 border-b border-neutral-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Demandes d’adhésion</h3>
                <a href="{{ route('chambers.members.pending', $chamber) }}"
                    class="text-xs text-[#073066] dark:text-blue-400 hover:underline">Voir tout</a>
            </div>
            <div class="p-4">
                @if($pendingMembers->isEmpty())
                <p class="text-sm text-neutral-600 dark:text-gray-400">Aucune demande en attente.</p>
                @else
                <ul class="space-y-3">
                    @foreach($pendingMembers as $pm)
                    <li class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $pm->name }}</p>
                            <p class="text-xs text-neutral-600 dark:text-gray-400">{{ $pm->email }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('chambers.members.approve', [$chamber, $pm]) }}">
                                @csrf
                                <button
                                    class="px-2 py-1 text-xs rounded-md bg-green-600 text-white hover:bg-green-700">Valider</button>
                            </form>
                            <form method="POST" action="{{ route('chambers.members.reject', [$chamber, $pm]) }}">
                                @csrf
                                <button
                                    class="px-2 py-1 text-xs rounded-md bg-rose-600 text-white hover:bg-rose-700">Refuser</button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        <div
            class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
            <div class="p-4 border-b border-neutral-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Événements récents</h3>
                <a href="{{ route('chambers.events.create', $chamber) }}"
                    class="text-xs text-[#073066] dark:text-blue-400 hover:underline">Créer</a>
            </div>
            <div class="divide-y divide-neutral-200 dark:divide-gray-700">
                @forelse($recentEvents as $ev)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $ev->title }}</p>
                        <p class="text-xs text-neutral-600 dark:text-gray-400">{{ $ev->date?->format('d/m/Y') }} • {{
                            ucfirst($ev->mode ?? '—') }}</p>
                    </div>
                    <span class="text-xs text-neutral-600 dark:text-gray-400">{{ $ev->participants_count }}
                        participants</span>
                </div>
                @empty
                <p class="p-4 text-sm text-neutral-600 dark:text-gray-400">Aucun événement pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Charts.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Styles dark mode pour grilles/axes Chart.js
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
    const tickColor = isDark ? '#cbd5e1' : '#475569';
    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { labels: { color: tickColor } } },
        scales: {
            x: { grid: { color: gridColor }, ticks: { color: tickColor } },
            y: { grid: { color: gridColor }, ticks: { color: tickColor }, beginAtZero: true }
        }
    };
    const memberEvolution = @json($memberEvolution);
	const roleDistribution = @json($roleDistribution);
	const participationRates = @json($participationRates);
	const geoDistribution = @json($geographicDistribution);

	const ctxMembers = document.getElementById('membersHistogram').getContext('2d');
	new Chart(ctxMembers, {
		type: 'bar',
		data: {
			labels: memberEvolution.map(i => i.month),
			datasets: [{
				label: 'Membres',
				data: memberEvolution.map(i => i.count),
				backgroundColor: '#073066',
                borderRadius: 6,
                maxBarThickness: 28
			}]
		},
		options: baseOptions
	});

	const ctxRoles = document.getElementById('rolesPie').getContext('2d');
	new Chart(ctxRoles, {
		type: 'pie',
		data: {
			labels: roleDistribution.map(i => i.label),
			datasets: [{
				data: roleDistribution.map(i => i.value),
				backgroundColor: roleDistribution.map(i => i.color),
                borderWidth: 0
			}]
		},
		options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { labels: { color: tickColor } } } }
	});

	const ctxPart = document.getElementById('participationLine').getContext('2d');
	new Chart(ctxPart, {
		type: 'line',
		data: {
			labels: participationRates.map(i => i.date),
			datasets: [{
				label: 'Participation (%)',
				data: participationRates.map(i => i.rate),
				borderColor: '#10B981',
				backgroundColor: 'rgba(16,185,129,0.15)',
				fill: true,
				tension: 0.35,
                pointRadius: 3,
                pointHoverRadius: 4
			}]
		},
		options: baseOptions
	});

	const ctxGeo = document.getElementById('geoBar').getContext('2d');
	new Chart(ctxGeo, {
		type: 'bar',
		data: {
			labels: geoDistribution.map(i => i.city),
			datasets: [{
				label: 'Membres',
				data: geoDistribution.map(i => i.count),
				backgroundColor: '#6366F1',
                borderRadius: 6,
                maxBarThickness: 28
			}]
		},
		options: baseOptions
	});
    // Search members table (dashboard)
    (function(){
        const input = document.getElementById('dashboard-members-search');
        if (!input) return;
        const rows = Array.from(document.querySelectorAll('tbody tr.js-dm-row'));
        input.addEventListener('input', () => {
            const q = input.value.trim().toLowerCase();
            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const role = row.dataset.role || '';
                const status = row.dataset.status || '';
                const show = q === '' || name.includes(q) || email.includes(q) || role.includes(q) || status.includes(q);
                row.style.display = show ? '' : 'none';
    });
});
    })();
</script>
@endsection