<?php

declare(strict_types=1);

it('serves the home page', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('Praesepe UI', false)
        ->assertSee('Live SME invoice preview', false)
        ->assertSee('Three steps to ship', false)
        ->assertSee('When to choose what', false)
        ->assertSee('Need custom software, internal tools, or ERP workflows for your SME?', false);
});
