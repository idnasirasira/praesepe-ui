@props([
    'id' => null,
    'title' => 'Dialog',
    'description' => null,
    'size' => 'md',
    'variant' => 'default',
    'staticBackdrop' => false,
    'open' => false,
])

@php
    use Illuminate\Support\Str;

    $id = $id ?: 'ui-modal-'.Str::random(6);
    $titleId = $id.'-title';
    $descriptionId = $description ? $id.'-description' : null;

    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $isConfirm = $variant === 'confirm';
@endphp

<div
    {{ $attributes }}
    x-data="{
        open: @js((bool) $open),
        id: @js($id),
        staticBackdrop: @js((bool) $staticBackdrop),
        trigger: null,
        show() {
            this.trigger = document.activeElement;
            this.open = true;
        },
        hide() {
            this.open = false;
            this.$nextTick(() => {
                if (this.trigger && typeof this.trigger.focus === 'function') {
                    this.trigger.focus();
                }
            });
        }
    }"
    x-on:ui-modal-open.window="if ($event.detail?.id === id) show()"
    x-on:ui-modal-close.window="if ($event.detail?.id === id) hide()"
    x-on:keydown.escape.window="if (open) hide()"
>
    @if (isset($trigger))
        <span x-on:click="show()">
            {{ $trigger }}
        </span>
    @endif

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-end justify-center p-4 sm:items-center"
            role="dialog"
            aria-modal="true"
            aria-labelledby="{{ $titleId }}"
            @if ($descriptionId) aria-describedby="{{ $descriptionId }}" @endif
            x-trap.inert.noscroll="open"
        >
            <div
                class="absolute inset-0 bg-fg/50"
                x-show="open"
                x-transition.opacity
                x-on:click="if (!staticBackdrop) hide()"
            ></div>

            <div
                class="relative z-10 w-full {{ $sizeClass }} rounded-card border border-border bg-surface-raised p-5 shadow-lg"
                x-show="open"
                x-transition
                x-on:click.stop
            >
                <div class="flex items-start gap-3">
                    @if ($isConfirm)
                        <span class="mt-0.5 inline-flex size-9 items-center justify-center rounded-pill bg-danger-soft text-danger">
                            <x-icons.alert class="size-5" />
                        </span>
                    @endif

                    <div class="min-w-0 flex-1">
                        <h2 id="{{ $titleId }}" class="text-lg font-semibold text-fg">{{ $title }}</h2>
                        @if ($description)
                            <p id="{{ $descriptionId }}" class="mt-1 text-sm text-fg-muted">{{ $description }}</p>
                        @endif
                    </div>

                    <button
                        type="button"
                        class="rounded-control p-1 text-fg-muted hover:bg-surface-sunken hover:text-fg"
                        x-on:click="hide()"
                        aria-label="Close dialog"
                    >
                        <x-icons.x class="size-4" />
                    </button>
                </div>

                @if ($slot->isNotEmpty())
                    <div class="mt-4 text-sm text-fg">
                        {{ $slot }}
                    </div>
                @endif

                <div class="mt-6 flex flex-wrap justify-end gap-2">
                    @isset($footer)
                        {{ $footer }}
                    @else
                        <x-ui.button variant="secondary" x-on:click="hide()">Close</x-ui.button>
                        @isset($action)
                            {{ $action }}
                        @endisset
                    @endisset
                </div>
            </div>
        </div>
    </template>
</div>
