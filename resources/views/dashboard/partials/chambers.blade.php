<aside class="lg:col-span-3">
    <div class="sticky top-[88px] space-y-4">
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
            <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold tracking-tight">Your Chambers</h3>
                <a href="{{ route('chambers.manage') }}" class="text-xs font-medium text-[#073066] dark:text-blue-400 hover:underline">Manage</a>
            </div>
            <ul class="divide-y divide-neutral-200">
                @foreach($userChambers as $chamber)
                <li class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">{{ $chamber->flag_emoji }}</span>
                        <div>
                            <div class="text-sm font-medium">{{ $chamber->name }}</div>
                            <div class="text-xs text-neutral-500 dark:text-gray-500 dark:text-gray-400">{{ number_format($chamber->members_count) }} members</div>
                        </div>
                    </div>
                    <button onclick="toggleBookmark(this)" class="rounded-full p-1.5 text-neutral-600 dark:text-gray-400 hover:bg-neutral-100 dark:hover:bg-gray-700 hover:text-[#073066] dark:hover:text-blue-400" aria-label="Favorite" aria-pressed="{{ $chamber->is_favorite ? 'true' : 'false' }}">
                        <i data-lucide="heart" class="h-4 w-4 {{ $chamber->is_favorite ? 'fill-[#073066] dark:fill-blue-400 text-[#073066] dark:text-blue-400' : '' }}"></i>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm p-4">
            <div class="flex items-center gap-2">
                <i data-lucide="headset" class="h-4 w-4 text-[#073066] dark:text-blue-400"></i>
                <div class="text-sm">
                    Need help? <button onclick="openChatWidget()" class="text-[#073066] dark:text-blue-400 font-medium hover:underline">Chat with us</button>
                </div>
            </div>
        </div>
    </div>
</aside>

@push('scripts')
<script>
    function openChatWidget() {
        // Implement your chat widget logic here
        console.log('Opening chat widget...');
    }
</script>
@endpush
