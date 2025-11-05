<section aria-labelledby="partners-title" class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 id="partners-title" class="text-2xl font-semibold tracking-tight">Our Valued Partners</h2>
        <span class="text-xs text-neutral-500">Building credibility through collaboration</span>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($partners as $partner)
        <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center">
            <span class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight">
                {{ $partner->initials }}
            </span>
            <div class="mt-2 text-sm font-medium">{{ $partner->name }}</div>
        </div>
        @endforeach
    </div>
</section>
