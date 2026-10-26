@props([
    'size' => 'md',
    'label' => null,
    'description' => null,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-switch-'.Str::random(6));
    $descriptionId = $description ? $id.'-description' : null;

    $trackClasses = [
        'sm' => 'h-5 w-9 peer-checked:[&_.thumb]:translate-x-4',
        'md' => 'h-6 w-11 peer-checked:[&_.thumb]:translate-x-5',
    ];

    $thumbClasses = [
        'sm' => 'size-4',
        'md' => 'size-5',
    ];

    $trackClass = $trackClasses[$size] ?? $trackClasses['md'];
    $thumbClass = $thumbClasses[$size] ?? $thumbClasses['md'];
@endphp

<div {{ $attributes->only('class')->class(['w-full']) }}>
    <div class="flex items-start gap-3">
        <div class="relative -ml-1.5 inline-flex size-10 shrink-0 items-center justify-center">
            <input
                type="checkbox"
                role="switch"
                id="{{ $id }}"
                @if ($descriptionId) aria-describedby="{{ $descriptionId }}" @endif
                {{ $attributes->except(['class'])->class([
                    'peer absolute inset-0 z-10 size-full cursor-pointer opacity-0',
                    'disabled:cursor-not-allowed',
                ]) }}
            >

            <span
                class="{{ $trackClass }} pointer-events-none inline-flex items-center rounded-pill bg-border-strong p-0.5 transition-colors duration-150 peer-checked:bg-brand peer-focus-visible:outline-none peer-focus-visible:ring-2 peer-focus-visible:ring-ring peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-surface peer-disabled:opacity-50"
                aria-hidden="true"
            >
                <span class="thumb {{ $thumbClass }} block rounded-full bg-surface-raised shadow-sm transition-transform duration-150 motion-reduce:transition-none"></span>
            </span>
        </div>

        <div class="min-w-0 flex-1 pt-2">
            @if ($label)
                <label for="{{ $id }}" class="block text-sm font-medium text-fg">
                    {{ $label }}
                </label>
            @endif

            @if ($description)
                <p id="{{ $descriptionId }}" class="mt-0.5 text-sm text-fg-muted leading-relaxed">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>
