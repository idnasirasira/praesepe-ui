<?php

declare(strict_types=1);

use App\Http\Controllers\RegistryController;
use Illuminate\Support\Facades\Route;

Route::get('/r', [RegistryController::class, 'home'])->name('registry.home');
Route::get('/r/index.json', [RegistryController::class, 'index'])->name('registry.index');
Route::get('/r/schema.json', [RegistryController::class, 'schema'])->name('registry.schema');
Route::get('/r/styles/theme.css', [RegistryController::class, 'theme'])->name('registry.theme');
Route::get('/r/{slug}.json', [RegistryController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('registry.show');
