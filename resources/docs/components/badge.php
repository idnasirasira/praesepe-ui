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
            'description' => 'Adds a Remove button. Pass x-on:click handlers to the badge to wire dismissal.',
        ],
    ],
    'a11yNotes' => [
        'Badges are non-interactive by default and convey status visually plus text.',
        'Removable badges expose a button with aria-label="Remove". Pair with visible text so color is not the only cue.',
        'Status dots are decorative (aria-hidden) and should accompany a text label such as Lunas or Menunggu.',
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
