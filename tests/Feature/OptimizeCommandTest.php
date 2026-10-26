<?php

declare(strict_types=1);

it('runs optimize and optimize clear without serialization errors', function (): void {
    $this->artisan('optimize')->assertSuccessful();
    $this->artisan('route:cache')->assertSuccessful();
    $this->artisan('view:cache')->assertSuccessful();
    $this->artisan('config:cache')->assertSuccessful();
    $this->artisan('optimize:clear')->assertSuccessful();
});
