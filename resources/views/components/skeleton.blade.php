@props([
    'class' => '',
    'width' => 'w-full',
    'height' => 'h-4',
    'rounded' => 'rounded',
    'animate' => true
])

<div {{ $attributes->merge([
    'class' => "bg-gray-200 dark:bg-gray-700 {$width} {$height} {$rounded} " . ($animate ? 'animate-pulse' : '') . " {$class}"
]) }}></div>