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
        <div class="relative mt-0.5 inline-flex size-4 shrink-0">
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
                    'peer absolute inset-0 z-10 size-4 cursor-pointer opacity-0',
                    'disabled:cursor-not-allowed',
                ]) }}
            >

            <span
                @class([
                    'pointer-events-none flex size-4 items-center justify-center rounded-[0.3rem] border bg-surface-raised text-on-brand shadow-sm',
                    'peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--ui-ring)]',
                    'peer-checked:border-brand peer-checked:bg-brand peer-indeterminate:border-brand peer-indeterminate:bg-brand',
                    'peer-checked:[&_.icon-check]:opacity-100 peer-indeterminate:[&_.icon-minus]:opacity-100 peer-checked:[&_.icon-minus]:opacity-0',
                    'peer-disabled:opacity-50',
                    'border-danger' => filled($error),
                    'border-border-strong' => blank($error),
                ])
                aria-hidden="true"
            >
                <x-icons.check class="icon-check size-3 opacity-0" />
                <x-icons.minus class="icon-minus absolute size-3 opacity-0" />
            </span>
        </div>

        <div class="min-w-0 flex-1">
            @if ($label)
                <label for="{{ $id }}" class="block text-sm font-medium text-fg">
                    {{ $label }}
                </label>
            @endif

            @if ($description)
                <p id="{{ $descriptionId }}" class="mt-0.5 text-sm text-fg-muted">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if ($error)
        <p id="{{ $errorId }}" class="mt-1.5 text-xs text-danger">{{ $error }}</p>
    @endif
</div>
