<?php

declare(strict_types=1);

it('defines required ui tokens across themes and dark blocks', function (): void {
    $css = file_get_contents(resource_path('css/theme.css'));

    expect($css)->not->toBeFalse();

    $requiredTokens = [
        '--ui-brand',
        '--ui-on-brand',
        '--ui-surface',
        '--ui-surface-raised',
        '--ui-surface-sunken',
        '--ui-border',
        '--ui-border-strong',
        '--ui-ring',
        '--ui-fg',
        '--ui-fg-muted',
        '--ui-fg-subtle',
        '--ui-fg-inverse',
        '--ui-overlay',
        '--ui-danger',
        '--ui-danger-soft',
        '--ui-on-danger',
        '--ui-success',
        '--ui-success-soft',
        '--ui-on-success',
        '--ui-warning',
        '--ui-warning-soft',
        '--ui-on-warning',
        '--ui-info',
        '--ui-info-soft',
        '--ui-on-info',
        '--ui-radius-control',
        '--ui-radius-card',
        '--ui-radius-pill',
        '--ui-shadow-sm',
        '--ui-shadow-md',
        '--ui-shadow-lg',
    ];

    foreach ($requiredTokens as $token) {
        expect($css)->toContain($token);
    }

    expect($css)->toContain("[data-theme='praesepe']")
        ->and($css)->toContain("[data-theme='minimal']")
        ->and($css)->toContain("[data-theme='warm']")
        ->and($css)->toContain('html.dark[data-theme=\'praesepe\']')
        ->and($css)->toContain('html.dark[data-theme=\'minimal\']')
        ->and($css)->toContain('html.dark[data-theme=\'warm\']')
        ->and($css)->toContain('@custom-variant dark')
        ->and($css)->toContain('@theme inline')
        ->and($css)->toContain('--ui-warning: oklch(0.68 0.17 55)')
        ->and($css)->toContain('--ui-on-warning: oklch(0.99 0.01 70)');

    $appCss = file_get_contents(resource_path('css/app.css'));

    expect($appCss)->toContain('@source \'../views/**/*.blade.php\'')
        ->and($appCss)->toContain('@source \'../snippets/**/*.html\'')
        ->and($appCss)->toContain('@source \'../docs/**/*.php\'')
        ->and($appCss)->toContain('[x-cloak]')
        ->and($appCss)->toContain('prefers-reduced-motion');
});
