<?php

declare(strict_types=1);

return [
    'slug' => 'table',
    'name' => 'Table',
    'description' => 'Compound data table with keyboard-scrollable region, striped and hoverable rows, sortable headers, bulk select, and empty state.',
    'category' => 'data-display',
    'tags' => ['table', 'orders', 'sortable'],
    'props' => [
        [
            'name' => 'striped',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Alternating row backgrounds.',
        ],
        [
            'name' => 'hoverable',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Highlight rows on hover.',
        ],
        [
            'name' => 'selectable',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Enables Alpine bulk-select state shared by header and row checkboxes.',
        ],
        [
            'name' => 'label',
            'type' => 'string',
            'default' => 'Data table',
            'description' => 'Accessible name for the scrollable region wrapper.',
        ],
        [
            'name' => 'cell.sortable / cell.sort',
            'type' => 'bool / none|ascending|descending',
            'default' => 'false / none',
            'description' => 'Sortable header button with aria-sort state.',
        ],
    ],
    'a11yNotes' => [
        'The overflow wrapper uses role="region", aria-label, and tabindex="0" so keyboard users can scroll wide tables.',
        'Sortable headers are buttons with aria-sort values: none, ascending, or descending.',
        'Bulk select checkboxes include accessible names. The header checkbox reflects indeterminate state when some rows are selected.',
        'Empty state keeps table structure with a single spanning cell, icon, description, and optional action.',
    ],
    'examples' => [
        [
            'slug' => 'orders',
            'title' => 'Orders table',
            'description' => 'Indonesian SME order list with badges and sortable amount.',
        ],
        [
            'slug' => 'selectable',
            'title' => 'Bulk select',
            'description' => 'Header and row checkboxes driven by Alpine.',
        ],
        [
            'slug' => 'empty',
            'title' => 'Empty state',
            'description' => 'Clean empty table with action slot.',
        ],
    ],
];
