<?php

declare(strict_types=1);

return [
    'slug' => 'textarea',
    'name' => 'Textarea',
    'description' => 'Multi-line form control with rows or autosize, optional character counter, label, hint, error, and attribute forwarding.',
    'category' => 'forms',
    'tags' => ['textarea', 'form', 'counter'],
    'props' => [
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
            'name' => 'rows',
            'type' => 'int',
            'default' => '4',
            'description' => 'Initial visible row count for the native textarea.',
        ],
        [
            'name' => 'maxlength',
            'type' => 'int|null',
            'default' => 'null',
            'description' => 'When set, shows a live count / max counter linked via aria-describedby.',
        ],
        [
            'name' => 'autosize',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Grow height to fit content via Alpine on input.',
        ],
    ],
    'a11yNotes' => [
        'Label for, textarea id, hint, error, and optional counter ids are wired through aria-describedby.',
        'Error state sets aria-invalid="true" on the textarea.',
        'Character counter uses aria-live="polite" so assistive tech hears count updates without stealing focus.',
        'Pass-through attributes (name, required, disabled, readonly, placeholder, x-model, wire:model) land on the textarea.',
        'Keyboard: Tab focuses the control. Standard text editing keys apply.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic textarea',
            'description' => 'Label, hint, and rows-based sizing.',
        ],
        [
            'slug' => 'counter',
            'title' => 'Character counter',
            'description' => 'Live count / max linked through aria-describedby.',
        ],
        [
            'slug' => 'error',
            'title' => 'Validation error',
            'description' => 'Error text with aria-invalid.',
        ],
    ],
];
