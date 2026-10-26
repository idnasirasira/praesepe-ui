@extends('layouts.docs')

@section('title', 'Components · '.config('ui-docs.name'))
@section('meta_description', 'Browse Praesepe UI Blade components.')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Components</h1>
    <p class="mt-3 text-fg-muted">
        Golden archetypes ship first. More components will follow the same registry, snippet, and a11y documentation pattern.
    </p>

    @if (count($components) === 0)
        <p class="mt-8 rounded-card border border-dashed border-border p-6 text-sm text-fg-muted">
            No components registered yet. Stage 1 golden archetypes land next.
        </p>
    @else
        <ul class="mt-8 divide-y divide-border rounded-card border border-border">
            @foreach ($components as $component)
                <li>
                    <a href="{{ route('docs.components.show', $component->slug) }}" class="block px-4 py-4 hover:bg-surface-sunken">
                        <div class="font-medium text-fg">{{ $component->name }}</div>
                        <div class="mt-1 text-sm text-fg-muted">{{ $component->description }}</div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
