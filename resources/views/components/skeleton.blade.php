@props([
    'width' => 'w-full',
    'height' => 'h-4',
    'rounded' => 'rounded',
    'class' => ''
])

<div {{ $attributes->merge(['class' => "bg-gray-200 dark:bg-gray-700 animate-pulse {$width} {$height} {$rounded} {$class}"]) }}></div>