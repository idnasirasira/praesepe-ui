<?php

declare(strict_types=1);

return [
    'slug' => 'input',
    'name' => 'Input',
    'description' => 'Form control archetype with label, hint, error, icons, password toggle, and attribute forwarding to the native input.',
    'category' => 'forms',
    'tags' => ['input', 'form', 'password', 'search'],
    'props' => [
        [
            'name' => 'type',
            'type' => 'text|email|password|number|search',
            'default' => 'text',
            'description' => 'Native input type. Password adds an accessible show/hide toggle.',
        ],
        [
            'name' => 'size',
            'type' => 'sm|md|lg',
            'default' => 'md',
            'description' => 'Control height and text size.',
        ],
        [
            'name' => 'label',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Visible label linked via for/id.',
        ],
        [
            'name' => 'hint',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Helper text referenced by aria-describedby.',
        ],
        [
            'name' => 'error',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Validation message. Sets aria-invalid and contributes to aria-describedby.',
        ],
        [
            'name' => 'leadingIcon',
            'type' => 'slot|null',
            'default' => 'null',
            'description' => 'Optional leading decorative icon slot.',
        ],
        [
            'name' => 'trailingAddon',
            'type' => 'slot|null',
            'default' => 'null',
            'description' => 'Optional trailing text addon when not using password toggle.',
        ],
    ],
    'a11yNotes' => [
        'Generates a stable id when none is provided and wires label for, input id, and aria-describedby for hint and error.',
        'Error state sets aria-invalid="true" on the input.',
        'Pass-through attributes (name, value, required, placeholder, disabled, readonly, x-model, wire:model) land on the native input, not the wrapper.',
        'Password toggle is a button with an accessible label that switches between Show password and Hide password.',
        'Keyboard: Tab reaches the input and the password toggle. Space/Enter activates the toggle.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic field',
            'description' => 'Label, hint, and placeholder with attribute forwarding.',
        ],
        [
            'slug' => 'password',
            'title' => 'Password with toggle',
            'description' => 'Accessible show and hide control.',
        ],
        [
            'slug' => 'error',
            'title' => 'Validation error',
            'description' => 'Error text linked through aria-describedby.',
        ],
    ],
];
