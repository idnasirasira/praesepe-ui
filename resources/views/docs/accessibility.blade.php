@extends('layouts.docs')

@section('title', 'Accessibility · '.config('ui-docs.name'))
@section('meta_description', 'Keyboard and ARIA patterns used across Praesepe UI components.')

@section('content')
<article class="max-w-3xl">
    <h1 class="text-3xl font-semibold tracking-tight text-fg">Accessibility</h1>
    <p class="mt-3 text-fg-muted">
        Praesepe UI is architected with WCAG 2.2 AA patterns in mind. This page describes the shared conventions. Each component documents its own keyboard and ARIA behavior.
    </p>

    <h2 class="mt-10 text-xl font-semibold text-fg">Shared conventions</h2>
    <ul class="mt-3 list-disc space-y-2 pl-5 text-fg">
        <li>Visible <code class="rounded bg-surface-sunken px-1 text-sm">:focus-visible</code> outlines using <code class="rounded bg-surface-sunken px-1 text-sm">--ui-ring</code></li>
        <li>Skip-to-content link on documentation layouts</li>
        <li>Decorative icons use <code class="rounded bg-surface-sunken px-1 text-sm">aria-hidden="true"</code></li>
        <li>Interactive overlays teleport to <code class="rounded bg-surface-sunken px-1 text-sm">body</code>, trap focus, and restore focus on close</li>
        <li>Form controls wire <code class="rounded bg-surface-sunken px-1 text-sm">label</code>, <code class="rounded bg-surface-sunken px-1 text-sm">aria-describedby</code>, and <code class="rounded bg-surface-sunken px-1 text-sm">aria-invalid</code></li>
        <li><code class="rounded bg-surface-sunken px-1 text-sm">prefers-reduced-motion</code> disables non-essential transitions</li>
    </ul>

    <h2 class="mt-10 text-xl font-semibold text-fg">Honest claims</h2>
    <p class="mt-3 text-fg-muted">
        Do not claim that the library is 100% WCAG compliant or fully accessible. Accessibility depends on how components are composed in your product. Test with keyboard, screen readers, and your content.
    </p>
</article>
@endsection
