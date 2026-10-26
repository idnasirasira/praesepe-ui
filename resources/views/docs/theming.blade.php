@extends('layouts.docs')

@section('title', 'Theming · '.config('ui-docs.name'))
@section('meta_description', 'Semantic CSS tokens, themes, and runtime dark mode for Praesepe UI.')

@section('content')
<x-docs.article>
    <h1>Theming</h1>
    <p>
        Components use semantic utilities such as <code class="rounded bg-surface-sunken px-1 text-sm">bg-brand</code> and <code class="rounded bg-surface-sunken px-1 text-sm">text-fg</code>. Themes and dark mode swap CSS variables at runtime without scattering <code class="rounded bg-surface-sunken px-1 text-sm">dark:</code> classes through every component.
    </p>

    <h2>Built-in themes</h2>
    <ul>
        <li><strong class="font-semibold text-fg">praesepe</strong>: indigo brand with cool slate neutrals</li>
        <li><strong class="font-semibold text-fg">minimal</strong>: sharp monochrome surfaces</li>
        <li><strong class="font-semibold text-fg">warm</strong>: teal brand on soft stone and sand neutrals</li>
    </ul>

    <h2>Build your own theme</h2>
    <p>
        On the themes gallery, mix brand hue, chroma, and lightness in OKLCH, preview components live, save the result as
        <strong class="font-medium text-fg">My theme</strong> in the header switcher, and copy a CSS snippet into your app.
    </p>

    <h2>Color scheme</h2>
    <p>
        Persist <code class="rounded bg-surface-sunken px-1 text-sm">theme</code> and <code class="rounded bg-surface-sunken px-1 text-sm">colorScheme</code> (<code class="rounded bg-surface-sunken px-1 text-sm">light</code>, <code class="rounded bg-surface-sunken px-1 text-sm">dark</code>, or <code class="rounded bg-surface-sunken px-1 text-sm">system</code>) in localStorage. Inline a FOUC-prevention script in <code class="rounded bg-surface-sunken px-1 text-sm">&lt;head&gt;</code> before CSS loads.
    </p>

    <p>
        <a href="{{ route('themes.index') }}" class="text-brand underline underline-offset-2">Open the themes gallery</a>
    </p>
</x-docs.article>
@endsection
