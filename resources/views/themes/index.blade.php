@extends('layouts.docs')

@section('title', 'Themes · '.config('ui-docs.name'))
@section('meta_description', 'Preview praesepe, minimal, and warm themes with semantic tokens.')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Themes</h1>
    <p class="mt-3 text-fg-muted">
        Switch themes from the header. Each theme defines light and dark semantic tokens in OKLCH.
    </p>

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @foreach ($themes as $theme)
            <button
                type="button"
                class="rounded-card border border-border bg-surface-raised p-5 text-left hover:border-border-strong"
                x-data
                x-on:click="window.PraesepeTheme?.setTheme(@js($theme['id']))"
            >
                <div class="flex h-16 items-end gap-2 rounded-control bg-surface-sunken p-3">
                    <span class="size-6 rounded-full bg-brand"></span>
                    <span class="size-6 rounded-full bg-success"></span>
                    <span class="size-6 rounded-full bg-warning"></span>
                    <span class="size-6 rounded-full bg-danger"></span>
                    <span class="size-6 rounded-full bg-info"></span>
                </div>
                <h2 class="mt-4 text-lg font-semibold text-fg">{{ $theme['name'] }}</h2>
                <p class="mt-1 text-sm text-fg-muted">{{ $theme['description'] }}</p>
            </button>
        @endforeach
    </div>

    <div class="mt-12 space-y-4 rounded-card border border-border bg-surface-raised p-6">
        <h2 class="text-lg font-semibold text-fg">Token samples</h2>
        <div class="flex flex-wrap gap-3">
            <span class="rounded-pill bg-brand px-3 py-1 text-sm text-on-brand">brand</span>
            <span class="rounded-pill bg-success px-3 py-1 text-sm text-on-success">success</span>
            <span class="rounded-pill bg-warning px-3 py-1 text-sm text-on-warning">warning</span>
            <span class="rounded-pill bg-danger px-3 py-1 text-sm text-on-danger">danger</span>
            <span class="rounded-pill bg-info px-3 py-1 text-sm text-on-info">info</span>
        </div>
        <div class="grid gap-3 sm:grid-cols-3">
            <div class="rounded-card border border-border bg-surface p-4 text-sm">surface</div>
            <div class="rounded-card border border-border bg-surface-raised p-4 text-sm shadow-md">surface-raised</div>
            <div class="rounded-card border border-border bg-surface-sunken p-4 text-sm">surface-sunken</div>
        </div>
    </div>
</div>
@endsection
