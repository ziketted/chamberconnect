<div data-chamber-tab="partners" class="hidden p-4 sm:p-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($partners as $partner)
        <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center hover:bg-neutral-50">
            <span class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight">
                {{ $partner->initials }}
            </span>
            <div class="mt-2 text-sm">{{ $partner->name }}</div>
        </div>
        @endforeach
    </div>
</div>
