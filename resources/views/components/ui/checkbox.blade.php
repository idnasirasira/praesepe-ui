@props([
    'label' => null,
    'description' => null,
    'error' => null,
    'indeterminate' => false,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-checkbox-'.Str::random(6));
    $descriptionId = $description ? $id.'-description' : null;
    $errorId = $error ? $id.'-error' : null;
    $describedBy = collect([$descriptionId, $errorId])->filter()->implode(' ') ?: null;
@endphp

<div {{ $attributes->only('class')->class(['w-full']) }}>
    <div class="flex items-start gap-3">
        <div class="relative -ml-1.5 inline-flex size-10 shrink-0 items-center justify-center">
            <input
                type="checkbox"
                id="{{ $id }}"
                @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
                @if ($error) aria-invalid="true" @endif
                @if ($indeterminate)
                    x-data
                    x-init="$el.indeterminate = true"
                @endif
                {{ $attributes->except(['class'])->class([
                    'peer absolute inset-0 z-10 size-full cursor-pointer opacity-0',
                    'disabled:cursor-not-allowed',
                ]) }}
            >

            <span
                @class([
                    'pointer-events-none flex size-4 items-center justify-center rounded-control border bg-surface-raised text-on-brand shadow-2xs',
                    'peer-focus-visible:outline-none peer-focus-visible:ring-2 peer-focus-visible:ring-ring peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-surface',
                    'peer-checked:border-brand peer-checked:bg-brand peer-indeterminate:border-brand peer-indeterminate:bg-brand',
                    'peer-checked:[&_.icon-check]:opacity-100 peer-indeterminate:[&_.icon-minus]:opacity-100 peer-checked:[&_.icon-minus]:opacity-0',
                    'peer-disabled:opacity-50',
                    'border-danger' => filled($error),
                    'border-border-strong' => blank($error),
                ])
                aria-hidden="true"
            >
                <x-icons.check class="icon-check size-3 shrink-0 opacity-0" />
                <x-icons.minus class="icon-minus absolute size-3 shrink-0 opacity-0" />
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

    @if ($error)
        <p id="{{ $errorId }}" class="mt-1.5 flex items-start gap-1.5 text-xs text-danger">
            <x-icons.alert class="mt-0.5 size-3.5 shrink-0" />
            <span>{{ $error }}</span>
        </p>
    @endif
</div>
