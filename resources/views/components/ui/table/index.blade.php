@props([
    'striped' => false,
    'hoverable' => false,
    'label' => 'Data table',
    'selectable' => false,
])

@php
    $tableClasses = [
        'w-full min-w-[40rem] border-collapse text-left text-sm text-fg',
        $striped ? '[&_tbody_tr:nth-child(odd)]:bg-surface-sunken/60' : '',
        $hoverable ? '[&_tbody_tr:hover]:bg-surface-sunken' : '',
    ];
@endphp

<div
    {{ $attributes->class(['relative']) }}
    @if ($selectable)
        x-data="{
            selected: [],
            allIds: [],
            register(id) {
                if (!this.allIds.includes(id)) this.allIds.push(id);
            },
            toggleAll() {
                this.selected = this.selected.length === this.allIds.length ? [] : [...this.allIds];
            },
            toggle(id) {
                this.selected = this.selected.includes(id)
                    ? this.selected.filter((value) => value !== id)
                    : [...this.selected, id];
            },
            isAllSelected() {
                return this.allIds.length > 0 && this.selected.length === this.allIds.length;
            },
            isIndeterminate() {
                return this.selected.length > 0 && this.selected.length < this.allIds.length;
            }
        }"
    @endif
>
    <div
        class="overflow-x-auto rounded-card border border-border focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-[var(--ui-ring)]"
        role="region"
        aria-label="{{ $label }}"
        tabindex="0"
    >
        <table class="{{ implode(' ', array_filter($tableClasses)) }}">
            {{ $slot }}
        </table>
    </div>
</div>
