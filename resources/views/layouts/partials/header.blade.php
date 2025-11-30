<header
    class="sticky top-0 z-40 bg-white dark:bg-gray-800/70 dark:bg-gray-900/70 backdrop-blur supports-[backdrop-filter]:bg-white dark:bg-gray-800/60 dark:supports-[backdrop-filter]:bg-gray-900/60 border-b border-neutral-200 dark:border-gray-700">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/"
                    class="flex items-center gap-2 rounded-md px-2 py-1.5 hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-md bg-[#073066] text-white text-sm font-semibold tracking-tight">
                        CC</div>
                    <span
                        class="hidden sm:inline text-sm font-semibold tracking-tight text-gray-900 dark:text-white">ChambreRDC</span>
                </a>
            </div>

            <!-- Centered Navigation -->
            <nav class="hidden md:flex items-center gap-2 absolute left-1/2 transform -translate-x-1/2">
                @auth
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('dashboard*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    {{ __('messages.dashboard') }}
                </a>
                @endauth

                @guest
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('home') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                    <i data-lucide="home" class="h-4 w-4"></i>
                    {{ __('messages.home') }}
                </a>
                @endguest

                <a href="{{ route('chambers') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('chambers*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                    <i data-lucide="building" class="h-4 w-4"></i>
                    {{ __('messages.chambers') }}
                </a>

                @guest
                <a href="{{ route('opportunities') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('opportunities*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                    <i data-lucide="briefcase" class="h-4 w-4"></i>
                    {{ __('messages.opportunities') }}
                </a>
                @endguest

                <a href="{{ route('events') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('events') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                    <i data-lucide="calendar" class="h-4 w-4"></i>
                    {{ __('messages.events') }}
                </a>

                @auth
                <a href="{{ route('events.my-bookings') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('events.my-bookings') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                    <i data-lucide="bookmark" class="h-4 w-4"></i>
                    Mes réservations
                </a>

                @if(Auth::user()->isRegularUser() || Auth::user()->isChamberManager())
                <!-- Portail Dropdown for Regular Users -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-neutral-700 dark:text-gray-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500 {{ request()->routeIs('portal.chamber.*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                        <i data-lucide="building-2" class="h-4 w-4"></i>
                        Portail
                        <i data-lucide="chevron-down" class="h-3.5 w-3.5"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition
                        class="absolute left-0 mt-2 w-56 rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-gray-600 focus:outline-none z-50">
                        <div class="py-1">
                            <a href="{{ route('portal.chamber.create') }}"
                                class="block px-4 py-2 text-sm text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-700">
                                <i data-lucide="plus" class="inline h-4 w-4 mr-2"></i>
                                Nouvelle demande
                            </a>
                            <a href="{{ route('portal.index') }}"
                                class="block px-4 py-2 text-sm text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-700">
                                <i data-lucide="file-text" class="inline h-4 w-4 mr-2"></i>
                                Mes demandes
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @endauth
            </nav>

            <!-- Right side - User Actions -->
            <div class="flex items-center gap-1">
                <!-- Auth Actions -->
                <div class="flex items-center gap-1">
                    @guest
                    <a href="{{ route('login') }}"
                        class="ml-2 rounded-md border border-neutral-300 dark:border-gray-600 dark:border-gray-400 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-neutral-900 dark:text-gray-100 hover:bg-neutral-50 dark:hover:bg-gray-700 hover:border-neutral-400 dark:hover:border-gray-500 dark:border-gray-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500">
                        {{ __('auth.login') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="rounded-md bg-[#073066] px-3 py-2 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066] dark:focus-visible:ring-blue-500/50">
                        {{ __('auth.register') }}
                    </a>
                    @else
                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#2563eb] dark:focus-visible:ring-blue-500">
                            @if(Auth::user()->avatar || Auth::user()->profile_photo_path)
                            <div class="relative">
                                <img src="{{ asset('storage/' . (Auth::user()->avatar ?? Auth::user()->profile_photo_path)) }}" 
                                     alt="{{ Auth::user()->name }}"
                                     class="h-8 w-8 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm ring-2 ring-blue-100 dark:ring-blue-900/30">
                                <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                            </div>
                            @else
                            <div class="relative">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-[#2563eb] to-[#1e40af] flex items-center justify-center text-white text-xs font-bold shadow-sm ring-2 ring-blue-100 dark:ring-blue-900/30">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                </div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                            </div>
                            @endif
                            <div class="hidden sm:block text-left">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit(Auth::user()->name, 20) }}</div>
                                @if(Auth::user()->company)
                                <div class="text-xs text-neutral-500 dark:text-gray-400">{{ Str::limit(Auth::user()->company, 20) }}</div>
                                @endif
                            </div>
                            <i data-lucide="chevron-down" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <!-- Dropdown Menu Premium -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-72 origin-top-right rounded-xl bg-white dark:bg-gray-800 shadow-xl ring-1 ring-neutral-200 dark:ring-gray-700 focus:outline-none z-50 overflow-hidden">
                            
                            <!-- Header du menu -->
                            <div class="px-4 py-3 bg-gradient-to-r from-[#2563eb] to-[#1e40af]">
                                <div class="flex items-center gap-3">
                                    @if(Auth::user()->avatar || Auth::user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . (Auth::user()->avatar ?? Auth::user()->profile_photo_path)) }}" 
                                             alt="{{ Auth::user()->name }}"
                                             class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-md">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-base font-bold border-2 border-white shadow-md">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-blue-100 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu items -->
                            <div class="py-2">
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="home" class="h-4 w-4"></i>
                                    </div>
                                    <span>{{ __('messages.dashboard') }}</span>
                                </a>
                                
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="user" class="h-4 w-4"></i>
                                    </div>
                                    <span>{{ __('messages.profile') }}</span>
                                </a>
                                
                                <a href="{{ route('events.my-bookings') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="calendar-check" class="h-4 w-4"></i>
                                    </div>
                                    <span>Mes réservations</span>
                                </a>
                                
                                <a href="{{ route('settings') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="settings" class="h-4 w-4"></i>
                                    </div>
                                    <span>{{ __('Paramètres') }}</span>
                                </a>
                                
                                @if(Auth::user()->isSuperAdmin())
                                <div class="my-2 border-t border-neutral-200 dark:border-gray-700"></div>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                                    </div>
                                    <span>Administration</span>
                                </a>
                                <a href="{{ route('chambers.create') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                    </div>
                                    <span>{{ __('messages.create_chamber') }}</span>
                                </a>
                                <a href="{{ route('admin.chambers') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="building" class="h-4 w-4"></i>
                                    </div>
                                    <span>Gérer les chambres</span>
                                </a>
                                <a href="{{ route('admin.users') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="users" class="h-4 w-4"></i>
                                    </div>
                                    <span>Gérer les utilisateurs</span>
                                </a>
                                @elseif(Auth::user()->isChamberManager())
                                <div class="my-2 border-t border-neutral-200 dark:border-gray-700"></div>
                                <a href="{{ route('manage-chambers.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                        <i data-lucide="briefcase" class="h-4 w-4"></i>
                                    </div>
                                    <span>Gestion des chambres</span>
                                </a>
                                @endif
                            </div>
                            
                            <!-- Footer avec déconnexion -->
                            <div class="border-t border-neutral-200 dark:border-gray-700 bg-neutral-50 dark:bg-gray-700/30 p-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors group">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-100 dark:bg-gray-700 text-neutral-600 dark:text-gray-400 group-hover:scale-110 transition-transform">
                                            <i data-lucide="log-out" class="h-4 w-4"></i>
                                        </div>
                                        <span>{{ __('messages.logout') }}</span>
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
    <div class="md:hidden border-t border-neutral-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 py-2 flex items-center gap-2 overflow-x-auto">
            @auth
            <a href="{{ route('dashboard') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 {{ request()->routeIs('dashboard*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                <i data-lucide="layout-dashboard" class="h-3 w-3"></i>
                {{ __('messages.dashboard') }}
            </a>
            @endauth

            @guest
            <a href="{{ route('home') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                <i data-lucide="home" class="h-3 w-3"></i>
                {{ __('messages.home') }}
            </a>
            @endguest

            <a href="{{ route('chambers') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 {{ request()->routeIs('chambers*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                <i data-lucide="building" class="h-3 w-3"></i>
                {{ __('messages.chambers') }}
            </a>

            @guest
            <a href="{{ route('opportunities') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 {{ request()->routeIs('opportunities*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                <i data-lucide="briefcase" class="h-3 w-3"></i>
                {{ __('messages.opportunities') }}
            </a>
            @endguest

            <a href="{{ route('events') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 {{ request()->routeIs('events*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                <i data-lucide="calendar" class="h-3 w-3"></i>
                {{ __('messages.events') }}
            </a>

            @auth
            @if(Auth::user()->isRegularUser() || Auth::user()->isChamberManager())
            <a href="{{ route('portal.chamber.create') }}"
                class="whitespace-nowrap inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:hover:bg-gray-800 {{ request()->routeIs('portal.chamber.*') ? 'bg-neutral-100 dark:bg-gray-800 text-neutral-900 dark:text-white' : '' }}">
                <i data-lucide="building-2" class="h-3 w-3"></i>
                Portail
            </a>
            @endif
            @endauth

            <!-- Mobile Language Switcher -->
            {{-- <div class="sm:hidden ml-auto">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:bg-gray-700">
                        <i data-lucide="globe" class="h-3 w-3"></i>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>

                    <div x-show="open" x-transition
                        class="absolute right-0 mt-1 w-28 rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'fr') }}"
                                class="block px-3 py-1.5 text-xs text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:bg-gray-700 {{ app()->getLocale() == 'fr' ? 'bg-neutral-50 dark:bg-gray-700 font-medium' : '' }}">
                                🇫🇷 FR
                            </a>
                            <a href="{{ route('language.switch', 'en') }}"
                                class="block px-3 py-1.5 text-xs text-neutral-700 dark:text-gray-300 hover:bg-neutral-100 dark:bg-gray-700 {{ app()->getLocale() == 'en' ? 'bg-neutral-50 dark:bg-gray-700 font-medium' : '' }}">
                                🇺🇸 EN
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</header>