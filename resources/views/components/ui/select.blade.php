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
        'md' => 'h-10 text-sm pl-3 pr-9',
        'lg' => 'h-11 text-base pl-3.5 pr-10',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];

    $controlClasses = [
        'w-full appearance-none rounded-control border bg-surface-raised text-fg shadow-sm',
        'border-border focus:border-border-strong',
        $sizeClass,
        $error ? 'border-danger' : '',
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
            <x-icons.chevron-down class="size-4" />
        </span>
    </div>

    @if ($hint)
        <p id="{{ $hintId }}" class="mt-1.5 text-xs text-fg-muted">{{ $hint }}</p>
    @endif

    @if ($error)
        <p id="{{ $errorId }}" class="mt-1.5 text-xs text-danger">{{ $error }}</p>
    @endif
</div>
