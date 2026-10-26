<?php

declare(strict_types=1);

it('renders the themes gallery with a custom palette lab', function (): void {
    $response = $this->get('/themes');

    $response->assertOk()
        ->assertSee('Themes', false)
        ->assertSee('Build your own theme', false)
        ->assertSee('Use as my theme', false)
        ->assertSee('Live preview', false)
        ->assertSee('Copy CSS', false)
        ->assertSee('paletteLab()', false)
        ->assertSee('Hue', false)
        ->assertSee('Chroma', false)
        ->assertSee('Lightness', false)
        ->assertSee('Theme name', false)
        ->assertSee('Brand hex', false)
        ->assertSee('Paste a hex value', false)
        ->assertSee('Token samples', false)
        ->assertSee('Indigo brand with cool slate neutrals', false);
});
