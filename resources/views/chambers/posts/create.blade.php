@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Publish Content — {{
            $chamber->name }}</h1>
    </div>

    <form action="{{ route('chambers.posts.store', $chamber) }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        @csrf
        <div>
            <label class="text-xs font-medium text-neutral-700">Title</label>
            <input name="title" required
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20" />
        </div>
        <div>
            <label class="text-xs font-medium text-neutral-700">Body</label>
            <textarea name="body" rows="8" required
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20"></textarea>
        </div>
        <div>
            <label class="text-xs font-medium text-neutral-700">Cover Image</label>
            <input type="file" name="cover" accept="image/*" class="mt-1 block w-full text-sm" />
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('chamber.show', $chamber) }}"
                class="rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium hover:bg-neutral-50">Cancel</a>
            <button
                class="rounded-md bg-[#073066] px-4 py-2 text-sm font-semibold text-white hover:bg-[#052347]">Publish</button>
        </div>
    </form>
</div>
@endsection


