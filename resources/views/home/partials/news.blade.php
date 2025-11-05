<section aria-labelledby="news-title" class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 id="news-title" class="text-2xl font-semibold tracking-tight">Latest News & Updates</h2>
        <a href="{{ route('news.index') }}" class="text-sm font-medium text-[#E71D36] hover:underline">View all</a>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($news as $article)
        <article class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            <img src="{{ $article->image }}" alt="{{ $article->title }}" class="h-40 w-full object-cover">
            <div class="p-5">
                <h3 class="text-base font-semibold leading-snug">{{ $article->title }}</h3>
                <p class="mt-2 text-sm text-neutral-600">{{ $article->excerpt }}</p>
                <div class="mt-3">
                    <a href="{{ route('news.show', $article) }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#E71D36] hover:underline">
                        Read more
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>
