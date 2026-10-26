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
            this.$nextTick(() => {
                const panel = this.$refs.panel;
                const autofocus = panel?.querySelector('[data-autofocus]');
                const primary = panel?.querySelector('[data-ui-modal-primary]');
                const focusable = panel?.querySelector(
                    'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex=\'-1\'])'
                );
                (autofocus || primary || focusable || panel)?.focus?.();
            });
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
                class="absolute inset-0 bg-overlay backdrop-blur-[2px]"
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click="if (!staticBackdrop) hide()"
            ></div>

            <div
                x-ref="panel"
                tabindex="-1"
                class="relative z-10 w-full {{ $sizeClass }} rounded-card border border-border bg-surface-raised p-5 shadow-lg ring-1 ring-border/60 focus:outline-none"
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                x-on:click.stop
            >
                <div class="flex items-start gap-3">
                    @if ($isConfirm)
                        <span class="mt-0.5 inline-flex size-10 items-center justify-center rounded-pill bg-danger-soft text-danger">
                            <x-icons.alert class="size-5 shrink-0" />
                        </span>
                    @endif

                    <div class="min-w-0 flex-1">
                        <h2 id="{{ $titleId }}" class="text-lg font-semibold tracking-tight text-balance text-fg">{{ $title }}</h2>
                        @if ($description)
                            <p id="{{ $descriptionId }}" class="mt-1 text-sm text-fg-muted leading-relaxed text-pretty">{{ $description }}</p>
                        @endif
                    </div>

                    <button
                        type="button"
                        class="inline-flex size-10 shrink-0 items-center justify-center rounded-control text-fg-muted transition-colors duration-150 hover:bg-surface-sunken hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        x-on:click="hide()"
                        aria-label="Close dialog"
                    >
                        <x-icons.x class="size-4 shrink-0" />
                    </button>
                </div>

                @if ($slot->isNotEmpty())
                    <div class="mt-4 text-sm text-fg leading-relaxed">
                        {{ $slot }}
                    </div>
                @endif

                <div class="mt-6 flex flex-wrap justify-end gap-2">
                    @isset($footer)
                        {{ $footer }}
                    @else
                        <x-ui.button variant="secondary" data-ui-modal-primary x-on:click="hide()">Close</x-ui.button>
                        @isset($action)
                            {{ $action }}
                        @endisset
                    @endisset
                </div>
            </div>
        </div>
    </template>
</div>
