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

{{-- Mounted at the end of <body> in layouts.app; fixed positioning already escapes overflow ancestors. --}}
<div
    {{ $attributes->class(['pointer-events-none fixed z-[60] flex w-[min(24rem,calc(100vw-2rem))] flex-col gap-3', $positionClass]) }}
    x-data
    x-init="$store.toasts.position = @js($position)"
    data-ui-toast-viewport
    aria-live="polite"
    aria-relevant="additions text"
>
    <template x-for="toast in $store.toasts.items" x-bind:key="toast.id">
        <div
            class="pointer-events-auto relative w-full overflow-hidden rounded-card border border-border border-l-4 bg-surface-raised p-4 shadow-lg ring-1 ring-border/60"
            x-bind:class="{
                'border-l-info': toast.type === 'info',
                'border-l-success': toast.type === 'success',
                'border-l-warning': toast.type === 'warning',
                'border-l-danger': toast.type === 'danger',
            }"
            x-bind:role="toast.type === 'danger' ? 'alert' : 'status'"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
            x-on:mouseenter="$store.toasts.pause(toast.id)"
            x-on:mouseleave="$store.toasts.resume(toast.id)"
            x-on:focusin="$store.toasts.pause(toast.id)"
            x-on:focusout="$store.toasts.resume(toast.id)"
        >
            <div class="flex items-start gap-3">
                <span
                    class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-pill"
                    x-bind:class="{
                        'bg-info-soft text-info': toast.type === 'info',
                        'bg-success-soft text-success': toast.type === 'success',
                        'bg-warning-soft text-warning': toast.type === 'warning',
                        'bg-danger-soft text-danger': toast.type === 'danger',
                    }"
                    aria-hidden="true"
                >
                    <span class="text-xs font-bold tabular-nums" x-text="toast.type === 'success' ? '✓' : (toast.type === 'info' ? 'i' : '!')"></span>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold tracking-tight text-fg" x-text="toast.title" x-show="toast.title" x-cloak></p>
                    <p class="text-sm text-fg-muted leading-relaxed" x-bind:class="toast.title ? 'mt-1' : ''" x-text="toast.message"></p>
                </div>
                <button
                    type="button"
                    class="inline-flex size-10 shrink-0 items-center justify-center rounded-control text-fg-muted transition-colors duration-150 hover:bg-surface-sunken hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    x-on:click="$store.toasts.dismiss(toast.id)"
                    aria-label="Dismiss notification"
                >
                    <x-icons.x class="size-4 shrink-0" />
                </button>
            </div>

            <div
                class="pointer-events-none absolute inset-x-0 bottom-0 h-0.5 bg-border/50"
                x-show="toast.duration > 0"
                x-cloak
            >
                <div
                    class="h-full w-full origin-left"
                    x-bind:class="{
                        'bg-info/70': toast.type === 'info',
                        'bg-success/70': toast.type === 'success',
                        'bg-warning/70': toast.type === 'warning',
                        'bg-danger/70': toast.type === 'danger',
                        'bg-brand/70': !['info','success','warning','danger'].includes(toast.type),
                    }"
                    style="animation-name: ui-toast-progress; animation-timing-function: linear; animation-fill-mode: forwards;"
                    x-bind:style="`animation-duration: ${toast.duration}ms; animation-play-state: ${toast.hovering ? 'paused' : 'running'}`"
                ></div>
            </div>

            <span
                class="pointer-events-none absolute top-3 right-12 rounded-control bg-surface-sunken px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider text-fg-subtle tabular-nums"
                x-show="toast.hovering && toast.duration > 0"
                x-cloak
                x-text="`Paused · ${Math.ceil(toast.remaining / 1000)}s`"
            ></span>
        </div>
    </template>
</div>
