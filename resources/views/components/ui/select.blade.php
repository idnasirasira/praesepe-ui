@props([
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'error' => null,
    'placeholder' => null,
    'leadingIcon' => null,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-select-'.Str::random(6));
    $hintId = $hint ? $id.'-hint' : null;
    $errorId = $error ? $id.'-error' : null;
    $describedBy = collect([$hintId, $errorId])->filter()->implode(' ') ?: null;
    $hasLeading = filled($leadingIcon);

    $sizeClasses = [
        'sm' => 'h-8 text-xs pr-8',
        'md' => 'h-9 text-sm pr-9',
        'lg' => 'h-10 text-sm pr-10',
    ];

    $padClasses = [
        'sm' => $hasLeading ? 'pl-8' : 'pl-2.5',
        'md' => $hasLeading ? 'pl-9' : 'pl-3.5',
        'lg' => $hasLeading ? 'pl-10' : 'pl-4',
    ];

    $iconInsetClasses = [
        'sm' => 'pl-2.5 [&_svg]:size-3.5',
        'md' => 'pl-3 [&_svg]:size-4',
        'lg' => 'pl-3.5 [&_svg]:size-4',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $padClass = $padClasses[$size] ?? $padClasses['md'];
    $hasPlaceholder = filled($placeholder);
    $placeholderSelected = $hasPlaceholder && ! $attributes->has('value') && ! $attributes->has('x-model');

    $controlClasses = [
        'w-full appearance-none rounded-control border bg-surface-raised shadow-2xs',
        'border-border hover:border-border-strong focus:border-brand transition-colors duration-150',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
        '[&_option]:bg-surface-raised [&_option]:text-fg',
        $sizeClass,
        $padClass,
        $error ? 'border-danger hover:border-danger focus:border-danger focus-visible:ring-danger' : '',
    ];
@endphp

<div {{ $attributes->only('class')->class(['w-full']) }}>
    @if ($label)
        <label for="{{ $id }}" class="mb-1.5 block text-sm font-medium text-fg">
            {{ $label }}
        </label>
    @endif

    <div
        class="relative"
        @if ($hasPlaceholder)
            x-data="{ empty: @js($placeholderSelected) }"
        @endif
    >
        @if ($hasLeading)
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center {{ $iconInsetClasses[$size] ?? $iconInsetClasses['md'] }} text-fg-subtle [&_svg]:shrink-0">
                {{ $leadingIcon }}
            </span>
        @endif

        <select
            id="{{ $id }}"
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($error) aria-invalid="true" @endif
            @if ($hasPlaceholder)
                x-on:change="empty = $event.target.value === ''"
                x-bind:class="empty ? 'text-fg-subtle' : 'text-fg'"
            @endif
            {{ $attributes->except(['class'])->class(array_merge($controlClasses, $hasPlaceholder ? [] : ['text-fg'])) }}
        >
            @if ($hasPlaceholder)
                <option value="" disabled @selected($placeholderSelected) class="text-fg-subtle">
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
