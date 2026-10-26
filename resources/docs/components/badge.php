<?php

declare(strict_types=1);

return [
    'slug' => 'badge',
    'name' => 'Badge',
    'description' => 'Compact status labels with solid, soft, and outline tones, optional status dots, and removable actions.',
    'category' => 'data-display',
    'tags' => ['badge', 'status', 'label'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'solid|soft|outline',
            'default' => 'soft',
            'description' => 'Surface treatment for the badge.',
        ],
        [
            'name' => 'color',
            'type' => 'neutral|brand|success|warning|danger|info',
            'default' => 'neutral',
            'description' => 'Semantic color mapped through static class strings.',
        ],
        [
            'name' => 'size',
            'type' => 'sm|md',
            'default' => 'md',
            'description' => 'Badge density.',
        ],
        [
            'name' => 'dot',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Shows a leading status dot.',
        ],
        [
            'name' => 'removable',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Adds a compact Remove button with an expanded invisible touch target. Pass x-on:click handlers to wire dismissal.',
        ],
        [
            'name' => 'dismissible',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Alias of removable for filter-pill APIs.',
        ],
        [
            'name' => 'dismissLabel',
            'type' => 'string',
            'default' => 'Remove',
            'description' => 'Accessible label for the dismiss control.',
        ],
        [
            'name' => 'icon',
            'type' => 'slot|null',
            'default' => 'null',
            'description' => 'Optional leading icon slot. Optical size is size-3 (sm) or size-3.5 (md).',
        ],
    ],
    'a11yNotes' => [
        'Badges are non-interactive by default and convey status visually plus text.',
        'Removable badges expose a button with a configurable aria-label (default Remove). Pair with visible text so color is not the only cue.',
        'Status dots are decorative (aria-hidden) and should accompany a text label such as Lunas or Menunggu.',
        'Soft badges use an inset ring-current/15 hairline so they stay crisp on sunken and raised surfaces in light and dark themes.',
    ],
    'examples' => [
        [
            'slug' => 'invoice-status',
            'title' => 'Invoice statuses',
            'description' => 'Indonesian SME invoice states using soft badges with dots.',
        ],
        [
            'slug' => 'variants',
            'title' => 'Variants and colors',
            'description' => 'Solid, soft, and outline across semantic colors.',
        ],
        [
            'slug' => 'removable',
            'title' => 'Removable filter chip',
            'description' => 'Dismissible badge for active filters.',
        ],
    ],
];
