@extends('layouts.docs')

@section('title', $page->name.' · '.config('ui-docs.name'))
@section('meta_description', $page->description)

@section('content')
<article class="mx-auto max-w-4xl">
    <p class="text-sm font-medium uppercase tracking-wide text-fg-subtle">{{ $page->category }}</p>
    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-fg">{{ $page->name }}</h1>
    <p class="mt-3 text-fg-muted">{{ $page->description }}</p>

    <div class="mt-10 space-y-10">
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
        <div>
            <h2 class="mb-3 text-xl font-semibold text-fg">Props</h2>
            <x-docs.props-table :props="$page->props" />
        </div>

        <x-docs.a11y-notes :notes="$page->a11yNotes" />
        <x-docs.cta />
    </div>
</article>
@endsection
