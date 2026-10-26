@props([
    'title' => 'Need custom software, internal tools, or ERP workflows for your SME?',
    'body' => 'Praesepe builds production Laravel systems for Indonesian SMEs. Use Praesepe UI in your apps, then hire the studio when you need inventory, invoicing, or ops workflows.',
])

@php
    $whatsapp = config('ui-docs.whatsapp_url');
    $email = config('ui-docs.email');
@endphp

<section {{ $attributes->class(['rounded-card border border-border bg-surface-sunken p-6 sm:p-8']) }}>
    <h2 class="text-xl font-semibold tracking-tight text-fg sm:text-2xl">{{ $title }}</h2>
    <p class="mt-3 max-w-2xl text-sm text-fg-muted sm:text-base">{{ $body }}</p>
    <div class="mt-6 flex flex-wrap gap-3">
        @if ($whatsapp)
            <x-ui.button :href="$whatsapp" target="_blank" rel="noopener noreferrer">
                Chat on WhatsApp
            </x-ui.button>
        @else
            <span class="inline-flex items-center rounded-control border border-dashed border-border px-4 py-2 text-sm text-fg-subtle">
                WhatsApp: TODO
            </span>
        @endif

        @if ($email)
            <x-ui.button variant="outline" :href="'mailto:'.$email">
                Email the studio
            </x-ui.button>
        @else
            <span class="inline-flex items-center rounded-control border border-dashed border-border px-4 py-2 text-sm text-fg-subtle">
                Contact email: TODO
            </span>
        @endif

        <x-ui.button variant="ghost" :href="config('ui-docs.praesepe_url')" target="_blank" rel="noopener noreferrer">
            Visit Praesepe
        </x-ui.button>
    </div>
</section>
