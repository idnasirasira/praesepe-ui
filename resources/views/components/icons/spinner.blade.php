@props(['class' => 'size-4'])

<svg {{ $attributes->merge(['class' => $class.' animate-spin', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'aria-hidden' => 'true']) }}>
    <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
    <path class="opacity-90" fill="currentColor" d="M12 3a9 9 0 0 1 9 9h-2.25A6.75 6.75 0 0 0 12 5.25V3Z" />
</svg>
