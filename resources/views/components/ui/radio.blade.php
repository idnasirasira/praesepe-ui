@props([
    'variant' => 'default',
    'label' => null,
    'description' => null,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-radio-'.Str::random(6));
    $descriptionId = $description ? $id.'-description' : null;
    $isCard = $variant === 'card';
@endphp

@if ($isCard)
    <label
        for="{{ $id }}"
        {{ $attributes->only('class')->class([
            'flex cursor-pointer items-start gap-3 rounded-card border border-border bg-surface-raised p-4 shadow-2xs transition-colors duration-150',
            'hover:border-border-strong has-[:checked]:border-brand has-[:checked]:bg-brand/5',
            'has-[:disabled]:cursor-not-allowed has-[:disabled]:opacity-50',
            'focus-within:outline-none focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2 focus-within:ring-offset-surface',
        ]) }}
    >
        <span class="relative -ml-1.5 inline-flex size-10 shrink-0 items-center justify-center">
            <input
                type="radio"
                id="{{ $id }}"
                @if ($descriptionId) aria-describedby="{{ $descriptionId }}" @endif
                {{ $attributes->except(['class'])->class([
                    'peer absolute inset-0 z-10 size-full cursor-pointer opacity-0',
                    'disabled:cursor-not-allowed',
                ]) }}
            >
            <span
                class="pointer-events-none flex size-4 items-center justify-center rounded-full border border-border-strong bg-surface-raised shadow-2xs peer-checked:border-brand peer-checked:[&_.icon-dot]:opacity-100"
                aria-hidden="true"
            >
                <span class="icon-dot size-2 rounded-full bg-brand opacity-0"></span>
            </span>
        </span>

        <span class="min-w-0 flex-1 pt-2">
            @if ($label)
                <span class="block text-sm font-medium text-fg">{{ $label }}</span>
            @endif
            @if ($description)
                <span id="{{ $descriptionId }}" class="mt-0.5 block text-sm text-fg-muted leading-relaxed">{{ $description }}</span>
            @endif
        </span>
    </label>
@else
    <div {{ $attributes->only('class')->class(['inline-flex items-start gap-3']) }}>
        <div class="relative -ml-1.5 inline-flex size-10 shrink-0 items-center justify-center">
            <input
                type="radio"
                id="{{ $id }}"
                @if ($descriptionId) aria-describedby="{{ $descriptionId }}" @endif
                {{ $attributes->except(['class'])->class([
                    'peer absolute inset-0 z-10 size-full cursor-pointer opacity-0',
                    'disabled:cursor-not-allowed',
                ]) }}
            >
            <span
                class="pointer-events-none flex size-4 items-center justify-center rounded-full border border-border-strong bg-surface-raised shadow-2xs peer-focus-visible:outline-none peer-focus-visible:ring-2 peer-focus-visible:ring-ring peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-surface peer-checked:border-brand peer-checked:[&_.icon-dot]:opacity-100 peer-disabled:opacity-50"
                aria-hidden="true"
            >
                <span class="icon-dot size-2 rounded-full bg-brand opacity-0"></span>
            </span>
        </div>

        <div class="min-w-0 pt-2">
            @if ($label)
                <label for="{{ $id }}" class="block text-sm font-medium text-fg">{{ $label }}</label>
            @endif
            @if ($description)
                <p id="{{ $descriptionId }}" class="mt-0.5 text-sm text-fg-muted leading-relaxed">{{ $description }}</p>
            @endif
        </div>
    </div>
@endif
