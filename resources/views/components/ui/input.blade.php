@props([
    'type' => 'text',
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'error' => null,
    'leadingIcon' => null,
    'trailingAddon' => null,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-input-'.Str::random(6));
    $hintId = $hint ? $id.'-hint' : null;
    $errorId = $error ? $id.'-error' : null;
    $describedBy = collect([$hintId, $errorId])->filter()->implode(' ') ?: null;

    $sizeClasses = [
        'sm' => 'h-8 text-xs px-2.5',
        'md' => 'h-9 text-sm px-3.5',
        'lg' => 'h-10 text-sm px-4',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $hasLeading = filled($leadingIcon);
    $isPassword = $type === 'password';
    $inputType = $isPassword ? 'password' : $type;

    $controlClasses = [
        'w-full rounded-control border bg-surface-raised text-fg shadow-2xs placeholder:text-fg-subtle tabular-nums',
        'border-border hover:border-border-strong focus:border-brand transition-colors duration-150',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
        $sizeClass,
        $hasLeading ? 'pl-9' : '',
        ($isPassword || filled($trailingAddon)) ? 'pr-10' : '',
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
        @if ($isPassword)
            x-data="{ show: false }"
        @endif
        class="relative"
    >
        @if ($hasLeading)
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-fg-subtle [&_svg]:size-4 [&_svg]:shrink-0">
                {{ $leadingIcon }}
            </span>
        @endif

        <input
            @if ($isPassword)
                x-bind:type="show ? 'text' : 'password'"
            @else
                type="{{ $inputType }}"
            @endif
            id="{{ $id }}"
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($error) aria-invalid="true" @endif
            {{ $attributes->except(['class'])->class($controlClasses) }}
        >

        @if ($isPassword)
            <button
                type="button"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-fg-muted hover:text-fg"
                x-on:click="show = !show"
                x-bind:aria-label="show ? 'Hide password' : 'Show password'"
            >
                <span x-show="!show"><x-icons.eye class="size-4 shrink-0" /></span>
                <span x-show="show" x-cloak><x-icons.eye-off class="size-4 shrink-0" /></span>
            </button>
        @elseif (filled($trailingAddon))
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm tabular-nums text-fg-muted">
                {{ $trailingAddon }}
            </span>
        @endif
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
