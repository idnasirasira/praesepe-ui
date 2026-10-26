@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'rows' => 4,
    'maxlength' => null,
    'autosize' => false,
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-textarea-'.Str::random(6));
    $hintId = $hint ? $id.'-hint' : null;
    $errorId = $error ? $id.'-error' : null;
    $counterId = filled($maxlength) ? $id.'-counter' : null;
    $describedBy = collect([$hintId, $errorId, $counterId])->filter()->implode(' ') ?: null;
    $max = filled($maxlength) ? (int) $maxlength : null;
    $initialValue = (string) ($attributes->get('value') ?? '');
    $initialCount = mb_strlen($initialValue);

    $controlClasses = [
        'w-full rounded-control border bg-surface-raised px-3 py-2 text-sm text-fg shadow-sm placeholder:text-fg-subtle',
        'border-border focus:border-border-strong',
        $error ? 'border-danger' : '',
        $autosize ? 'overflow-hidden resize-none' : 'resize-y min-h-24',
    ];
@endphp

<div {{ $attributes->only('class')->class(['w-full']) }}>
    @if ($label)
        <label for="{{ $id }}" class="mb-1.5 block text-sm font-medium text-fg">
            {{ $label }}
        </label>
    @endif

    <div
        @if ($max !== null || $autosize)
            x-data="{
                count: {{ $initialCount }},
                max: {{ $max ?? 'null' }},
                autosize: {{ $autosize ? 'true' : 'false' }},
                resize() {
                    if (!this.autosize) return;
                    const el = this.$refs.control;
                    el.style.height = 'auto';
                    el.style.height = el.scrollHeight + 'px';
                }
            }"
            x-init="resize()"
        @endif
    >
        <textarea
            id="{{ $id }}"
            rows="{{ $rows }}"
            @if ($max !== null) maxlength="{{ $max }}" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($error) aria-invalid="true" @endif
            @if ($max !== null || $autosize)
                x-ref="control"
                x-on:input="count = $event.target.value.length; resize()"
            @endif
            {{ $attributes->except(['class', 'value'])->class($controlClasses) }}
        >{{ $attributes->get('value') }}</textarea>

        @if ($max !== null)
            <p id="{{ $counterId }}" class="mt-1.5 text-right text-xs text-fg-subtle" aria-live="polite">
                <span x-text="count">{{ $initialCount }}</span> / {{ $max }}
            </p>
        @endif
    </div>

    @if ($hint)
        <p id="{{ $hintId }}" class="mt-1.5 text-xs text-fg-muted">{{ $hint }}</p>
    @endif

    @if ($error)
        <p id="{{ $errorId }}" class="mt-1.5 text-xs text-danger">{{ $error }}</p>
    @endif
</div>
