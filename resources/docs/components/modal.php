<?php

declare(strict_types=1);

return [
    'slug' => 'modal',
    'name' => 'Modal',
    'description' => 'Accessible dialog overlay with focus trap, body teleport, Escape/backdrop dismiss, and confirm variant.',
    'category' => 'overlays',
    'tags' => ['modal', 'dialog', 'overlay'],
    'props' => [
        [
            'name' => 'id',
            'type' => 'string',
            'default' => 'auto',
            'description' => 'Dialog id used for window event open/close targeting.',
        ],
        [
            'name' => 'title',
            'type' => 'string',
            'default' => 'Dialog',
            'description' => 'Accessible dialog title referenced by aria-labelledby.',
        ],
        [
            'name' => 'description',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Optional description referenced by aria-describedby.',
        ],
        [
            'name' => 'size',
            'type' => 'sm|md|lg|xl',
            'default' => 'md',
            'description' => 'Max width of the dialog panel.',
        ],
        [
            'name' => 'variant',
            'type' => 'default|confirm',
            'default' => 'default',
            'description' => 'Confirm variant shows a danger icon treatment.',
        ],
        [
            'name' => 'staticBackdrop',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'When true, backdrop clicks do not close the dialog.',
        ],
        [
            'name' => 'open',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Initial open state for controlled demos.',
        ],
    ],
    'a11yNotes' => [
        'Uses role="dialog", aria-modal="true", aria-labelledby, and optional aria-describedby.',
        'Focus is trapped with Alpine x-trap.inert.noscroll while open. Body scroll is locked.',
        'Dialog content teleports to body to avoid clipping inside overflow-hidden preview containers.',
        'Escape closes the dialog. Backdrop click closes unless staticBackdrop is true.',
        'Focus returns to the trigger element after close.',
        'Open via trigger slot click or window event: window.dispatchEvent(new CustomEvent("ui-modal-open", { detail: { id } })).',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic dialog',
            'description' => 'Inline trigger slot with default actions.',
        ],
        [
            'slug' => 'confirm',
            'title' => 'Confirm variant',
            'description' => 'Destructive confirm pattern with danger treatment.',
        ],
        [
            'slug' => 'event',
            'title' => 'Open via window event',
            'description' => 'Dispatch ui-modal-open with a matching id.',
        ],
    ],
];
