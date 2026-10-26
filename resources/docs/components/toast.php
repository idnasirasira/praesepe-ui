<?php

declare(strict_types=1);

return [
    'slug' => 'toast',
    'name' => 'Toast',
    'description' => 'Global toast notifications via Alpine.store and the ui:toast window event, rendered through a body-teleported viewport.',
    'category' => 'feedback',
    'tags' => ['toast', 'notification', 'store'],
    'props' => [
        [
            'name' => 'toast-viewport.position',
            'type' => 'bottom-right|top-right|top-center|bottom-center',
            'default' => 'bottom-right',
            'description' => 'Fixed placement for the teleported toast stack.',
        ],
        [
            'name' => 'event.detail.type',
            'type' => 'info|success|warning|danger',
            'default' => 'info',
            'description' => 'Semantic tone. danger uses role="alert"; others use role="status".',
        ],
        [
            'name' => 'event.detail.duration',
            'type' => 'number',
            'default' => '5000',
            'description' => 'Auto-dismiss milliseconds. Timer pauses while hovered or focused.',
        ],
    ],
    'a11yNotes' => [
        'Viewport teleports to body and uses aria-live="polite" so new toasts are announced without stealing focus.',
        'danger toasts set role="alert". Other types set role="status".',
        'Auto-dismiss timers pause on mouseenter and focusin, then resume on mouseleave and focusout.',
        'Visible stack is capped at 5 toasts. Dismiss buttons are labeled for assistive tech.',
        'Dispatch with window.dispatchEvent(new CustomEvent("ui:toast", { detail: { type, title, message, duration } })).',
    ],
    'examples' => [
        [
            'slug' => 'trigger',
            'title' => 'Dispatch toasts',
            'description' => 'Buttons that fire the ui:toast window event.',
        ],
        [
            'slug' => 'types',
            'title' => 'Types',
            'description' => 'info, success, warning, and danger payloads.',
        ],
    ],
];
