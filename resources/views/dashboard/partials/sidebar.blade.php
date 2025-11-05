<aside class="lg:col-span-3">
    <div class="sticky top-[88px] space-y-4">
        <nav class="rounded-xl border border-neutral-200 bg-white shadow-sm p-2">
            <a href="{{ route('dashboard') }}" class="dash-link active w-full flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-neutral-800 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('dashboard') ? 'bg-neutral-100' : '' }}">
                <i data-lucide="home" class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-[#E71D36]' : '' }}"></i> Home
            </a>
            <a href="{{ route('dashboard.network') }}" class="dash-link w-full flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('dashboard.network') ? 'bg-neutral-100' : '' }}">
                <i data-lucide="users" class="h-5 w-5 {{ request()->routeIs('dashboard.network') ? 'text-[#E71D36]' : '' }}"></i> My Network
            </a>
            <a href="{{ route('dashboard.jobs') }}" class="dash-link w-full flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('dashboard.jobs') ? 'bg-neutral-100' : '' }}">
                <i data-lucide="briefcase" class="h-5 w-5 {{ request()->routeIs('dashboard.jobs') ? 'text-[#E71D36]' : '' }}"></i> Jobs
            </a>
            <a href="{{ route('dashboard.messages') }}" class="dash-link w-full flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('dashboard.messages') ? 'bg-neutral-100' : '' }}">
                <i data-lucide="message-square" class="h-5 w-5 {{ request()->routeIs('dashboard.messages') ? 'text-[#E71D36]' : '' }}"></i> Messaging
            </a>
            <a href="{{ route('dashboard.notifications') }}" class="dash-link w-full flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('dashboard.notifications') ? 'bg-neutral-100' : '' }}">
                <i data-lucide="bell" class="h-5 w-5 {{ request()->routeIs('dashboard.notifications') ? 'text-[#E71D36]' : '' }}"></i> Notifications
            </a>
        </nav>

        <div class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
            <div class="flex items-center gap-2 text-sm text-neutral-600">
                <i data-lucide="shield" class="h-4 w-4 text-[#E71D36]"></i>
                Verified Business Network
            </div>
        </div>
    </div>
</aside>
