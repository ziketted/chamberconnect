@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Demandes d'adhésion — {{
                $chamber->name }}</h1>
            <p class="text-sm text-neutral-600 dark:text-gray-400">Approuvez ou rejetez les membres en attente.</p>
        </div>
        <a href="{{ route('chamber.show', $chamber) }}" class="text-sm text-[#073066] dark:text-blue-400 hover:underline">Retour à la
            chambre</a>
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-50 dark:bg-gray-700 text-neutral-600 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Nom</th>
                    <th class="px-4 py-2 text-left font-medium">Email</th>
                    <th class="px-4 py-2 text-left font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @forelse($pending as $user)
                <tr>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('chambers.members.approve', [$chamber, $user]) }}">
                            @csrf
                            <button
                                class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#052347]">
                                <i data-lucide="check" class="h-4 w-4"></i> Approuver
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-4 py-4 text-neutral-500 dark:text-gray-500 dark:text-gray-400" colspan="3">Aucune demande en attente.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection







