@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Manage Chamber Admins</h1>
            <p class="text-sm text-neutral-600">Attach existing users as chamber managers.</p>
        </div>
        <a href="{{ route('chambers.create') }}"
            class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]"><i
                data-lucide="plus" class="h-4 w-4"></i> Create Chamber</a>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-600">
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Chamber</th>
                    <th class="px-4 py-2 text-left font-medium">Members</th>
                    <th class="px-4 py-2 text-left font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @foreach($chambers as $chamber)
                <tr>
                    <td class="px-4 py-2">{{ $chamber->name }}</td>
                    <td class="px-4 py-2">{{ $chamber->approvedMembers()->count() }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('chambers.members.create', $chamber) }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#cf1a30]"><i
                                data-lucide="user-plus" class="h-4 w-4"></i> Add Manager</a>
                        <a href="{{ route('chambers.members.pending', $chamber) }}"
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-neutral-50"><i
                                data-lucide="user-check" class="h-4 w-4"></i> Pending</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


