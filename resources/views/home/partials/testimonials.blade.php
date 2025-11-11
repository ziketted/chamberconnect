<section aria-labelledby="testimonials-title" class="space-y-6">
    <h2 id="testimonials-title" class="text-2xl font-semibold tracking-tight">What Our Members Say</h2>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($testimonials as $testimonial)
        <figure class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 shadow-sm">
            <blockquote class="text-sm text-neutral-700 dark:text-gray-300">{{ $testimonial->content }}</blockquote>
            <figcaption class="mt-4 flex items-center gap-3">
                <img class="h-9 w-9 rounded-full object-cover" src="{{ $testimonial->author_image }}" alt="{{ $testimonial->author_name }}">
                <div>
                    <div class="text-sm font-semibold">{{ $testimonial->author_name }}</div>
                    <div class="text-xs text-neutral-500 dark:text-gray-500 dark:text-gray-400">{{ $testimonial->author_title }}</div>
                </div>
            </figcaption>
        </figure>
        @endforeach
    </div>
</section>
