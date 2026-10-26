@extends('layouts.docs')

@section('title', $page->name.' · '.config('ui-docs.name'))
@section('meta_description', $page->description)

@php
    $llmPrompt = implode("\n", array_filter([
        '# '.$page->name.' (Praesepe UI)',
        '',
        $page->description,
        '',
        'Category: '.$page->category,
        'Slug: '.$page->slug,
        '',
        '## Props API',
        ...collect($page->props)->map(static function (array $prop): string {
            $default = $prop['default'] ?? 'null';

            return '- `'.$prop['name'].'` ('.$prop['type'].', default: '.$default.'): '.$prop['description'];
        })->all(),
        '',
        '## Accessibility',
        ...collect($page->a11yNotes)->map(static fn (string $note): string => '- '.$note)->all(),
        '',
        '## Usage notes for Cursor / LLM',
        '- Prefer `<x-ui.'.$page->slug.'>` Blade components when available.',
        '- Use long-form Alpine directives (`x-on:click`, `x-bind:class`); never Blade-conflicting shorthand.',
        '- Map variants with complete static Tailwind class strings; never concatenate token names.',
        '- Keep control heights pixel-locked: sm=h-8, md=h-9, lg=h-10.',
    ]));

    $tocItems = [
        ['id' => 'overview', 'label' => 'Overview'],
        ['id' => 'examples', 'label' => 'Examples'],
        ['id' => 'props', 'label' => 'Props API'],
        ['id' => 'accessibility', 'label' => 'Accessibility'],
    ];
@endphp

@section('toc')
    <x-docs.toc :items="$tocItems" />
@endsection

@section('content')
<article class="mx-auto max-w-3xl">
    <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-fg-muted">
            <li><a href="{{ route('docs.index') }}" class="hover:text-fg">Docs</a></li>
            <li aria-hidden="true" class="text-fg-subtle">/</li>
            <li><a href="{{ route('docs.components.index') }}" class="hover:text-fg">Components</a></li>
            <li aria-hidden="true" class="text-fg-subtle">/</li>
            <li class="font-medium text-fg" aria-current="page">{{ $page->name }}</li>
        </ol>
    </nav>

    <div class="flex flex-wrap items-start justify-between gap-4" id="overview">
        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-wider text-fg-subtle">{{ $page->category }}</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-balance text-fg">{{ $page->name }}</h1>
            <p class="mt-3 text-fg-muted leading-relaxed text-pretty">{{ $page->description }}</p>
        </div>
        <x-docs.copy-button :code="$llmPrompt" label="Copy LLM prompt" />
    </div>

    <div class="mt-10 space-y-10" id="examples">
        <h2 class="sr-only">Examples</h2>
        @foreach ($examples as $example)
            <x-docs.preview
                :title="$example['title']"
                :description="$example['description']"
                :html="$example['html']"
                :blade="$example['blade']"
                :preview="$example['preview']"
            />
        @endforeach
    </div>

    <div class="mt-12 space-y-8">
        <div id="props">
            <h2 class="mb-3 text-xl font-semibold tracking-tight text-fg">Props API</h2>
            <x-docs.props-table :props="$page->props" />
        </div>

        <div id="accessibility">
            <x-docs.a11y-notes :notes="$page->a11yNotes" />
        </div>

        <x-docs.cta />
    </div>
</article>
@endsection
