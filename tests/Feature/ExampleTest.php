<?php

declare(strict_types=1);

it('serves the home page', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('Praesepe UI', false)
        ->assertSee('Interactive SME workspace', false)
        ->assertSee('Three steps to ship', false)
        ->assertSee('When to choose what', false)
        ->assertSee('Architecture &amp; custom software partner', false);
});
