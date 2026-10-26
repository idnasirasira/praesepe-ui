@extends('layouts.app')

@section('title', config('ui-docs.name').' · Blade components for Laravel')
@section('meta_description', 'Copy-paste Blade components for Laravel developers using Tailwind CSS 4 and Alpine.js 3.')

@section('body')
<div class="min-h-dvh">
    <header class="border-b border-border">
        <div class="mx-auto flex h-14 max-w-5xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('home') }}" class="font-semibold text-fg">{{ config('ui-docs.name') }}</a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('docs.index') }}" class="text-fg-muted hover:text-fg">Docs</a>
                <a href="{{ route('ui.index') }}" class="text-fg-muted hover:text-fg">Kitchen sink</a>
                <x-docs.theme-switcher />
                <x-docs.dark-mode-toggle />
            </nav>
        </div>
    </header>

    <main id="main-content" class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        <p class="text-sm font-medium text-brand">{{ config('ui-docs.name') }}</p>
        <h1 class="mt-3 max-w-3xl text-4xl font-semibold tracking-tight text-fg sm:text-5xl">
            Copy-paste Blade components for Laravel
        </h1>
        <p class="mt-4 max-w-2xl text-lg text-fg-muted">
            Production-minded UI primitives built with Tailwind CSS 4 and Alpine.js 3.
            Architected with WCAG 2.2 AA patterns in mind.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('docs.index') }}" class="inline-flex rounded-control bg-brand px-4 py-2.5 text-sm font-medium text-on-brand">
                Read the docs
            </a>
            <a href="{{ route('docs.components.index') }}" class="inline-flex rounded-control border border-border px-4 py-2.5 text-sm font-medium text-fg">
                Browse components
            </a>
        </div>

        {{-- TODO: real product screenshots, metrics, and client proof when available --}}
        <p class="mt-12 text-sm text-fg-subtle">Marketing metrics and testimonials: TODO</p>

        <div class="mt-16">
            <x-docs.cta />
        </div>
    </main>

    <x-docs.footer />
</div>
@endsection
