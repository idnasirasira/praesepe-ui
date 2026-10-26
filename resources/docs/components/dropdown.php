<?php

declare(strict_types=1);

return [
    'slug' => 'dropdown',
    'name' => 'Dropdown',
    'description' => 'Compound menu with keyboard navigation, left/right alignment, danger and disabled items, icons, and shortcut badges.',
    'category' => 'overlays',
    'tags' => ['dropdown', 'menu', 'keyboard'],
    'props' => [
        [
            'name' => 'align',
            'type' => 'left|right',
            'default' => 'left',
            'description' => 'Menu alignment relative to the trigger.',
        ],
        [
            'name' => 'label',
            'type' => 'string',
            'default' => 'Open menu',
            'description' => 'Default trigger label when the trigger slot is omitted.',
        ],
        [
            'name' => 'item.variant',
            'type' => 'default|danger|disabled',
            'default' => 'default',
            'description' => 'Visual and interactive treatment for dropdown items.',
        ],
        [
            'name' => 'item.shortcut',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'Optional keyboard shortcut badge shown on the trailing edge.',
        ],
        [
            'name' => 'item.href',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'When set, the item renders as an anchor menuitem.',
        ],
    ],
    'a11yNotes' => [
        'Trigger exposes aria-haspopup="menu" and x-bind:aria-expanded. The menu uses role="menu" and items use role="menuitem".',
        'ArrowDown and ArrowUp move between enabled items, skipping disabled ones. Home and End jump to the first and last enabled item.',
        'Escape closes the menu and restores focus to the trigger. Tab closes without forcing focus restoration so natural tab order continues.',
        'Click outside closes the menu. Opening with ArrowDown on the trigger focuses the first enabled item.',
        'Disabled items set disabled and aria-disabled="true" and are excluded from the keyboard roving list.',
    ],
    'examples' => [
        [
            'slug' => 'basic',
            'title' => 'Basic menu',
            'description' => 'Default items, separator, danger action, and shortcut badge.',
        ],
        [
            'slug' => 'align-right',
            'title' => 'Right aligned',
            'description' => 'Menu anchored to the right edge of the trigger.',
        ],
        [
            'slug' => 'disabled',
            'title' => 'Disabled item',
            'description' => 'Disabled menuitem is skipped by arrow key navigation.',
        ],
    ],
];
