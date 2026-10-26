<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders dropdown trigger and menu aria contracts', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.dropdown label="Actions">
            <x-ui.dropdown.item>Edit</x-ui.dropdown.item>
            <x-ui.dropdown.item variant="disabled">Locked</x-ui.dropdown.item>
            <x-ui.dropdown.separator />
            <x-ui.dropdown.item variant="danger">Delete</x-ui.dropdown.item>
        </x-ui.dropdown>
    BLADE);

    expect($html)->toContain('aria-haspopup="menu"')
        ->and($html)->toContain('x-bind:aria-expanded')
        ->and($html)->toContain('role="menu"')
        ->and($html)->toContain('role="menuitem"')
        ->and($html)->toContain('role="separator"')
        ->and($html)->toContain('aria-disabled="true"');
});
