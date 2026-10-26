@props(['class' => 'size-5'])

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.75', 'aria-hidden' => 'true']) }}>
    <circle cx="12" cy="8" r="3.25" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 19.5c1.6-3 4-4.5 6.5-4.5s4.9 1.5 6.5 4.5" />
</svg>
