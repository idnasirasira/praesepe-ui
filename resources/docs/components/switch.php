<?php

declare(strict_types=1);

return [
    'slug' => 'switch',
    'name' => 'Switch',
    'description' => 'Accessible toggle switch built on a native checkbox with role="switch", sm/md sizes, label, description, and attribute forwarding.',
    'category' => 'forms',
    'tags' => ['switch', 'toggle', 'form'],
    'props' => [
        [
            'name' => 'size',
            'type' => 'sm|md',
            'default' => 'md',
            'description' => 'Track and thumb size.',
        ],
        [
            'name' => 'label',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Visible label linked via for/id.',
        ],
        [
            'name' => 'description',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Supporting text referenced by aria-describedby.',
        ],
    ],
    'a11yNotes' => [
        'Uses input type="checkbox" with role="switch". Browsers expose checked state as the switch value for assistive tech.',
        'Label for and input id are linked. Description contributes to aria-describedby when present.',
        'Focus-visible outline uses the shared --ui-ring token on the painted track via peer-focus-visible.',
        'Pass-through attributes (name, value, checked, disabled, required, x-model, wire:model) land on the checkbox so standard form posts and Livewire bindings work.',
        'Keyboard: Tab focuses the switch. Space toggles on and off.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic switch',
            'description' => 'Label and description with attribute forwarding.',
        ],
        [
            'slug' => 'sizes',
            'title' => 'Sizes',
            'description' => 'sm and md track sizes.',
        ],
        [
            'slug' => 'disabled',
            'title' => 'Disabled',
            'description' => 'Non-interactive disabled state.',
        ],
    ],
];
