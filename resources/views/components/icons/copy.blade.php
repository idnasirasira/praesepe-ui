@props(['class' => 'size-4'])

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.75', 'aria-hidden' => 'true']) }}>
    <rect x="8" y="8" width="11" height="11" rx="2" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M5 16V6a2 2 0 0 1 2-2h10" />
</svg>
