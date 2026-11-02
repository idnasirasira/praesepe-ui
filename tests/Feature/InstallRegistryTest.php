<?php

declare(strict_types=1);

use App\Docs\ComponentRegistry;
use App\Docs\InstallRegistry;
use InvalidArgumentException;

it('resolves install files for every registered component', function (): void {
    $components = app(ComponentRegistry::class);
    $install = app(InstallRegistry::class);

    expect($components->all())->not->toBeEmpty();

    foreach ($components->all() as $page) {
        $package = $install->package($page->slug);

        expect($package['slug'])->toBe($page->slug)
            ->and($package['files'])->not->toBeEmpty();

        foreach ($package['files'] as $file) {
            expect($file)->toHaveKeys(['path', 'type', 'content', 'dependency_of'])
                ->and($file['content'])->not->toBeEmpty()
                ->and($file['path'])->toStartWith('resources/views/components/');
        }
    }
});

it('includes button dependency and spinner icon when installing modal', function (): void {
    $package = app(InstallRegistry::class)->package('modal');

    $paths = array_column($package['files'], 'path');

    expect($package['dependencies'])->toContain('button')
        ->and($paths)->toContain('resources/views/components/ui/modal.blade.php')
        ->and($paths)->toContain('resources/views/components/ui/button.blade.php')
        ->and($paths)->toContain('resources/views/components/icons/spinner.blade.php');
});

it('maps toast slug to toast-viewport blade file', function (): void {
    $package = app(InstallRegistry::class)->package('toast');
    $paths = array_column($package['files'], 'path');

    expect($paths)->toContain('resources/views/components/ui/toast-viewport.blade.php');
});

it('rejects unknown and invalid slugs', function (): void {
    $install = app(InstallRegistry::class);

    expect(fn () => $install->package('does-not-exist'))
        ->toThrow(InvalidArgumentException::class)
        ->and(fn () => $install->package('../etc/passwd'))
        ->toThrow(InvalidArgumentException::class);
});

it('returns theme.css content for init', function (): void {
    $init = app(InstallRegistry::class)->init();

    expect($init['path'])->toBe('resources/css/theme.css')
        ->and($init['content'])->toContain('--ui-')
        ->and($init['checklist'])->not->toBeEmpty();
});
