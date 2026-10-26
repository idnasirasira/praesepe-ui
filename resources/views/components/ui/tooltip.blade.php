@props([
    'content',
    'position' => 'top',
])

@php
    use Illuminate\Support\Str;

    $id = $attributes->get('id', 'ui-tooltip-'.Str::random(6));
    $tooltipId = $id.'-tip';
    $placement = in_array($position, ['top', 'bottom', 'left', 'right'], true) ? $position : 'top';
@endphp

<span
    {{ $attributes->except(['id'])->class(['relative inline-flex']) }}
    x-data="{
        open: false,
        tooltipId: @js($tooltipId),
        position: @js($placement),
        style: {},
        place() {
            const trigger = this.$refs.trigger;
            if (! trigger) {
                return;
            }

            const rect = trigger.getBoundingClientRect();
            const gap = 8;
            let top = 0;
            let left = 0;
            let transform = 'translate(-50%, -100%)';

            if (this.position === 'bottom') {
                top = rect.bottom + gap;
                left = rect.left + (rect.width / 2);
                transform = 'translateX(-50%)';
            } else if (this.position === 'left') {
                top = rect.top + (rect.height / 2);
                left = rect.left - gap;
                transform = 'translate(-100%, -50%)';
            } else if (this.position === 'right') {
                top = rect.top + (rect.height / 2);
                left = rect.right + gap;
                transform = 'translateY(-50%)';
            } else {
                top = rect.top - gap;
                left = rect.left + (rect.width / 2);
                transform = 'translate(-50%, -100%)';
            }

            this.style = {
                position: 'fixed',
                top: top + 'px',
                left: left + 'px',
                transform,
            };
        },
        show() {
            this.open = true;
            this.$nextTick(() => this.place());
        },
        hide() {
            this.open = false;
        },
    }"
    x-init="
        const target = $refs.trigger.querySelector('button, a, input, select, textarea, [tabindex]') || $refs.trigger;
        target.setAttribute('aria-describedby', tooltipId);
    "
    x-on:mouseenter="show()"
    x-on:mouseleave="hide()"
    x-on:focusin="show()"
    x-on:focusout="hide()"
    x-on:keydown.escape.stop="hide()"
    x-on:scroll.window="if (open) place()"
    x-on:resize.window="if (open) place()"
>
    <span x-ref="trigger" class="inline-flex">
        {{ $slot }}
    </span>

    <template x-teleport="body">
        <span
            id="{{ $tooltipId }}"
            role="tooltip"
            x-show="open"
            x-cloak
            x-bind:style="style"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-none z-[70] w-max max-w-xs rounded-control bg-fg px-2.5 py-1.5 text-xs leading-snug text-fg-inverse shadow-md ring-1 ring-black/5"
        >
            {{ $content }}
        </span>
    </template>
</span>
