@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">Create a Chamber</h1>
        <p class="text-sm text-neutral-600">Define details, upload cover and social links.</p>
    </div>

    <form action="{{ route('chambers.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        @csrf

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-neutral-700">Name</label>
                <input name="name" required
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Location</label>
                <input name="location"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Address</label>
                <input name="address"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Website</label>
                <input name="website"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Email</label>
                <input type="email" name="email"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Phone</label>
                <input name="phone"
                    class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
            </div>
        </div>

        <div>
            <label class="text-xs font-medium text-neutral-700">Description</label>
            <textarea name="description" rows="4"
                class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20"></textarea>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-neutral-700">Logo</label>
                <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm" />
            </div>
            <div>
                <label class="text-xs font-medium text-neutral-700">Cover Image</label>
                <input type="file" name="cover" accept="image/*" class="mt-1 block w-full text-sm" />
            </div>
        </div>

        <div>
            <div class="text-sm font-semibold tracking-tight mb-2" style="letter-spacing:-0.01em;">Social Links</div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-xs font-medium text-neutral-700">LinkedIn</label>
                    <input name="social_links[linkedin]"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
                </div>
                <div>
                    <label class="text-xs font-medium text-neutral-700">Twitter</label>
                    <input name="social_links[twitter]"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
                </div>
                <div>
                    <label class="text-xs font-medium text-neutral-700">Facebook</label>
                    <input name="social_links[facebook]"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20" />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('chambers') }}"
                class="rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium hover:bg-neutral-50">Cancel</a>
            <button class="rounded-md bg-[#E71D36] px-4 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30]">Create
                Chamber</button>
        </div>
    </form>
</div>
@endsection


