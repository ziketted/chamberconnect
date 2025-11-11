<div id="signin-modal" class="invisible pointer-events-none fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 opacity-0 transition-opacity" onclick="closeModal('signin-modal')"></div>
    <div class="relative w-full max-w-md translate-y-6 opacity-0 transition-all">
        <div class="rounded-xl border border-neutral-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-2xl">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold tracking-tight">{{ __('messages.welcome_back') }}</h3>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-gray-400">{{ __('messages.access_hub') }}</p>
                </div>
                <button onclick="closeModal('signin-modal')"
                    class="rounded-md p-1 text-neutral-500 dark:text-gray-500 dark:text-gray-400 hover:bg-neutral-100 dark:bg-gray-700" aria-label="Close">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>
            <form action="{{ route('login') }}" method="POST" class="mt-4 space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">{{ __('messages.email') }}</label>
                    <input type="email" name="email"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                        placeholder="you@company.com">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-medium text-neutral-700 dark:text-gray-300">{{ __('messages.password') }}</label>
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-medium text-[#073066] dark:text-blue-400 hover:underline">{{ __('messages.forgot_password')
                            }}</a>
                    </div>
                    <input type="password" name="password"
                        class="mt-1 w-full rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm focus:border-[#073066] dark:focus:border-blue-500 focus:ring-2 focus:ring-[#073066]/20 dark:focus:ring-blue-500/20"
                        placeholder="••••••••">
                </div>
                <button type="submit"
                    class="w-full rounded-md bg-[#073066] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#052347]">{{
                    __('messages.login') }}</button>
            </form>
            <div class="my-4 flex items-center gap-3">
                <div class="h-px w-full bg-neutral-200"></div>
                <span class="text-xs text-neutral-500 dark:text-gray-500 dark:text-gray-400">{{ __('messages.or') }}</span>
                <div class="h-px w-full bg-neutral-200"></div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('login.google') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:bg-gray-700">
                    <i data-lucide="mail" class="h-4 w-4"></i> Google
                </a>
                <a href="{{ route('login.facebook') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md border border-neutral-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium hover:bg-neutral-50 dark:bg-gray-700">
                    <i data-lucide="facebook" class="h-4 w-4"></i> Facebook
                </a>
            </div>
        </div>
    </div>
</div>
