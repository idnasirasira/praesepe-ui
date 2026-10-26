@props(['class' => 'size-4'])

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.75', 'aria-hidden' => 'true']) }}>
    <circle cx="11" cy="11" r="6.5" />
    <path stroke-linecap="round" d="M16.5 16.5L21 21" />
</svg>
