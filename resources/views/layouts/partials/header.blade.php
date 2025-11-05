<header
    class="sticky top-0 z-40 bg-white/70 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b border-neutral-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo + Primary Nav -->
            <div class="flex items-center gap-6">
                <a href="/"
                    class="flex items-center gap-2 rounded-md px-2 py-1.5 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-md bg-[#E71D36] text-white text-sm font-semibold tracking-tight">
                        CC</div>
                    <span class="hidden sm:inline text-sm font-semibold tracking-tight">ChamberConnect DRC</span>
                </a>
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('home') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                    <a href="{{ route('chambers') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('chambers*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                        {{ __('messages.chambers') }}
                    </a>
                    @auth
                    <a href="{{ route('opportunities') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('opportunities*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                        {{ __('messages.opportunities') }}
                    </a>
                    @endauth
                    <a href="{{ route('events') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('events*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                        {{ __('messages.events') }}
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36] {{ request()->routeIs('dashboard*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                        {{ __('messages.dashboard') }}
                    </a>
                    @endauth
                </nav>
            </div>

            <!-- Global Search -->
            <div class="flex-1 mx-4 hidden md:block">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </span>
                    <input type="text" placeholder="{{ __('messages.search_placeholder') }}"
                        class="w-full rounded-md border border-neutral-200 bg-white pl-9 pr-3 py-2 text-sm text-neutral-800 placeholder:text-neutral-400 shadow-sm focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-1">
                <!-- Language Switcher -->
                <div class="relative hidden sm:block" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-1 rounded-md px-2 py-1.5 text-sm font-medium text-neutral-700 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]">
                        <i data-lucide="globe" class="h-4 w-4"></i>
                        <span class="text-xs">{{ strtoupper(app()->getLocale()) }}</span>
                        <i data-lucide="chevron-down" class="h-3 w-3"></i>
                    </button>
                    
                    <!-- Language Dropdown -->
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-2 w-32 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'fr') }}" 
                                class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 {{ app()->getLocale() == 'fr' ? 'bg-neutral-50 font-medium' : '' }}">
                                🇫🇷 Français
                            </a>
                            <a href="{{ route('language.switch', 'en') }}" 
                                class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 {{ app()->getLocale() == 'en' ? 'bg-neutral-50 font-medium' : '' }}">
                                🇺🇸 English
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Auth Actions -->
                <div class="flex items-center gap-1">
                    @guest
                        <a href="{{ route('login') }}"
                            class="ml-2 rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-50 hover:border-neutral-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]">
                            {{ __('auth.login') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="rounded-md bg-[#E71D36] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cf1a30] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]/50">
                            {{ __('auth.register') }}
                        </a>
                    @else
                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="h-6 w-6 rounded-full">
                                @else
                                    <div class="h-6 w-6 rounded-full bg-[#E71D36] flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i data-lucide="chevron-down" class="h-4 w-4"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition
                                class="absolute right-0 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1">
                                    <a href="{{ route('dashboard') }}" 
                                        class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                        <i data-lucide="home" class="inline h-4 w-4 mr-2"></i>
                                        {{ __('messages.dashboard') }}
                                    </a>
                                    <a href="{{ route('profile.edit') }}" 
                                        class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                        <i data-lucide="user" class="inline h-4 w-4 mr-2"></i>
                                        {{ __('messages.profile') }}
                                    </a>
                                    @if(Auth::user()->is_admin)
                                        <a href="{{ route('chambers.create') }}" 
                                            class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                            <i data-lucide="plus" class="inline h-4 w-4 mr-2"></i>
                                            {{ __('messages.create_chamber') }}
                                        </a>
                                        <a href="{{ route('admin.chambers.admins') }}" 
                                            class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                            <i data-lucide="settings" class="inline h-4 w-4 mr-2"></i>
                                            {{ __('messages.administration') }}
                                        </a>
                                    @endif
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                            class="block w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                            <i data-lucide="log-out" class="inline h-4 w-4 mr-2"></i>
                                            {{ __('messages.logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
    <!-- Secondary Nav for small screens -->
    <div class="md:hidden border-t border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 py-2 flex items-center gap-2 overflow-x-auto">
            <a href="{{ route('home') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-100 {{ request()->routeIs('home') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                {{ __('messages.home') }}
            </a>
            <a href="{{ route('chambers') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-100 {{ request()->routeIs('chambers*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                {{ __('messages.chambers') }}
            </a>
            @auth
            <a href="{{ route('opportunities') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-100 {{ request()->routeIs('opportunities*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                {{ __('messages.opportunities') }}
            </a>
            @endauth
            <a href="{{ route('events') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-100 {{ request()->routeIs('events*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                {{ __('messages.events') }}
            </a>
            @auth
            <a href="{{ route('dashboard') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-100 {{ request()->routeIs('dashboard*') ? 'bg-neutral-100 text-neutral-900' : '' }}">
                {{ __('messages.dashboard') }}
            </a>
            @endauth
            
            <!-- Mobile Language Switcher -->
            <div class="sm:hidden ml-auto">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                        <i data-lucide="globe" class="h-3 w-3"></i>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-1 w-28 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'fr') }}" 
                                class="block px-3 py-1.5 text-xs text-neutral-700 hover:bg-neutral-100 {{ app()->getLocale() == 'fr' ? 'bg-neutral-50 font-medium' : '' }}">
                                🇫🇷 FR
                            </a>
                            <a href="{{ route('language.switch', 'en') }}" 
                                class="block px-3 py-1.5 text-xs text-neutral-700 hover:bg-neutral-100 {{ app()->getLocale() == 'en' ? 'bg-neutral-50 font-medium' : '' }}">
                                🇺🇸 EN
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
