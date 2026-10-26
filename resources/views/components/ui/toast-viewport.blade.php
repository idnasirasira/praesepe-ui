@props([
    'position' => 'bottom-right',
])

@php
    $positionClasses = [
        'bottom-right' => 'right-4 bottom-4 items-end',
        'top-right' => 'right-4 top-4 items-end',
        'top-center' => 'left-1/2 top-4 -translate-x-1/2 items-center',
        'bottom-center' => 'left-1/2 bottom-4 -translate-x-1/2 items-center',
    ];

    $positionClass = $positionClasses[$position] ?? $positionClasses['bottom-right'];
@endphp

{{-- Already rendered at the end of <body> in layouts.app; no teleport needed. --}}
<div
    {{ $attributes->class(['pointer-events-none fixed z-[60] flex w-[min(24rem,calc(100vw-2rem))] flex-col gap-2', $positionClass]) }}
    x-data
    x-init="$store.toasts.position = @js($position)"
    data-ui-toast-viewport
    aria-live="polite"
    aria-relevant="additions text"
>
    <template x-for="toast in $store.toasts.items" x-bind:key="toast.id">
        <div
            class="pointer-events-auto w-full rounded-card border border-border bg-surface-raised p-4 shadow-lg"
            x-bind:role="toast.type === 'danger' ? 'alert' : 'status'"
            x-on:mouseenter="$store.toasts.pause(toast.id)"
            x-on:mouseleave="$store.toasts.resume(toast.id)"
            x-on:focusin="$store.toasts.pause(toast.id)"
            x-on:focusout="$store.toasts.resume(toast.id)"
        >
            <div class="flex items-start gap-3">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-fg" x-text="toast.title" x-show="toast.title"></p>
                    <p class="text-sm text-fg-muted" x-bind:class="toast.title ? 'mt-1' : ''" x-text="toast.message"></p>
                </div>
                <button
                    type="button"
                    class="rounded-control p-1 text-fg-muted hover:bg-surface-sunken hover:text-fg"
                    x-on:click="$store.toasts.dismiss(toast.id)"
                    aria-label="Dismiss notification"
                >
                    <x-icons.x class="size-4" />
                </button>
            </div>
        </div>
    </template>
</div>
