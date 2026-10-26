<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('forwards form attributes to the native input element', function (): void {
    $html = Blade::render('<x-ui.input name="email" required placeholder="test" x-model="foo" class="wrapper-class" />');

    expect($html)->toContain('name="email"')
        ->and($html)->toContain('required')
        ->and($html)->toContain('placeholder="test"')
        ->and($html)->toContain('x-model="foo"');

    $dom = new DOMDocument;
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $wrappers = $xpath->query('//div[contains(concat(" ", normalize-space(@class), " "), " wrapper-class ")]');
    $inputs = $xpath->query('//input');

    expect($wrappers)->not->toBeFalse()
        ->and($wrappers->length)->toBe(1)
        ->and($inputs)->not->toBeFalse()
        ->and($inputs->length)->toBe(1);

    /** @var DOMElement $wrapper */
    $wrapper = $wrappers->item(0);
    /** @var DOMElement $input */
    $input = $inputs->item(0);

    expect($wrapper->hasAttribute('name'))->toBeFalse()
        ->and($wrapper->hasAttribute('placeholder'))->toBeFalse()
        ->and($wrapper->hasAttribute('x-model'))->toBeFalse()
        ->and($input->getAttribute('name'))->toBe('email')
        ->and($input->getAttribute('placeholder'))->toBe('test')
        ->and($input->getAttribute('x-model'))->toBe('foo')
        ->and($input->hasAttribute('required'))->toBeTrue();
});
