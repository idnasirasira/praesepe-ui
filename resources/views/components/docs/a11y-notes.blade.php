@props([
    'notes' => [],
])

@if (count($notes) > 0)
    <section class="rounded-card border border-border bg-surface-raised p-4 shadow-2xs">
        <h2 class="text-base font-semibold tracking-tight text-fg">Accessibility notes</h2>
        <p class="mt-1.5 text-sm text-fg-muted leading-relaxed text-pretty">
            Architected with WCAG 2.2 AA patterns in mind. These notes document the exact keyboard and ARIA behavior for this component.
        </p>
        <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-fg leading-relaxed">
            @foreach ($notes as $note)
                <li>{{ $note }}</li>
            @endforeach
        </ul>
    </section>
@endif
