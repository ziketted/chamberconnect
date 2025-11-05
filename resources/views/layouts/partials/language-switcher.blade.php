<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" type="button"
        class="flex items-center gap-2 rounded-md p-2 text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#E71D36]">
        <span class="text-sm">{{ strtoupper(App::getLocale()) }}</span>
        <i data-lucide="chevron-down" class="h-4 w-4"></i>
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-32 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        @foreach(['fr' => 'Français', 'en' => 'English'] as $code => $name)
        <a href="{{ route('language.switch', $code) }}"
            class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 {{ App::getLocale() === $code ? 'bg-neutral-50' : '' }}">
            {{ $name }}
        </a>
        @endforeach
    </div>
</div>
