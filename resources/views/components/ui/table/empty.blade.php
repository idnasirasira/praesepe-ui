@props([
    'title' => 'No results',
    'description' => null,
])

<tr>
    <td colspan="100%" {{ $attributes->class(['px-4 py-12 text-center']) }}>
        <div class="mx-auto flex max-w-sm flex-col items-center gap-3">
            <span class="inline-flex size-10 items-center justify-center rounded-pill bg-surface-sunken text-fg-muted">
                <x-icons.search class="size-5" />
            </span>
            <div>
                <p class="text-sm font-semibold text-fg">{{ $title }}</p>
                @if ($description)
                    <p class="mt-1 text-sm text-fg-muted">{{ $description }}</p>
                @endif
            </div>
            @isset($action)
                <div class="mt-1">
                    {{ $action }}
                </div>
            @endisset
            {{ $slot }}
        </div>
    </td>
</tr>
