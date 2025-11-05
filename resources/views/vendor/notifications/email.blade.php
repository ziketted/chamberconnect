<x-mail::message>
    {{-- Header --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <div
            style="display: inline-block; background-color: #E71D36; color: white; width: 50px; height: 50px; line-height: 50px; border-radius: 8px; font-weight: 600; font-size: 18px;">
            CC
        </div>
    </div>

    {{-- Greeting --}}
    @if (! empty($greeting))
    # {{ $greeting }}
    @else
    @if ($level === 'error')
    # @lang('Whoops!')
    @else
    # @lang('Hello!')
    @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
    {{ $line }}

    @endforeach

    {{-- Action Button --}}
    @isset($actionText)
    <?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
    <x-mail::button :url="$actionUrl" :color="$color">
        {{ $actionText }}
    </x-mail::button>
    @endisset

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
    {{ $line }}

    @endforeach

    {{-- Salutation --}}
    @if (! empty($salutation))
    {{ $salutation }}
    @else
    @lang('Regards'),<br>
    {{ config('app.name') }}
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
    <x-slot:subcopy>
        @lang(
        "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
        'into your web browser:',
        [
        'actionText' => $actionText,
        ]
        ) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
    </x-slot:subcopy>
    @endisset
</x-mail::message>
