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

it('renders avatar initials fallback and status indicator', function (): void {
    $html = Blade::render('<x-ui.avatar name="Siti Rahma" src="https://example.invalid/missing.jpg" status="online" />');

    expect($html)->toContain('SR')
        ->and($html)->toContain('x-on:error="failed = true"')
        ->and($html)->toContain('aria-label="online"')
        ->and($html)->toContain('role="img"');
});

it('renders table region scroll wrapper and sortable aria-sort', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.table selectable label="Daftar pesanan">
            <x-ui.table.head>
                <x-ui.table.cell header select-all />
                <x-ui.table.cell header sortable sort="ascending">Total</x-ui.table.cell>
            </x-ui.table.head>
            <x-ui.table.body>
                <x-ui.table.row id="1">
                    <x-ui.table.cell select-id="1" />
                    <x-ui.table.cell>Rp 100</x-ui.table.cell>
                </x-ui.table.row>
            </x-ui.table.body>
        </x-ui.table>
    BLADE);

    expect($html)->toContain('role="region"')
        ->and($html)->toContain('tabindex="0"')
        ->and($html)->toContain('aria-label="Daftar pesanan"')
        ->and($html)->toContain('aria-sort="ascending"')
        ->and($html)->toContain('aria-label="Select all rows"');
});

it('renders pagination range summary and aria-current page', function (): void {
    $html = Blade::render('<x-ui.pagination variant="numbered" :current="3" :total="5" :per-page="10" :total-items="42" />');

    expect($html)->toContain('Showing')
        ->and($html)->toContain('aria-current="page"')
        ->and($html)->toContain('aria-label="Pagination"')
        ->and($html)->toContain('42');
});
