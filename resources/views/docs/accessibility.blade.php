@extends('layouts.docs')

@section('title', 'Accessibility · '.config('ui-docs.name'))
@section('meta_description', 'Keyboard and ARIA patterns used across Praesepe UI components, plus what automated Axe and Playwright tests cover.')

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

    <h2 class="mt-10 text-xl font-semibold text-fg">Automated coverage (Axe + Playwright)</h2>
    <p class="mt-3 text-fg-muted">
        Playwright drives Chromium against the docs app. Commands live in <code class="rounded bg-surface-sunken px-1 text-sm">README.md</code> and <code class="rounded bg-surface-sunken px-1 text-sm">CONTRIBUTING.md</code> (<code class="rounded bg-surface-sunken px-1 text-sm">npm run test:e2e</code>).
    </p>
    <ul class="mt-3 list-disc space-y-2 pl-5 text-fg">
        <li>
            <strong>Axe scans</strong> (<code class="rounded bg-surface-sunken px-1 text-sm">tests/e2e/a11y.spec.ts</code>):
            <code class="rounded bg-surface-sunken px-1 text-sm">/</code>,
            <code class="rounded bg-surface-sunken px-1 text-sm">/ui</code>,
            <code class="rounded bg-surface-sunken px-1 text-sm">/docs</code>,
            and every
            <code class="rounded bg-surface-sunken px-1 text-sm">/docs/components/{slug}</code>
            route in Light and Dark for themes
            <code class="rounded bg-surface-sunken px-1 text-sm">praesepe</code>,
            <code class="rounded bg-surface-sunken px-1 text-sm">minimal</code>, and
            <code class="rounded bg-surface-sunken px-1 text-sm">warm</code>.
            The suite fails on any Axe finding with impact
            <code class="rounded bg-surface-sunken px-1 text-sm">critical</code> or
            <code class="rounded bg-surface-sunken px-1 text-sm">serious</code>
            under WCAG 2.2 AA tags (including color contrast and target size).
        </li>
        <li>
            <strong>Keyboard interaction specs</strong> (<code class="rounded bg-surface-sunken px-1 text-sm">tests/e2e/interactions.spec.ts</code>):
            Modal Escape, focus trap, and focus return;
            Dropdown ArrowDown / ArrowUp / Home / End / Escape;
            Tabs ArrowRight / ArrowLeft;
            command palette Search via Cmd+K (Ctrl+K) and
            <code class="rounded bg-surface-sunken px-1 text-sm">/</code>.
        </li>
    </ul>
    <p class="mt-3 text-fg-muted">
        Automated checks catch many markup, contrast, and keyboard regressions. They do not prove full WCAG conformance for every composition or assistive technology.
    </p>

    <h2 class="mt-10 text-xl font-semibold text-fg">Manual screen reader checks</h2>
    <p class="mt-3 text-fg-muted">
        Still verify with a real screen reader and keyboard on representative flows. Automated Axe and Playwright do not replace:
    </p>
    <ul class="mt-3 list-disc space-y-2 pl-5 text-fg">
        <li>VoiceOver (macOS / iOS), NVDA or JAWS (Windows), and TalkBack (Android) announcements for name, role, and state</li>
        <li>Live region behavior for toasts and async search results</li>
        <li>Focus order across composed app shells (navbar + sidebar + page content)</li>
        <li>Dynamic content such as filtered tables, bulk selection summaries, and truncated avatar groups</li>
        <li>Content you paste into your product (labels, errors, and empty states you author)</li>
    </ul>

    <h2 class="mt-10 text-xl font-semibold text-fg">Honest claims</h2>
    <p class="mt-3 text-fg-muted">
        Do not claim that the library is 100% WCAG compliant or fully accessible. Accessibility depends on how components are composed in your product. Test with keyboard, screen readers, and your content.
    </p>
</article>
@endsection
