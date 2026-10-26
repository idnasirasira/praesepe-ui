<?php

declare(strict_types=1);

return [
    'slug' => 'select',
    'name' => 'Select',
    'description' => 'Native select control styled to match input heights, with a decorative chevron, label, hint, error, and attribute forwarding.',
    'category' => 'forms',
    'tags' => ['select', 'form', 'dropdown'],
    'props' => [
        [
            'name' => 'size',
            'type' => 'sm|md|lg',
            'default' => 'md',
            'description' => 'Control height aligned with the input archetype.',
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
            'name' => 'placeholder',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Disabled empty first option shown before real choices. Renders muted until a value is chosen.',
        ],
        [
            'name' => 'leadingIcon',
            'type' => 'slot|null',
            'default' => 'null',
            'description' => 'Optional leading icon. Adjusts left padding to match input (pl-8/pl-9/pl-10 by size).',
        ],
    ],
    'a11yNotes' => [
        'Uses a native select so keyboard navigation (Tab, arrows, Enter/Space) follows platform behavior.',
        'Label for, select id, hint, and error are linked through aria-describedby. Errors set aria-invalid="true".',
        'Pass-through attributes (name, required, disabled, x-model, wire:model) land on the select, not the wrapper.',
        'The chevron is decorative (aria-hidden) and pointer-events-none so it never steals clicks.',
        'Option elements use bg-surface-raised text-fg so native menus do not flash white in dark mode.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic select',
            'description' => 'Label, hint, placeholder option, and required state.',
        ],
        [
            'slug' => 'sizes',
            'title' => 'Sizes',
            'description' => 'sm, md, and lg heights matching input.',
        ],
        [
            'slug' => 'error',
            'title' => 'Validation error',
            'description' => 'Error text linked through aria-describedby.',
        ],
    ],
];
