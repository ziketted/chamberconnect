<footer class="border-t border-neutral-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-md bg-[#E71D36] text-white text-sm font-semibold tracking-tight">
                    CC</div>
                <div>
                    <div class="text-sm font-semibold tracking-tight">{{ __('messages.app_name') }}</div>
                    <div class="text-xs text-neutral-500">{{ __('messages.accredited_chamber') }}</div>
                </div>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <a href="#" class="text-neutral-700 hover:text-neutral-900">{{ __('messages.about') }}</a>
                <a href="#" class="text-neutral-700 hover:text-neutral-900">{{ __('messages.events') }}</a>
                <a href="#" class="text-neutral-700 hover:text-neutral-900">{{ __('messages.partners') }}</a>
                <a href="#" class="text-neutral-700 hover:text-neutral-900">{{ __('messages.support') }}</a>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-between border-t border-neutral-200 pt-6">
            <p class="text-xs text-neutral-500">&copy; {{ date('Y') }} {{ __('messages.app_name') }}. {{
                __('messages.all_rights_reserved') }}</p>
            <div class="flex items-center gap-3">
                <a href="#"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50"
                    aria-label="LinkedIn"><i data-lucide="linkedin" class="h-4 w-4"></i></a>
                <a href="#"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50"
                    aria-label="Twitter"><i data-lucide="twitter" class="h-4 w-4"></i></a>
                <a href="#"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-neutral-200 hover:bg-neutral-50"
                    aria-label="Facebook"><i data-lucide="facebook" class="h-4 w-4"></i></a>
            </div>
        </div>
    </div>
</footer>
