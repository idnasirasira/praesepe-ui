<?php

declare(strict_types=1);

return [
    'slug' => 'tabs',
    'name' => 'Tabs',
    'description' => 'Compound WAI-ARIA tabs with underline, pills, and vertical variants, roving tabindex, and arrow key navigation.',
    'category' => 'navigation',
    'tags' => ['tabs', 'tablist', 'keyboard'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'underline|pills|vertical',
            'default' => 'underline',
            'description' => 'Visual style and orientation. Vertical uses up/down arrows.',
        ],
        [
            'name' => 'active',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Initially selected tab id. Defaults to the first enabled tab.',
        ],
        [
            'name' => 'tab.id',
            'type' => 'string',
            'default' => 'required',
            'description' => 'Stable id shared between the tab and its panel.',
        ],
        [
            'name' => 'tab.disabled',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Prevents selection and skips the tab in keyboard traversal.',
        ],
    ],
    'a11yNotes' => [
        'Implements role="tablist", role="tab", and role="tabpanel" with aria-controls and aria-labelledby pairing.',
        'Selected tab uses aria-selected="true" and tabindex="0". Other enabled tabs use tabindex="-1".',
        'Horizontal variants: ArrowLeft and ArrowRight move selection. Vertical variant: ArrowUp and ArrowDown.',
        'Home and End jump to the first and last enabled tabs. Disabled tabs are skipped.',
        'Only the active panel is shown. Panels remain in the DOM for stable ids.',
    ],
    'examples' => [
        [
            'slug' => 'underline',
            'title' => 'Underline',
            'description' => 'Default horizontal underline tabs.',
        ],
        [
            'slug' => 'pills',
            'title' => 'Pills',
            'description' => 'Compact pill-style tablist.',
        ],
        [
            'slug' => 'vertical',
            'title' => 'Vertical',
            'description' => 'Vertical orientation with up/down arrow keys.',
        ],
    ],
];
