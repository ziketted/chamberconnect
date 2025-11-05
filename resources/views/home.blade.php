@extends('layouts.app')

@section('content')
<div class="space-y-14">
    <!-- Hero -->
    <div class="overflow-hidden rounded-2xl border border-neutral-200 shadow-sm">
        <div class="relative isolate">
            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop" alt=""
                class="h-[460px] w-full object-cover">
            <div class="absolute inset-0 bg-neutral-900/50"></div>
            <div class="relative z-10 flex h-[460px] items-center">
                <div class="max-w-2xl p-8 sm:p-12">
                    <div
                        class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white ring-1 ring-white/20 backdrop-blur">
                        <i data-lucide="shield-check" class="h-4 w-4 text-white"></i>
                        {{ __('messages.accredited_chamber') }}
                    </div>
                    <h1 class="text-white text-4xl sm:text-5xl font-semibold tracking-tight">{{ __('messages.tagline')
                        }}</h1>
                    <p class="mt-3 text-neutral-200 text-base">{{ __('messages.description') }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                            <i data-lucide="compass" class="h-4 w-4"></i>
                            {{ __('messages.explore_chambers') }}
                        </a>
                        @else
                        <button onclick="openModal('signin-modal')"
                            class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                            <i data-lucide="compass" class="h-4 w-4"></i>
                            {{ __('messages.explore_chambers') }}
                        </button>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-white/10 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-white/30 hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                            <i data-lucide="user-plus" class="h-4 w-4"></i>
                            {{ __('messages.join_now') }}
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News & Updates -->
    <section aria-labelledby="news-title" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 id="news-title" class="text-2xl font-semibold tracking-tight">{{ __('messages.latest_news') }}</h2>
            <a href="#" class="text-sm font-medium text-[#E71D36] hover:underline">{{ __('messages.view_all') }}</a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card 1 -->
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1550948390-6eb7fa773072?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-40 w-full object-cover">
                <div class="p-5">
                    <h3 class="text-base font-semibold leading-snug">DRC Exports Surge as New Trade Policies Take Effect
                    </h3>
                    <p class="mt-2 text-sm text-neutral-600">Government-backed incentives are boosting exports across
                        key sectors...</p>
                    <div class="mt-3">
                        <a href="#"
                            class="inline-flex items-center gap-1 text-sm font-medium text-[#E71D36] hover:underline">
                            {{ __('messages.read_more') }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 2 -->
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-40 w-full object-cover">
                <div class="p-5">
                    <h3 class="text-base font-semibold leading-snug">Entrepreneurship Week: Workshops Announced</h3>
                    <p class="mt-2 text-sm text-neutral-600">From funding to export-readiness: practical sessions to
                        scale your business...</p>
                    <div class="mt-3">
                        <a href="#"
                            class="inline-flex items-center gap-1 text-sm font-medium text-[#E71D36] hover:underline">
                            {{ __('messages.read_more') }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 3 -->
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1600&auto=format&fit=crop"
                    alt="" class="h-40 w-full object-cover">
                <div class="p-5">
                    <h3 class="text-base font-semibold leading-snug">Market Outlook: Q4 Forecasts Signal Steady Growth
                    </h3>
                    <p class="mt-2 text-sm text-neutral-600">Analysts expect stabilizing supply chains to drive
                        consistent performance...</p>
                    <div class="mt-3">
                        <a href="#"
                            class="inline-flex items-center gap-1 text-sm font-medium text-[#E71D36] hover:underline">
                            {{ __('messages.read_more') }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Partners -->
    <section aria-labelledby="partners-title" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 id="partners-title" class="text-2xl font-semibold tracking-tight">{{ __('messages.our_partners') }}</h2>
            <span class="text-xs text-neutral-500">{{ __('messages.partners_subtitle') }}</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach(['AL' => 'Alto Labs', 'NV' => 'Novix', 'PR' => 'Prax', 'SE' => 'Seren', 'UX' => 'UXON', 'KO' =>
            'Kora'] as $initials => $name)
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center">
                <span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight">{{
                    $initials }}</span>
                <div class="mt-2 text-sm font-medium">{{ $name }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Testimonials -->
    <section aria-labelledby="testimonials-title" class="space-y-6">
        <h2 id="testimonials-title" class="text-2xl font-semibold tracking-tight">{{ __('messages.testimonials_title')
            }}</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Testimonial 1 -->
            <figure class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
                <blockquote class="text-sm text-neutral-700">"The platform helped us meet distributors within weeks. The
                    events calendar is a game-changer."</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400&auto=format&fit=crop"
                        alt="">
                    <div>
                        <div class="text-sm font-semibold">Amina K.</div>
                        <div class="text-xs text-neutral-500">Founder, Kivu Agro</div>
                    </div>
                </figcaption>
            </figure>

            <!-- Testimonial 2 -->
            <figure class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
                <blockquote class="text-sm text-neutral-700">"Networking has never been this efficient. We booked two
                    deals after the last forum."</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=400&auto=format&fit=crop"
                        alt="">
                    <div>
                        <div class="text-sm font-semibold">Jean P.</div>
                        <div class="text-xs text-neutral-500">COO, Lumumba Logistics</div>
                    </div>
                </figcaption>
            </figure>

            <!-- Testimonial 3 -->
            <figure class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
                <blockquote class="text-sm text-neutral-700">"A trusted hub for small businesses to scale and connect
                    with investors."</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=400&auto=format&fit=crop"
                        alt="">
                    <div>
                        <div class="text-sm font-semibold">Chantal M.</div>
                        <div class="text-xs text-neutral-500">CEO, KinTech Labs</div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm">
        <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-xl sm:text-2xl font-semibold tracking-tight">{{ __('messages.join_cta_title') }}</h3>
                <p class="mt-1 text-sm text-neutral-600">{{ __('messages.join_cta_description') }}</p>
            </div>
            @guest
            <a href="{{ route('register') }}"
                class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]/50">
                <i data-lucide="rocket" class="h-4 w-4"></i>
                {{ __('messages.join_now') }}
            </a>
            @else
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 rounded-md bg-[#E71D36] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]/50">
                <i data-lucide="rocket" class="h-4 w-4"></i>
                {{ __('messages.explore_chambers') }}
            </a>
            @endguest
        </div>
    </section>
</div>
@endsection
