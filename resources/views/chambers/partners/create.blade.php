@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Add Partner — {{
            $chamber->name }}</h1>
    </div>

    <form action="{{ route('chambers.partners.store', $chamber) }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
        @csrf
        <div>
            <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Name</label>
            <input name="name" required
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Initials</label>
                <input name="initials"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Website</label>
                <input name="website"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20" />
            </div>
        </div>
        <div>
            <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">Logo</label>
            <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm" />
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('chamber.show', $chamber) }}"
                class="rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium hover:bg-neutral-50 dark:bg-gray-700">Cancel</a>
            <button
                class="rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">Add</button>
        </div>
    </form>
</div>
@endsection






