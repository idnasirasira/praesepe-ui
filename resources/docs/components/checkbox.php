<?php

declare(strict_types=1);

return [
    'slug' => 'checkbox',
    'name' => 'Checkbox',
    'description' => 'Native checkbox with custom check and indeterminate indicators, label, description, error, and attribute forwarding.',
    'category' => 'forms',
    'tags' => ['checkbox', 'form', 'indeterminate'],
    'props' => [
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
        [
            'name' => 'error',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Validation message. Sets aria-invalid and contributes to aria-describedby.',
        ],
        [
            'name' => 'indeterminate',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Sets the native indeterminate state via Alpine x-init.',
        ],
    ],
    'a11yNotes' => [
        'Uses a native checkbox under a custom painted indicator so Space toggles the control when focused.',
        'Label for and input id are linked. Description and error contribute to aria-describedby.',
        'Error state sets aria-invalid="true" on the checkbox.',
        'Indeterminate is a visual/API state only. It is not a third submitted value. Clicking clears indeterminate and checks or unchecks normally.',
        'Pass-through attributes (name, value, required, disabled, checked, x-model, wire:model) land on the input.',
        'Keyboard: Tab focuses the control. Space toggles checked.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic checkbox',
            'description' => 'Label and description with attribute forwarding.',
        ],
        [
            'slug' => 'indeterminate',
            'title' => 'Indeterminate',
            'description' => 'Alpine x-init sets the native indeterminate flag.',
        ],
        [
            'slug' => 'error',
            'title' => 'Validation error',
            'description' => 'Error text linked through aria-describedby.',
        ],
    ],
];
