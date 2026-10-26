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
        'md' => 'h-10 text-sm px-3',
        'lg' => 'h-11 text-base px-3.5',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $hasLeading = filled($leadingIcon);
    $isPassword = $type === 'password';
    $inputType = $isPassword ? 'password' : $type;

    $controlClasses = [
        'w-full rounded-control border bg-surface-raised text-fg shadow-sm placeholder:text-fg-subtle',
        'border-border focus:border-border-strong',
        $sizeClass,
        $hasLeading ? 'pl-9' : '',
        ($isPassword || filled($trailingAddon)) ? 'pr-10' : '',
        $error ? 'border-danger' : '',
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
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-fg-subtle">
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
                <span x-show="!show"><x-icons.eye class="size-4" /></span>
                <span x-show="show" x-cloak><x-icons.eye-off class="size-4" /></span>
            </button>
        @elseif (filled($trailingAddon))
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-fg-muted">
                {{ $trailingAddon }}
            </span>
        @endif
    </div>

    @if ($hint)
        <p id="{{ $hintId }}" class="mt-1.5 text-xs text-fg-muted">{{ $hint }}</p>
    @endif

    @if ($error)
        <p id="{{ $errorId }}" class="mt-1.5 text-xs text-danger">{{ $error }}</p>
    @endif
</div>
