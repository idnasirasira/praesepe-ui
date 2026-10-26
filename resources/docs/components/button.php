<?php

declare(strict_types=1);

return [
    'slug' => 'button',
    'name' => 'Button',
    'description' => 'Polymorphic button and link control with variants, sizes, loading, and disabled states.',
    'category' => 'actions',
    'tags' => ['button', 'link', 'cta'],
    'props' => [
        [
            'name' => 'variant',
            'type' => 'primary|secondary|outline|ghost|danger|link',
            'default' => 'primary',
            'description' => 'Visual style mapped to complete static class strings.',
        ],
        [
            'name' => 'size',
            'type' => 'sm|md|lg|icon-sm|icon-md|icon-lg',
            'default' => 'md',
            'description' => 'Control height and padding, including icon-only sizes.',
        ],
        [
            'name' => 'href',
            'type' => 'string|null',
            'default' => 'null',
            'description' => 'When set, renders an anchor instead of a button.',
        ],
        [
            'name' => 'type',
            'type' => 'button|submit|reset',
            'default' => 'button',
            'description' => 'Native button type when href is absent.',
        ],
        [
            'name' => 'disabled',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Disables interaction. Anchors use aria-disabled and tabindex=-1.',
        ],
        [
            'name' => 'loading',
            'type' => 'bool',
            'default' => 'false',
            'description' => 'Shows a spinner, sets aria-busy, and prevents double activation.',
        ],
    ],
    'a11yNotes' => [
        'Renders a native button with an explicit type, or an anchor when href is provided.',
        'Disabled anchors expose aria-disabled="true" and tabindex="-1" instead of relying on the disabled attribute.',
        'Loading state sets aria-busy="true", shows a decorative spinner (aria-hidden), and keeps the control non-interactive.',
        'Focus-visible outline comes from the global :focus-visible rule using --ui-ring.',
        'Keyboard: Tab focuses the control. Enter and Space activate buttons. Enter activates links.',
    ],
    'examples' => [
        [
            'slug' => 'variants',
            'title' => 'Variants',
            'description' => 'Primary, secondary, outline, ghost, danger, and link styles.',
        ],
        [
            'slug' => 'sizes',
            'title' => 'Sizes',
            'description' => 'Compact through large, plus icon-only sizes.',
        ],
        [
            'slug' => 'states',
            'title' => 'States',
            'description' => 'Disabled, loading, and polymorphic link usage.',
        ],
    ],
];
