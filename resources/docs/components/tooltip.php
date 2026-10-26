<?php

declare(strict_types=1);

return [
    'slug' => 'tooltip',
    'name' => 'Tooltip',
    'description' => 'Lightweight tooltip wrapper shown on hover and keyboard focus, dismissed by Escape without moving focus, linked via aria-describedby.',
    'category' => 'overlays',
    'tags' => ['tooltip', 'focus', 'hover'],
    'props' => [
        [
            'name' => 'content',
            'type' => 'string',
            'default' => 'required',
            'description' => 'Tooltip text content.',
        ],
        [
            'name' => 'position',
            'type' => 'top|bottom|left|right',
            'default' => 'top',
            'description' => 'Placement of the tooltip bubble relative to the trigger.',
        ],
    ],
    'a11yNotes' => [
        'The tooltip bubble uses role="tooltip" and is referenced from the trigger wrapper with aria-describedby.',
        'Shows on mouseenter and focusin. Hides on mouseleave and focusout.',
        'Escape dismisses the tooltip while leaving keyboard focus on the trigger.',
        'Tooltips should complement visible labels. Do not put essential instructions only in a tooltip.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic tooltip',
            'description' => 'Top placement on a focusable button.',
        ],
        [
            'slug' => 'positions',
            'title' => 'Positions',
            'description' => 'top, bottom, left, and right placements.',
        ],
    ],
];
