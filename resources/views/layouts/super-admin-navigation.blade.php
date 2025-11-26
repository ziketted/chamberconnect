<nav x-data="{ open: false }" class="bg-gradient-to-r from-red-900 to-red-800 dark:from-red-950 dark:to-red-900 border-b border-red-700 dark:border-red-800 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center gap-3">
                        <x-application-logo class="block h-12 w-auto" />
                        <span class="hidden sm:inline text-white font-bold text-xs">SuperAdmin</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('super-admin.dashboard') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('super-admin.dashboard') ? 'border-white text-white' : 'border-transparent text-red-100 hover:text-white hover:border-red-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        <i data-lucide="layout-dashboard" class="h-4 w-4 mr-2"></i>
                        Tableau de bord
                    </a>

                    <a href="{{ route('super-admin.chambers.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('super-admin.chambers.*') ? 'border-white text-white' : 'border-transparent text-red-100 hover:text-white hover:border-red-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        <i data-lucide="building-2" class="h-4 w-4 mr-2"></i>
                        Chambres
                    </a>

                    <a href="{{ route('super-admin.managers.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('super-admin.managers.*') ? 'border-white text-white' : 'border-transparent text-red-100 hover:text-white hover:border-red-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        <i data-lucide="users" class="h-4 w-4 mr-2"></i>
                        Gestionnaires
                    </a>

                    <a href="{{ route('super-admin.notifications.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('super-admin.notifications.*') ? 'border-white text-white' : 'border-transparent text-red-100 hover:text-white hover:border-red-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        <i data-lucide="mail" class="h-4 w-4 mr-2"></i>
                        Notifications
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-100 bg-red-800 hover:text-white hover:bg-red-700 focus:outline-none transition ease-in-out duration-150">
                            <i data-lucide="shield-alert" class="h-4 w-4 mr-2"></i>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2">
                            <div class="font-medium text-sm text-gray-800 dark:text-gray-200">SuperAdmin</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Gestion complète du système</div>
                        </div>
                        <div class="border-t my-1 border-gray-100 dark:border-gray-700"></div>
                        
                        <x-dropdown-link :href="route('profile.edit')">
                            <i data-lucide="user" class="h-4 w-4 mr-2 inline"></i>
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('settings')">
                            <i data-lucide="settings" class="h-4 w-4 mr-2 inline"></i>
                            {{ __('Paramètres') }}
                        </x-dropdown-link>

                        <div class="border-t my-1 border-gray-100 dark:border-gray-700"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i data-lucide="log-out" class="h-4 w-4 mr-2 inline"></i>
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-red-100 dark:text-red-200 hover:text-white dark:hover:text-white hover:bg-red-700 dark:hover:bg-red-700 focus:outline-none focus:bg-red-700 dark:focus:bg-red-700 focus:text-white dark:focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('super-admin.dashboard') }}"
                class="block w-full text-left px-4 py-2 border-l-4 {{ request()->routeIs('super-admin.dashboard') ? 'border-white text-white bg-red-700' : 'border-transparent text-red-100 hover:text-white hover:bg-red-700 hover:border-white' }} text-base font-medium transition duration-150 ease-in-out">
                <i data-lucide="layout-dashboard" class="h-4 w-4 mr-2 inline"></i>
                Tableau de bord
            </a>

            <a href="{{ route('super-admin.chambers.index') }}"
                class="block w-full text-left px-4 py-2 border-l-4 {{ request()->routeIs('super-admin.chambers.*') ? 'border-white text-white bg-red-700' : 'border-transparent text-red-100 hover:text-white hover:bg-red-700 hover:border-white' }} text-base font-medium transition duration-150 ease-in-out">
                <i data-lucide="building-2" class="h-4 w-4 mr-2 inline"></i>
                Chambres
            </a>

            <a href="{{ route('super-admin.managers.index') }}"
                class="block w-full text-left px-4 py-2 border-l-4 {{ request()->routeIs('super-admin.managers.*') ? 'border-white text-white bg-red-700' : 'border-transparent text-red-100 hover:text-white hover:bg-red-700 hover:border-white' }} text-base font-medium transition duration-150 ease-in-out">
                <i data-lucide="users" class="h-4 w-4 mr-2 inline"></i>
                Gestionnaires
            </a>

            <a href="{{ route('super-admin.notifications.index') }}"
                class="block w-full text-left px-4 py-2 border-l-4 {{ request()->routeIs('super-admin.notifications.*') ? 'border-white text-white bg-red-700' : 'border-transparent text-red-100 hover:text-white hover:bg-red-700 hover:border-white' }} text-base font-medium transition duration-150 ease-in-out">
                <i data-lucide="mail" class="h-4 w-4 mr-2 inline"></i>
                Notifications
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-red-700 dark:border-red-800">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-red-100">SuperAdmin</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-left text-red-100 hover:text-white hover:bg-red-700 rounded-md text-base font-medium transition duration-150 ease-in-out">
                    <i data-lucide="user" class="h-4 w-4 mr-2 inline"></i>
                    {{ __('Profil') }}
                </a>
                <a href="{{ route('settings') }}"
                    class="block px-4 py-2 text-left text-red-100 hover:text-white hover:bg-red-700 rounded-md text-base font-medium transition duration-150 ease-in-out">
                    <i data-lucide="settings" class="h-4 w-4 mr-2 inline"></i>
                    {{ __('Paramètres') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="block px-4 py-2 text-left text-red-100 hover:text-white hover:bg-red-700 rounded-md text-base font-medium transition duration-150 ease-in-out">
                        <i data-lucide="log-out" class="h-4 w-4 mr-2 inline"></i>
                        {{ __('Déconnexion') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>


