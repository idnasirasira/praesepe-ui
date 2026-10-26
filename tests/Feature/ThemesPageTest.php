<?php

declare(strict_types=1);

it('renders the themes gallery with a custom palette lab', function (): void {
    $response = $this->get('/themes');

    $response->assertOk()
        ->assertSee('Themes', false)
        ->assertSee('Custom palette', false)
        ->assertSee('Live preview', false)
        ->assertSee('Apply to page', false)
        ->assertSee('Copy CSS', false)
        ->assertSee('paletteLab', false)
        ->assertSee('Hue', false)
        ->assertSee('Chroma', false)
        ->assertSee('Lightness', false)
        ->assertSee('Token samples', false)
        ->assertSee('Indigo brand with cool slate neutrals', false);
});
