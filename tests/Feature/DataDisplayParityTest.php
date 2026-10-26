<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders badge tone classes without dynamic concatenation artifacts', function (): void {
    $html = Blade::render('<x-ui.badge variant="soft" color="success" dot removable>Lunas</x-ui.badge>');

    expect($html)->toContain('bg-success-soft')
        ->and($html)->toContain('text-success')
        ->and($html)->toContain('aria-label="Remove"')
        ->and($html)->not->toContain('bg-{$');
});
