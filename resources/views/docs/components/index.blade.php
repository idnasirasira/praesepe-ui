@extends('layouts.docs')

@section('title', 'Components · '.config('ui-docs.name'))
@section('meta_description', 'Browse Praesepe UI Blade components.')

@section('content')
<x-docs.article>
    <h1>Components</h1>
    <p>
        Golden archetypes ship first. More components will follow the same registry, snippet, and a11y documentation pattern.
    </p>

    @if (count($components) === 0)
        <div class="mt-8 rounded-card border border-dashed border-border p-6 text-sm text-fg-muted leading-relaxed">
            No components registered yet. Stage 1 golden archetypes land next.
        </div>
    @else
        <div class="mt-8 overflow-hidden rounded-card border border-border">
            <ul class="divide-y divide-border">
                @foreach ($components as $component)
                    <li>
                        <a href="{{ route('docs.components.show', $component->slug) }}" class="block px-4 py-4 hover:bg-surface-sunken">
                            <div class="font-medium tracking-tight text-fg">{{ $component->name }}</div>
                            <div class="mt-1 text-sm text-fg-muted leading-relaxed text-pretty">{{ $component->description }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</x-docs.article>
@endsection
