<?php

declare(strict_types=1);

return [
    'name' => 'Praesepe UI',
    'version' => '0.1.0',
    'praesepe_url' => 'https://praesepe.id',
    // TODO: replace with real WhatsApp deep link when available
    'whatsapp_url' => null,
    // TODO: replace with real studio contact email
    'email' => null,
    // TODO: replace with real GitHub organization or repository URL
    'github_url' => null,
    'navigation' => [
        [
            'label' => 'Getting started',
            'items' => [
                ['label' => 'Installation', 'route' => 'docs.index'],
                ['label' => 'Theming', 'route' => 'docs.theming'],
                ['label' => 'Accessibility', 'route' => 'docs.accessibility'],
            ],
        ],
        [
            'label' => 'Components',
            'items' => [
                ['label' => 'All components', 'route' => 'docs.components.index'],
            ],
        ],
        [
            'label' => 'Explore',
            'items' => [
                ['label' => 'Kitchen sink', 'route' => 'ui.index'],
                ['label' => 'Themes', 'route' => 'themes.index'],
            ],
        ],
    ],
];
