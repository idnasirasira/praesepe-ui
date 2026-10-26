@props([
    'src' => null,
    'alt' => '',
    'name' => null,
    'size' => 'md',
    'status' => null,
])

@php
    use Illuminate\Support\Str;

    $sizeClasses = [
        'xs' => 'size-6 text-[10px]',
        'sm' => 'size-8 text-xs',
        'md' => 'size-10 text-sm',
        'lg' => 'size-12 text-base',
        'xl' => 'size-16 text-lg',
    ];

    $statusClasses = [
        'online' => 'bg-success',
        'busy' => 'bg-warning',
        'offline' => 'bg-fg-subtle',
    ];

    $statusLabels = [
        'online' => 'Online',
        'busy' => 'Busy',
        'offline' => 'Offline',
    ];

    $statusSizeClasses = [
        'xs' => 'size-1.5',
        'sm' => 'size-2',
        'md' => 'size-2.5',
        'lg' => 'size-3',
        'xl' => 'size-3.5',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $statusClass = $statusClasses[$status] ?? null;
    $statusLabel = $statusLabels[$status] ?? null;
    $statusSizeClass = $statusSizeClasses[$size] ?? $statusSizeClasses['md'];

    $initials = null;
    if (filled($name)) {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $initials = Str::upper(collect($parts)->filter()->take(2)->map(fn (string $part): string => Str::substr($part, 0, 1))->implode(''));
    }
@endphp

<span
    {{ $attributes->class(['relative inline-flex shrink-0']) }}
    x-data="{ failed: false }"
>
    <span
        class="relative inline-flex {{ $sizeClass }} items-center justify-center overflow-hidden rounded-full bg-surface-sunken font-medium text-fg ring-2 ring-surface after:pointer-events-none after:absolute after:inset-0 after:rounded-full after:ring-1 after:ring-inset after:ring-black/10 after:content-[''] dark:after:ring-white/15"
        aria-hidden="{{ filled($alt) || filled($name) ? 'false' : 'true' }}"
        @if (filled($alt) || filled($name)) role="img" aria-label="{{ $alt ?: $name }}" @endif
    >
        @if (filled($src))
            <img
                src="{{ $src }}"
                alt=""
                class="size-full object-cover"
                x-show="!failed"
                x-cloak
                x-on:error="failed = true"
            >
        @endif

        <span
            class="inline-flex size-full items-center justify-center"
            @if (filled($src)) x-show="failed" x-cloak @endif
        >
            @if (filled($initials))
                {{ $initials }}
            @else
                <x-icons.user class="size-[55%] shrink-0 text-fg-muted" />
            @endif
        </span>
    </span>

    @if ($statusClass)
        <span
            class="absolute right-0 bottom-0 {{ $statusSizeClass }} rounded-full ring-2 ring-surface {{ $statusClass }}"
            aria-hidden="true"
            title="{{ $statusLabel }}"
        ></span>
        <span class="sr-only">Status: {{ $statusLabel }}</span>
    @endif
</span>
