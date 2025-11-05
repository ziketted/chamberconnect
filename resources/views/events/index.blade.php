@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Main Content -->
    <main class="lg:col-span-9">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-semibold">Upcoming Events</h1>
                </div>
            </div>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </span>
                <input type="text" placeholder="Search events, posts, people..."
                    class="w-full rounded-xl border border-neutral-200 bg-white pl-10 pr-4 py-3 text-sm text-neutral-800 placeholder:text-neutral-400 shadow-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
            </div>
        </div>

        <div class="border-b border-neutral-200 mb-6">
            <nav class="flex gap-1">
                <button class="px-4 py-2 text-sm font-medium text-[#E71D36] border-b-2 border-[#E71D36]">For
                    you</button>
                <button class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Following</button>
                <button class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Chambers</button>
                <button class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Events</button>
            </nav>
        </div>

        <div class="space-y-8">
            <div class="space-y-6">
                <!-- Static upcoming event card -->
                <div
                    class="group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200">
                    <div class="grid sm:grid-cols-3 gap-0">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop"
                            alt="" class="h-48 w-full object-cover sm:h-full">
                        <div class="sm:col-span-2 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#E71D36] to-[#cf1a30] text-white shadow-sm">
                                        <span class="text-sm font-medium">KN</span>
                                    </div>
                                    <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                        Kinshasa</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Business Forum 2025</h3>
                            <p class="text-sm text-neutral-600 mb-4">Key event for networking and collaboration among
                                businesses.</p>
                            <div class="flex items-center gap-2">
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#E71D36] px-4 py-2 text-sm font-medium text-white hover:bg-[#cf1a30]"><i
                                        data-lucide="user-plus" class="h-4 w-4"></i> Register</button>
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50">Book
                                    a spot</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Static upcoming event card -->
                <div
                    class="group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200">
                    <div class="grid sm:grid-cols-3 gap-0">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1600&auto=format&fit=crop"
                            alt="" class="h-48 w-full object-cover sm:h-full">
                        <div class="sm:col-span-2 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#E71D36] to-[#cf1a30] text-white shadow-sm">
                                        <span class="text-sm font-medium">LB</span>
                                    </div>
                                    <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                        Lubumbashi</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Mining Industry Conference</h3>
                            <p class="text-sm text-neutral-600 mb-4">Explore latest trends and technologies in the
                                mining sector.</p>
                            <div class="flex items-center gap-2">
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#E71D36] px-4 py-2 text-sm font-medium text-white hover:bg-[#cf1a30]"><i
                                        data-lucide="user-plus" class="h-4 w-4"></i> Register</button>
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50">Book
                                    a spot</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-4">Past Events</h2>
                <div class="space-y-6">
                    <div
                        class="group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200">
                        <div class="grid sm:grid-cols-3 gap-0">
                            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-48 w-full object-cover sm:h-full">
                            <div class="sm:col-span-2 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-600 to-neutral-700 text-white shadow-sm">
                                            <span class="text-sm font-medium">KN</span></div>
                                        <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                            Kinshasa</span>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">Digital Transformation Workshop</h3>
                                <p class="text-sm text-neutral-600 mb-4">A workshop on digital transformation for
                                    businesses.</p>
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"><i
                                        data-lucide="eye" class="h-4 w-4"></i> View Details</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group rounded-xl border border-neutral-200 bg-white overflow-hidden hover:shadow-sm transition-all duration-200">
                        <div class="grid sm:grid-cols-3 gap-0">
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-48 w-full object-cover sm:h-full">
                            <div class="sm:col-span-2 p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-600 to-neutral-700 text-white shadow-sm">
                                            <span class="text-sm font-medium">LB</span></div>
                                        <span class="text-sm font-medium text-neutral-900">Chamber of Commerce of
                                            Lubumbashi</span>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">SME Financing Seminar</h3>
                                <p class="text-sm text-neutral-600 mb-4">A seminar focused on financing options for
                                    SMEs.</p>
                                <button
                                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"><i
                                        data-lucide="eye" class="h-4 w-4"></i> View Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar (static) -->
    <aside class="lg:col-span-3">
        <div class="sticky top-[88px] space-y-6">
            <div class="rounded-xl border border-neutral-200 bg-white">
                <div class="border-b border-neutral-200 p-4">
                    <h2 class="text-sm font-semibold">Your Chambers</h2>
                    <p class="mt-1 text-xs text-neutral-600">Subscribing to a chamber will automatically notify you of
                        their events.</p>
                </div>
                <div class="divide-y divide-neutral-200">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#E71D36] to-[#cf1a30] text-white">
                                <span class="text-sm font-medium">KN</span></div>
                            <div>
                                <div class="text-sm font-medium">Kinshasa</div>
                                <div class="text-xs text-neutral-500">12,345 members</div>
                            </div>
                        </div>
                        <button
                            class="group relative inline-flex h-8 w-8 items-center justify-center rounded-full text-neutral-400 hover:bg-neutral-100 hover:text-[#E71D36]"><i
                                data-lucide="heart" class="h-4 w-4"></i></button>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-[#E71D36] to-[#cf1a30] text-white">
                                <span class="text-sm font-medium">LB</span></div>
                            <div>
                                <div class="text-sm font-medium">Lubumbashi</div>
                                <div class="text-xs text-neutral-500">8,765 members</div>
                            </div>
                        </div>
                        <button
                            class="group relative inline-flex h-8 w-8 items-center justify-center rounded-full text-neutral-400 hover:bg-neutral-100 hover:text-[#E71D36]"><i
                                data-lucide="heart" class="h-4 w-4"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons({ attrs: { 'stroke-width': 1.5 } });
    });
</script>
@endpush
@endsection
