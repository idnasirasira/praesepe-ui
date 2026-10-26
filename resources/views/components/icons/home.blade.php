@props(['class' => 'size-4'])

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.75', 'aria-hidden' => 'true']) }}>
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 11.5 12 5l7.5 6.5" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 10.5V19h11v-8.5" />
</svg>
