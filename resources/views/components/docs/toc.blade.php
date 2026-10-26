@props([
    'items' => [],
])

@if (count($items) > 0)
    <nav {{ $attributes->class(['space-y-3']) }} aria-label="On this page">
        <p class="text-xs font-semibold uppercase tracking-wider text-fg-subtle">On this page</p>
        <ul class="space-y-1 border-l border-border">
            @foreach ($items as $item)
                <li>
                    <a
                        href="#{{ $item['id'] }}"
                        class="block border-l-2 border-transparent py-1 pl-3 text-sm text-fg-muted transition-colors duration-150 hover:border-border-strong hover:text-fg"
                    >
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
