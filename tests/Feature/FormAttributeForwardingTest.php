<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

/**
 * @return array{0: DOMElement, 1: DOMElement}
 */
function assertControlReceivesAttributes(string $html, string $controlXPath): array
{
    $dom = new DOMDocument;
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $wrappers = $xpath->query('//div[contains(concat(" ", normalize-space(@class), " "), " wrapper-class ")]');
    $controls = $xpath->query($controlXPath);

    expect($wrappers)->not->toBeFalse()
        ->and($wrappers->length)->toBeGreaterThanOrEqual(1)
        ->and($controls)->not->toBeFalse()
        ->and($controls->length)->toBeGreaterThanOrEqual(1);

    /** @var DOMElement $wrapper */
    $wrapper = $wrappers->item(0);
    /** @var DOMElement $control */
    $control = $controls->item(0);

    expect($wrapper->hasAttribute('name'))->toBeFalse()
        ->and($wrapper->hasAttribute('x-model'))->toBeFalse();

    return [$wrapper, $control];
}

it('forwards form attributes to the native input element', function (): void {
    $html = Blade::render('<x-ui.input name="email" required placeholder="test" x-model="foo" class="wrapper-class" />');

    [, $input] = assertControlReceivesAttributes($html, '//input');

    expect($input->getAttribute('name'))->toBe('email')
        ->and($input->getAttribute('placeholder'))->toBe('test')
        ->and($input->getAttribute('x-model'))->toBe('foo')
        ->and($input->hasAttribute('required'))->toBeTrue();
});

it('forwards form attributes to the native select element', function (): void {
    $html = Blade::render('<x-ui.select name="plan" required x-model="plan" class="wrapper-class"><option value="a">A</option></x-ui.select>');

    [, $select] = assertControlReceivesAttributes($html, '//select');

    expect($select->getAttribute('name'))->toBe('plan')
        ->and($select->getAttribute('x-model'))->toBe('plan')
        ->and($select->hasAttribute('required'))->toBeTrue();
});

it('forwards form attributes to the native textarea element', function (): void {
    $html = Blade::render('<x-ui.textarea name="bio" required placeholder="Tell us" x-model="bio" class="wrapper-class" />');

    [, $textarea] = assertControlReceivesAttributes($html, '//textarea');

    expect($textarea->getAttribute('name'))->toBe('bio')
        ->and($textarea->getAttribute('placeholder'))->toBe('Tell us')
        ->and($textarea->getAttribute('x-model'))->toBe('bio')
        ->and($textarea->hasAttribute('required'))->toBeTrue();
});

it('forwards form attributes to the native checkbox element', function (): void {
    $html = Blade::render('<x-ui.checkbox name="terms" value="1" required x-model="accepted" class="wrapper-class" />');

    [, $input] = assertControlReceivesAttributes($html, '//input[@type="checkbox"]');

    expect($input->getAttribute('name'))->toBe('terms')
        ->and($input->getAttribute('value'))->toBe('1')
        ->and($input->getAttribute('x-model'))->toBe('accepted')
        ->and($input->hasAttribute('required'))->toBeTrue();
});

it('forwards form attributes to the native radio element', function (): void {
    $html = Blade::render('<x-ui.radio name="cycle" value="monthly" required x-model="cycle" class="wrapper-class" />');

    [, $input] = assertControlReceivesAttributes($html, '//input[@type="radio"]');

    expect($input->getAttribute('name'))->toBe('cycle')
        ->and($input->getAttribute('value'))->toBe('monthly')
        ->and($input->getAttribute('x-model'))->toBe('cycle')
        ->and($input->hasAttribute('required'))->toBeTrue();
});

it('forwards form attributes on card radio variant to the native input', function (): void {
    $html = Blade::render('<x-ui.radio variant="card" name="region" value="sg" x-model="region" class="wrapper-class" />');

    $dom = new DOMDocument;
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $labels = $xpath->query('//label[contains(concat(" ", normalize-space(@class), " "), " wrapper-class ")]');
    $inputs = $xpath->query('//input[@type="radio"]');

    expect($labels)->not->toBeFalse()
        ->and($labels->length)->toBe(1)
        ->and($inputs)->not->toBeFalse()
        ->and($inputs->length)->toBe(1);

    /** @var DOMElement $label */
    $label = $labels->item(0);
    /** @var DOMElement $input */
    $input = $inputs->item(0);

    expect($label->hasAttribute('name'))->toBeFalse()
        ->and($label->hasAttribute('x-model'))->toBeFalse()
        ->and($input->getAttribute('name'))->toBe('region')
        ->and($input->getAttribute('value'))->toBe('sg')
        ->and($input->getAttribute('x-model'))->toBe('region');
});
