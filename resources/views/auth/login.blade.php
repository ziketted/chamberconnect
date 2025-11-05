@extends('layouts.app')

@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <div class="flex justify-center">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E71D36] text-white text-lg font-semibold">
                CC</div>
        </div>
        <h2 class="mt-6 text-center text-2xl font-semibold leading-9 tracking-tight text-gray-900">{{
            __('auth.sign_in_to_account') }}</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.email_address')
                    }}</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#E71D36] sm:text-sm sm:leading-6">
                </div>
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">{{ __('auth.password')
                    }}</label>
                <div class="mt-2">
                    <input id="password" name="password" type="password" required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#E71D36] sm:text-sm sm:leading-6">
                </div>
                @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-[#E71D36] focus:ring-[#E71D36]">
                    <label for="remember" class="ml-3 block text-sm leading-6 text-gray-900">{{ __('auth.remember_me')
                        }}</label>
                </div>

                <div class="text-sm leading-6">
                    <a href="{{ route('password.request') }}" class="font-medium text-[#E71D36] hover:text-[#cf1a30]">{{
                        __('auth.forgot_password') }}</a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-[#E71D36] px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-[#cf1a30] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#E71D36]">
                    {{ __('auth.login') }}
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm font-medium leading-6">
                    <span class="bg-white px-6 text-gray-500">{{ __('auth.or_continue_with') }}</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4">
                <a href="{{ route('login.google') }}"
                    class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#E71D36]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>
                    Google
                </a>

                <a href="{{ route('login.facebook') }}"
                    class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#E71D36]">
                    <svg class="h-5 w-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z" />
                    </svg>
                    Facebook
                </a>
            </div>
        </div>

        <p class="mt-10 text-center text-sm text-gray-500">
            {{ __('auth.no_account') }}
            <a href="{{ route('register') }}" class="font-semibold leading-6 text-[#E71D36] hover:text-[#cf1a30]">{{
                __('auth.sign_up_here') }}</a>
        </p>
    </div>
</div>
@endsection
