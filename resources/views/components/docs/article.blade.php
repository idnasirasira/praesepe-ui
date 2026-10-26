@props([
    'wide' => false,
])

<article {{ $attributes->class([
    'docs-prose mx-auto',
    $wide ? 'max-w-4xl' : 'max-w-3xl',
]) }}>
    {{ $slot }}
</article>
