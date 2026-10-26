<?php

declare(strict_types=1);

use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SearchIndexController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ThemesController;
use App\Http\Controllers\UiController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
Route::get('/docs/theming', [DocsController::class, 'theming'])->name('docs.theming');
Route::get('/docs/accessibility', [DocsController::class, 'accessibility'])->name('docs.accessibility');
Route::get('/docs/components', [DocsController::class, 'components'])->name('docs.components.index');
Route::get('/docs/components/{slug}', [DocsController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('docs.components.show');

Route::get('/ui', UiController::class)->name('ui.index');
Route::get('/themes', ThemesController::class)->name('themes.index');

Route::get('/search-index.json', SearchIndexController::class)->name('search-index');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
