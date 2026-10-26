@extends('layouts.docs')

@section('title', 'Kitchen sink · '.config('ui-docs.name'))
@section('meta_description', 'Live playground of every registered Praesepe UI component.')

@section('toc')
    <x-docs.toc :items="collect($components)->map(fn ($component) => ['id' => 'sink-'.$component->slug, 'label' => $component->name])->all()" />
@endsection

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Kitchen sink</h1>
    <p class="mt-3 text-fg-muted leading-relaxed text-pretty">
        Dogfood every registered component in one place. Use the theme switcher, dark mode toggle, and each preview canvas control.
    </p>

    @forelse ($components as $component)
        <section class="mt-12 border-t border-border pt-10" id="sink-{{ $component->slug }}">
            <div class="flex items-baseline justify-between gap-3">
                <h2 class="text-2xl font-semibold tracking-tight text-fg">{{ $component->name }}</h2>
                <a href="{{ route('docs.components.show', $component->slug) }}" class="text-sm text-brand underline underline-offset-2">Docs</a>
            </div>
            <p class="mt-2 text-sm text-fg-muted leading-relaxed">{{ $component->description }}</p>
            <div class="mt-6 space-y-8">
                @foreach (app(\App\Docs\ComponentRegistry::class)->examplesFor($component) as $example)
                    <x-docs.preview
                        :title="$example['title']"
                        :description="$example['description'] ?? null"
                        :html="$example['html']"
                        :blade="$example['blade']"
                        :preview="$example['preview']"
                    />
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
