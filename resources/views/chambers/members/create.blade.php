@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Add Member — {{ $chamber->name
            }}</h1>
        <p class="text-sm text-neutral-600">User must already have an account.</p>
    </div>

    <form action="{{ route('chambers.members.store', $chamber) }}" method="POST"
        class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        @csrf
        <div>
            <label class="text-xs font-medium text-neutral-700">User Email</label>
            <input type="email" name="email" required
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
        </div>
        <div>
            <label class="text-xs font-medium text-neutral-700">Role</label>
            <select name="role"
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
                <option value="member">Member</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('chamber.show', $chamber) }}"
                class="rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium hover:bg-neutral-50">Cancel</a>
            <button class="rounded-md bg-[#E71D36] px-4 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]">Add
                Member</button>
        </div>
    </form>
</div>
@endsection


