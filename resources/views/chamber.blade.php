@extends('layouts.app')

@section('content')
<!-- Banner -->
<div class="overflow-hidden rounded-2xl border border-neutral-200 shadow-sm">
    <div class="relative">
        <img src="https://images.unsplash.com/photo-1642615835477-d303d7dc9ee9?w=1080&q=80" alt=""
            class="h-56 w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-black/0"></div>
        <div class="absolute bottom-4 left-4 right-4">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <h2 class="text-white text-3xl font-semibold tracking-tight" style="letter-spacing:-0.02em;">
                        Kinshasa Chamber of Commerce</h2>
                    <div class="mt-1 flex items-center gap-3 text-sm text-neutral-200">
                        <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="h-4 w-4"></i>
                            Kinshasa, DRC</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="users" class="h-4 w-4"></i> 12,340
                            members</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="shield-check" class="h-4 w-4"></i>
                            Accredited</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button
                        class="inline-flex items-center gap-2 rounded-md border border-white/60 bg-white/10 px-3 py-2 text-sm font-semibold text-white backdrop-blur hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60"><i
                            data-lucide="share-2" class="h-4 w-4"></i> Share</button>
                    <button
                        class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]"><i
                            data-lucide="heart" class="h-4 w-4"></i> Follow</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sub Nav -->
