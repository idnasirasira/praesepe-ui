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

it('renders interactive cards with a stretched link pattern', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.card variant="interactive" href="/customers/1">
            <x-slot:title>CV Berkah Jaya</x-slot:title>
            Active customer
            <x-slot:footer>
                <button type="button" class="relative z-10">Remind</button>
            </x-slot:footer>
        </x-ui.card>
    BLADE);

    expect($html)->toContain('href="/customers/1"')
        ->and($html)->toContain('after:absolute after:inset-0')
        ->and($html)->toContain('relative z-10');
});
