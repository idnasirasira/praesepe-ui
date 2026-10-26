@extends('layouts.docs')

@section('title', 'Theming · '.config('ui-docs.name'))
@section('meta_description', 'Semantic CSS tokens, themes, and runtime dark mode for Praesepe UI.')

@section('content')
<article class="max-w-3xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Theming</h1>
    <p class="mt-3 text-fg-muted">
        Components use semantic utilities such as <code class="rounded bg-surface-sunken px-1 text-sm">bg-brand</code> and <code class="rounded bg-surface-sunken px-1 text-sm">text-fg</code>. Themes and dark mode swap CSS variables at runtime without scattering <code class="rounded bg-surface-sunken px-1 text-sm">dark:</code> classes through every component.
    </p>

    <h2 class="mt-10 text-xl font-semibold text-fg">Built-in themes</h2>
    <ul class="mt-3 list-disc space-y-2 pl-5 text-fg">
        <li><strong>praesepe</strong>: indigo brand with cool slate neutrals</li>
        <li><strong>minimal</strong>: sharp monochrome surfaces</li>
        <li><strong>warm</strong>: teal brand on soft stone and sand neutrals</li>
    </ul>

    <h2 class="mt-10 text-xl font-semibold text-fg">Build your own theme</h2>
    <p class="mt-3 text-fg-muted">
        On the themes gallery, mix brand hue, chroma, and lightness in OKLCH, preview components live, save the result as
        <strong class="font-medium text-fg">My theme</strong> in the header switcher, and copy a CSS snippet into your app.
    </p>

    <h2 class="mt-10 text-xl font-semibold text-fg">Color scheme</h2>
    <p class="mt-3 text-fg-muted">
        Persist <code class="rounded bg-surface-sunken px-1 text-sm">theme</code> and <code class="rounded bg-surface-sunken px-1 text-sm">colorScheme</code> (<code class="rounded bg-surface-sunken px-1 text-sm">light</code>, <code class="rounded bg-surface-sunken px-1 text-sm">dark</code>, or <code class="rounded bg-surface-sunken px-1 text-sm">system</code>) in localStorage. Inline a FOUC-prevention script in <code class="rounded bg-surface-sunken px-1 text-sm">&lt;head&gt;</code> before CSS loads.
    </p>

    <p class="mt-6">
        <a href="{{ route('themes.index') }}" class="text-brand underline underline-offset-2">Open the themes gallery</a>
    </p>
</article>
@endsection
