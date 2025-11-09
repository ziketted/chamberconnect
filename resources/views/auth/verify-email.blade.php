@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="rounded-xl border border-neutral-200 bg-white p-8 shadow-sm">
        <!-- Icon -->
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#073066]/10 text-[#073066]">
            <i data-lucide="mail" class="h-6 w-6"></i>
        </div>

        <!-- Title -->
        <h2 class="mt-4 text-center text-2xl font-semibold tracking-tight">{{ __('Verify Your Email Address') }}</h2>

        @if (session('status') == 'verification-link-sent')
        <div class="mt-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <p class="mt-4 text-center text-sm text-neutral-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the
            link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        <div class="mt-6 flex items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full rounded-md bg-[#073066] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#052347] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066]/50">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full rounded-md border border-neutral-300 bg-white px-4 py-2.5 text-sm font-medium text-neutral-700 hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#073066]">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
