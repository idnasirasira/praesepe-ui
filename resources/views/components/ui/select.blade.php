@props([
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'error' => null,
    'placeholder' => null,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-select-'.Str::random(6));
    $hintId = $hint ? $id.'-hint' : null;
    $errorId = $error ? $id.'-error' : null;
    $describedBy = collect([$hintId, $errorId])->filter()->implode(' ') ?: null;

    $sizeClasses = [
        'sm' => 'h-8 text-xs pl-2.5 pr-8',
        'md' => 'h-9 text-sm pl-3.5 pr-9',
        'lg' => 'h-10 text-sm pl-4 pr-10',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];

    $controlClasses = [
        'w-full appearance-none rounded-control border bg-surface-raised text-fg shadow-2xs',
        'border-border hover:border-border-strong focus:border-brand transition-colors duration-150',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
        $sizeClass,
        $error ? 'border-danger hover:border-danger focus:border-danger focus-visible:ring-danger' : '',
    ];
@endphp

<div {{ $attributes->only('class')->class(['w-full']) }}>
    @if ($label)
        <label for="{{ $id }}" class="mb-1.5 block text-sm font-medium text-fg">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select
            id="{{ $id }}"
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($error) aria-invalid="true" @endif
            {{ $attributes->except(['class'])->class($controlClasses) }}
        >
            @if (filled($placeholder))
                <option value="" disabled @selected(! $attributes->has('value') && ! $attributes->has('x-model'))>
                    {{ $placeholder }}
                </option>
            @endif
            {{ $slot }}
        </select>

        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-fg-subtle">
            <x-icons.chevron-down class="size-4 shrink-0" />
        </span>
    </div>

    @if ($hint)
        <p id="{{ $hintId }}" class="mt-1.5 text-xs text-fg-muted leading-relaxed">{{ $hint }}</p>
    @endif

    @if ($error)
        <p id="{{ $errorId }}" class="mt-1.5 flex items-start gap-1.5 text-xs text-danger">
            <x-icons.alert class="mt-0.5 size-3.5 shrink-0" />
            <span>{{ $error }}</span>
        </p>
    @endif
</div>
