@props([
    'title' => 'Need a custom Laravel product?',
    'body' => 'Praesepe builds production software for SMEs. Use Praesepe UI in your apps, then hire the studio when you need a full system.',
])

<section class="rounded-card border border-border bg-surface-sunken p-6">
    <h2 class="text-lg font-semibold text-fg">{{ $title }}</h2>
    <p class="mt-2 max-w-2xl text-sm text-fg-muted">{{ $body }}</p>
    <div class="mt-4 flex flex-wrap gap-3">
        <a
            href="{{ config('ui-docs.praesepe_url') }}"
            class="inline-flex items-center rounded-control bg-brand px-4 py-2 text-sm font-medium text-on-brand"
            rel="noopener noreferrer"
            target="_blank"
        >
            Visit Praesepe
        </a>
        @if (config('ui-docs.email'))
            <a
                href="mailto:{{ config('ui-docs.email') }}"
                class="inline-flex items-center rounded-control border border-border px-4 py-2 text-sm font-medium text-fg"
            >
                Email the studio
            </a>
        @else
            {{-- TODO: email contact once published --}}
            <span class="inline-flex items-center rounded-control border border-dashed border-border px-4 py-2 text-sm text-fg-subtle">
                Contact email: TODO
            </span>
        @endif
    </div>
</section>
