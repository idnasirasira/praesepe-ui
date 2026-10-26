<?php

declare(strict_types=1);

it('serves the home page', function (): void {
    $this->get('/')->assertOk()->assertSee('Praesepe UI', false);
});
