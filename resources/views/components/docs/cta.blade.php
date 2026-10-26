@props([
    'title' => 'Architecture & custom software partner',
    'body' => 'Praesepe uses these exact UI primitives to ship SME dashboards, inventory systems, invoicing desks, and internal tools faster, without rebuilding a design system for every client.',
])

@php
    $whatsapp = config('ui-docs.whatsapp_url');
    $email = config('ui-docs.email');
@endphp

<section {{ $attributes->class(['overflow-hidden rounded-card border border-border bg-surface-raised shadow-sm ring-1 ring-black/5']) }}>
    <div class="grid gap-0 lg:grid-cols-[1.4fr_1fr]">
        <div class="border-b border-border p-6 sm:p-8 lg:border-r lg:border-b-0">
            <p class="text-xs font-semibold uppercase tracking-wider text-brand">Built by Praesepe</p>
            <h2 class="mt-3 text-xl font-semibold tracking-tight text-balance text-fg sm:text-2xl">{{ $title }}</h2>
            <p class="mt-3 max-w-2xl text-sm text-fg-muted leading-relaxed text-pretty sm:text-base">{{ $body }}</p>

            <ul class="mt-6 space-y-2 text-sm text-fg">
                <li class="flex gap-2">
                    <span class="mt-1 size-1.5 shrink-0 rounded-full bg-brand" aria-hidden="true"></span>
                    <span>Same Blade + Tailwind 4 + Alpine 3 stack you see in this docs site</span>
                </li>
                <li class="flex gap-2">
                    <span class="mt-1 size-1.5 shrink-0 rounded-full bg-brand" aria-hidden="true"></span>
                    <span>Opinionated for Indonesian SME ops: invoices, stock, roles, approvals</span>
                </li>
                <li class="flex gap-2">
                    <span class="mt-1 size-1.5 shrink-0 rounded-full bg-brand" aria-hidden="true"></span>
                    <span>Architected with WCAG 2.2 AA patterns in mind for keyboard and ARIA</span>
                </li>
            </ul>
        </div>

        <div class="flex flex-col justify-center gap-3 bg-surface-sunken/50 p-6 sm:p-8">
            <p class="text-sm font-medium text-fg">Talk to the studio</p>
            @if ($whatsapp)
                <x-ui.button class="w-full justify-center" :href="$whatsapp" target="_blank" rel="noopener noreferrer">
                    Chat on WhatsApp
                </x-ui.button>
            @else
                <span class="inline-flex h-9 items-center justify-center rounded-control border border-dashed border-border px-4 text-sm text-fg-subtle">
                    WhatsApp: TODO
                </span>
            @endif

            @if ($email)
                <x-ui.button class="w-full justify-center" variant="outline" :href="'mailto:'.$email">
                    Email the studio
                </x-ui.button>
            @else
                <span class="inline-flex h-9 items-center justify-center rounded-control border border-dashed border-border px-4 text-sm text-fg-subtle">
                    Contact email: TODO
                </span>
            @endif

            <x-ui.button class="w-full justify-center" variant="ghost" :href="config('ui-docs.praesepe_url')" target="_blank" rel="noopener noreferrer">
                Visit Praesepe
            </x-ui.button>
        </div>
    </div>
</section>
