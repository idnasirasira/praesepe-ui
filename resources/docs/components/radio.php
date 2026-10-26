<?php

declare(strict_types=1);

return [
    'slug' => 'radio',
    'name' => 'Radio',
    'description' => 'Native radio option with inline default layout or selectable card panels, label, description, and attribute forwarding.',
    'category' => 'forms',
    'tags' => ['radio', 'form', 'card'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'default|card',
            'default' => 'default',
            'description' => 'Inline list item or bordered selectable card. Cards highlight with :has(input:checked).',
        ],
        [
            'name' => 'label',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Visible label linked via for/id (or wrapping label for card).',
        ],
        [
            'name' => 'description',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Supporting text referenced by aria-describedby.',
        ],
    ],
    'a11yNotes' => [
        'Uses a native radio input so arrow keys move within a name group and Space selects the focused option.',
        'Default variant links label for to input id. Card variant wraps the control in a label for a larger hit target.',
        'Description is linked with aria-describedby when provided.',
        'Pass-through attributes (name, value, checked, disabled, required, x-model, wire:model) land on the input.',
        'Compose a group by rendering multiple radios that share the same name.',
        'Keyboard: Tab enters the group. Arrow keys change the selected option within the group.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Inline group',
            'description' => 'Default variant as a vertical radio list.',
        ],
        [
            'slug' => 'card',
            'title' => 'Card variant',
            'description' => 'Selectable panels highlighted with :has(input:checked).',
        ],
        [
            'slug' => 'disabled',
            'title' => 'Disabled option',
            'description' => 'Disabled state on a single option.',
        ],
    ],
];
