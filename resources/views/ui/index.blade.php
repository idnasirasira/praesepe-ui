@extends('layouts.docs')

@section('title', 'Kitchen sink · '.config('ui-docs.name'))
@section('meta_description', 'Live playground of every registered Praesepe UI component.')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Kitchen sink</h1>
    <p class="mt-3 text-fg-muted">
        Dogfood every registered component in one place. Use the theme switcher and dark mode toggle in the header.
    </p>

    @forelse ($components as $component)
        <section class="mt-12 border-t border-border pt-10">
            <div class="flex items-baseline justify-between gap-3">
                <h2 class="text-2xl font-semibold text-fg">{{ $component->name }}</h2>
                <a href="{{ route('docs.components.show', $component->slug) }}" class="text-sm text-brand underline underline-offset-2">Docs</a>
            </div>
            <p class="mt-2 text-sm text-fg-muted">{{ $component->description }}</p>
            <div class="mt-6 space-y-8">
                @foreach (app(\App\Docs\ComponentRegistry::class)->examplesFor($component) as $example)
                    <div class="rounded-card border border-border bg-surface-raised p-6">
                        <h3 class="text-sm font-semibold text-fg">{{ $example['title'] }}</h3>
                        <div class="mt-4">
                            {!! $example['preview'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @empty
        <p class="mt-8 rounded-card border border-dashed border-border p-6 text-sm text-fg-muted">
            No components registered yet.
        </p>
    @endforelse
</div>
@endsection