<div class="mt-6 rounded-xl border border-neutral-200 bg-white shadow-sm">
    <div class="border-b border-neutral-200 px-4 py-2 flex justify-end">
        <button
            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#052347]"><i
                data-lucide="user-plus" class="h-4 w-4"></i> Adhérer</button>
    </div>
    <div class="flex flex-wrap items-center gap-1 border-b border-neutral-200 px-4 py-2">
        <button onclick="switchChamberTab('overview')" data-chamber-link="overview"
            class="cham-link active inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-900 hover:bg-neutral-100"><i
                data-lucide="layout-dashboard" class="h-4 w-4 text-[#073066]"></i> Overview</button>
        <button onclick="switchChamberTab('events')" data-chamber-link="events"
            class="cham-link inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 hover:bg-neutral-100"><i
                data-lucide="calendar" class="h-4 w-4"></i> Events</button>
        <button onclick="switchChamberTab('members')" data-chamber-link="members"
            class="cham-link inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 hover:bg-neutral-100"><i
                data-lucide="users" class="h-4 w-4"></i> Members</button>
        <button onclick="switchChamberTab('partners')" data-chamber-link="partners"
            class="cham-link inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-neutral-600 hover:bg-neutral-100"><i
                data-lucide="handshake" class="h-4 w-4"></i> Partners</button>
    </div>

    <!-- Overview -->
    <div data-chamber-tab="overview" class="p-4 sm:p-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left -->
            <div class="lg:col-span-7 space-y-6">
                <section class="space-y-2">
                    <h3 class="text-lg font-semibold tracking-tight" style="letter-spacing:-0.01em;">About the Chamber
                    </h3>
                    <p class="text-sm text-neutral-700">The Kinshasa Chamber of Commerce connects enterprises with
                        opportunities across the DRC and beyond. We provide access to policy insights, market
                        intelligence, and curated networking to catalyze sustainable growth.</p>
                    <ul class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-neutral-700">
                        <li class="inline-flex items-center gap-2"><i data-lucide="check"
                                class="h-4 w-4 text-emerald-600"></i> Export-readiness programs</li>
                        <li class="inline-flex items-center gap-2"><i data-lucide="check"
                                class="h-4 w-4 text-emerald-600"></i> Policy and regulatory briefings</li>
                        <li class="inline-flex items-center gap-2"><i data-lucide="check"
                                class="h-4 w-4 text-emerald-600"></i> Investor matchmaking</li>
                        <li class="inline-flex items-center gap-2"><i data-lucide="check"
                                class="h-4 w-4 text-emerald-600"></i> Sector-specific events</li>
                    </ul>
                </section>

                <section class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold tracking-tight" style="letter-spacing:-0.01em;">Upcoming Events
                        </h3>
                        <button class="text-sm font-medium text-[#073066] hover:underline">See all</button>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <a href="#"
                            class="group relative overflow-hidden rounded-lg border border-neutral-200 hover:border-neutral-300">
                            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-32 w-full object-cover">
                            <div class="absolute inset-0 bg-neutral-900/40"></div>
                            <div class="absolute inset-x-0 bottom-0 p-3">
                                <div class="text-white text-sm font-semibold">Investor Breakfast</div>
                                <div class="text-xs text-neutral-200">Dec 2 • Gombe</div>
                            </div>
                        </a>
                        <a href="#"
                            class="group relative overflow-hidden rounded-lg border border-neutral-200 hover:border-neutral-300">
                            <img src="https://images.unsplash.com/photo-1516387938699-a93567ec168e?q=80&w=1600&auto=format&fit=crop"
                                alt="" class="h-32 w-full object-cover">
                            <div class="absolute inset-0 bg-neutral-900/40"></div>
                            <div class="absolute inset-x-0 bottom-0 p-3">
                                <div class="text-white text-sm font-semibold">Trade Compliance 101</div>
                                <div class="text-xs text-neutral-200">Dec 14 • Online</div>
                            </div>
                        </a>
                    </div>
                </section>
            </div>

            <!-- Right -->
            <div class="lg:col-span-5 space-y-6">
                <section class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
                    <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Contact & Address
                    </h3>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 text-neutral-700"><i data-lucide="mail"
                                    class="h-4 w-4 text-neutral-500"></i> hello@kinchamber.org</div>
                            <div class="inline-flex items-center gap-2 text-neutral-700"><i data-lucide="phone"
                                    class="h-4 w-4 text-neutral-500"></i> +243 800 000 000</div>
                        </div>
                        <div class="space-y-2">
                            <div class="inline-flex items-center gap-2 text-neutral-700"><i data-lucide="map-pin"
                                    class="h-4 w-4 text-neutral-500"></i> 42 Avenue de la Paix, Gombe</div>
                            <div class="inline-flex items-center gap-2 text-neutral-700"><i data-lucide="globe"
                                    class="h-4 w-4 text-neutral-500"></i> kinchamber.org</div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <button
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium hover:bg-neutral-50"><i
                                data-lucide="map" class="h-4 w-4"></i> Get Directions</button>
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-neutral-100 px-3 py-1 text-xs text-neutral-800">
                            <i data-lucide="shield-check" class="h-4 w-4 text-[#073066]"></i> Accredited</div>
                    </div>
                </section>

                <section class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
                    <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Follow Us</h3>
                    <div class="mt-3 flex items-center gap-2">
                        <a href="#"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50"
                            aria-label="LinkedIn"><i data-lucide="linkedin" class="h-5 w-5"></i></a>
                        <a href="#"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50"
                            aria-label="Twitter"><i data-lucide="twitter" class="h-5 w-5"></i></a>
                        <a href="#"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50"
                            aria-label="Facebook"><i data-lucide="facebook" class="h-5 w-5"></i></a>
                    </div>
                </section>

                <section class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Partner
                            Companies</h3>
                        <button class="text-xs font-medium text-[#073066] hover:underline">All partners</button>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-3">
                        <div class="rounded-lg border border-neutral-200 p-3 text-center"><span
                                class="mx-auto inline-flex h-9 w-9 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-xs font-semibold tracking-tight"
                                style="letter-spacing:-0.02em;">AL</span>
                            <div class="mt-1 text-xs">Alto Labs</div>
                        </div>
                        <div class="rounded-lg border border-neutral-200 p-3 text-center"><span
                                class="mx-auto inline-flex h-9 w-9 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-xs font-semibold tracking-tight"
                                style="letter-spacing:-0.02em;">NV</span>
                            <div class="mt-1 text-xs">Novix</div>
                        </div>
                        <div class="rounded-lg border border-neutral-200 p-3 text-center"><span
                                class="mx-auto inline-flex h-9 w-9 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-xs font-semibold tracking-tight"
                                style="letter-spacing:-0.02em;">PR</span>
                            <div class="mt-1 text-xs">Prax</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Events tab -->
    <div data-chamber-tab="events" class="hidden p-4 sm:p-6">
        <div class="grid gap-5 sm:grid-cols-2">
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1600&auto=format&fit=crop"
                    class="h-40 w-full object-cover" alt="">
                <div class="p-4">
                    <h4 class="text-base font-semibold tracking-tight" style="letter-spacing:-0.01em;">Export Finance
                        Clinic</h4>
                    <p class="mt-1 text-sm text-neutral-600">1:1 sessions with trade finance experts.</p>
                    <div class="mt-3 flex items-center gap-3 text-xs text-neutral-600">
                        <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                            Jan 12</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="clock" class="h-3.5 w-3.5"></i>
                            10:00 AM</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                            Gombe</span>
                    </div>
                    <div class="mt-4"><button
                            class="inline-flex items-center gap-2 rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347]"><i
                                data-lucide="ticket" class="h-4 w-4"></i> Register</button></div>
                </div>
            </article>
            <article
                class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1600&auto=format&fit=crop"
                    class="h-40 w-full object-cover" alt="">
                <div class="p-4">
                    <h4 class="text-base font-semibold tracking-tight" style="letter-spacing:-0.01em;">Regulatory Update
                        Webinar</h4>
                    <p class="mt-1 text-sm text-neutral-600">Compliance essentials for Q1.</p>
                    <div class="mt-3 flex items-center gap-3 text-xs text-neutral-600">
                        <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                            Jan 26</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="clock" class="h-3.5 w-3.5"></i>
                            2:00 PM</span>
                        <span class="inline-flex items-center gap-1"><i data-lucide="video" class="h-3.5 w-3.5"></i>
                            Online</span>
                    </div>
                    <div class="mt-4"><button
                            class="inline-flex items-center gap-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium hover:bg-neutral-50"><i
                                data-lucide="eye" class="h-4 w-4"></i> View Details</button></div>
                </div>
            </article>
        </div>
    </div>

    <!-- Members tab -->
    <div data-chamber-tab="members" class="hidden p-4 sm:p-6">
        <div class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-neutral-200 px-4 py-3 flex items-center justify-between">
                <h3 class="text-sm font-semibold tracking-tight" style="letter-spacing:-0.01em;">Active Members</h3>
                <div class="relative">
                    <input type="text" placeholder="Search members"
                        class="w-48 rounded-md border border-neutral-200 bg-white pl-3 pr-9 py-1.5 text-xs focus:border-[#073066] focus:ring-2 focus:ring-[#073066]/20">
                    <span
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-neutral-400"><i
                            data-lucide="search" class="h-3.5 w-3.5"></i></span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-neutral-50 text-neutral-600">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Company</th>
                            <th class="px-4 py-2 text-left font-medium">Contact</th>
                            <th class="px-4 py-2 text-left font-medium">Email</th>
                            <th class="px-4 py-2 text-left font-medium">Phone</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        <tr class="hover:bg-neutral-50">
                            <td class="px-4 py-2">Kivu Agro</td>
                            <td class="px-4 py-2">Amina K.</td>
                            <td class="px-4 py-2 text-[#073066]">amina@kivuagro.com</td>
                            <td class="px-4 py-2">+243 800 111 222</td>
                        </tr>
                        <tr class="hover:bg-neutral-50">
                            <td class="px-4 py-2">Lumumba Logistics</td>
                            <td class="px-4 py-2">Jean P.</td>
                            <td class="px-4 py-2 text-[#073066]">jean@lumlog.com</td>
                            <td class="px-4 py-2">+243 800 333 444</td>
                        </tr>
                        <tr class="hover:bg-neutral-50">
                            <td class="px-4 py-2">KinTech Labs</td>
                            <td class="px-4 py-2">Chantal M.</td>
                            <td class="px-4 py-2 text-[#073066]">cm@kintechlabs.io</td>
                            <td class="px-4 py-2">+243 800 555 666</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Partners tab -->
    <div data-chamber-tab="partners" class="hidden p-4 sm:p-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center hover:bg-neutral-50"><span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight"
                    style="letter-spacing:-0.02em;">AL</span>
                <div class="mt-2 text-sm">Alto Labs</div>
            </div>
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center hover:bg-neutral-50"><span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight"
                    style="letter-spacing:-0.02em;">NV</span>
                <div class="mt-2 text-sm">Novix</div>
            </div>
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center hover:bg-neutral-50"><span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight"
                    style="letter-spacing:-0.02em;">PR</span>
                <div class="mt-2 text-sm">Prax</div>
            </div>
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center hover:bg-neutral-50"><span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight"
                    style="letter-spacing:-0.02em;">SE</span>
                <div class="mt-2 text-sm">Seren</div>
            </div>
            <div class="rounded-lg border border-neutral-200 bg-white p-4 text-center hover:bg-neutral-50"><span
                    class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 text-neutral-900 text-sm font-semibold tracking-tight"
                    style="letter-spacing:-0.02em;">KO</span>
                <div class="mt-2 text-sm">Kora</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Chamber tabs
    function switchChamberTab(target) {
        document.querySelectorAll('[data-chamber-tab]').forEach(p => {
            p.classList.toggle('hidden', p.getAttribute('data-chamber-tab') !== target);
        });
        document.querySelectorAll('[data-chamber-link]').forEach(t => {
            const active = t.getAttribute('data-chamber-link') === target;
            t.classList.toggle('text-neutral-900', active);
            t.classList.toggle('text-neutral-600', !active);
            t.querySelector('i')?.classList.toggle('text-[#073066]', active);
        });
    }
</script>
@endpush
@endsection
