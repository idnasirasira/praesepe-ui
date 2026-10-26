@props([
    'header' => false,
    'sortable' => false,
    'sort' => 'none',
    'selectAll' => false,
    'selectId' => null,
    'numeric' => false,
])

@php
    $sortStates = [
        'none' => 'none',
        'ascending' => 'ascending',
        'descending' => 'descending',
    ];
    $ariaSort = $sortStates[$sort] ?? 'none';
    $actionAttributes = $attributes->whereStartsWith(['x-on:', 'wire:']);
    $cellAttributes = $attributes->whereDoesntStartWith(['x-on:', 'wire:']);
    $numericClass = $numeric ? 'tabular-nums' : '';
@endphp

@if ($header)
    <th
        scope="col"
        @if ($sortable) aria-sort="{{ $ariaSort }}" @endif
        {{ $cellAttributes->class(['px-4 py-2.5 font-semibold', $numericClass]) }}
    >
        @if ($selectAll)
            <input
                type="checkbox"
                class="size-4 rounded border-border-strong"
                x-bind:checked="isAllSelected()"
                x-effect="$el.indeterminate = isIndeterminate()"
                x-on:change="toggleAll()"
                aria-label="Select all rows"
            >
        @elseif ($sortable)
            <button
                type="button"
                class="inline-flex items-center gap-1 rounded-control text-left uppercase tracking-wider hover:text-fg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                {{ $actionAttributes }}
            >
                <span>{{ $slot }}</span>
                <span class="text-fg-subtle" aria-hidden="true">
                    @if ($ariaSort === 'ascending')
                        ↑
                    @elseif ($ariaSort === 'descending')
                        ↓
                    @else
                        ↕
                    @endif
                </span>
            </button>
        @else
            {{ $slot }}
        @endif
    </th>
@else
    <td {{ $cellAttributes->class(['px-4 py-3 align-middle', $numericClass]) }}>
        @if (filled($selectId))
            <input
                type="checkbox"
                class="size-4 rounded border-border-strong"
                x-bind:checked="selected.includes(@js($selectId))"
                x-on:change="toggle(@js($selectId))"
                aria-label="Select row {{ $selectId }}"
            >
        @else
            {{ $slot }}
        @endif
    </td>
@endif
