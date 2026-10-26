<div class="space-y-4">
    <div class="flex flex-wrap gap-3">
        <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'info', title: 'Sync queued', message: 'Stock levels for Gudang A will refresh in ~30s.' } }))">Info</x-ui.button>
        <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'success', title: 'Invoice sent', message: 'INV-2026-089 emailed to finance@tokomaju.id.' } }))">Success</x-ui.button>
        <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'warning', title: 'Low stock', message: 'SKU-2048 has 8 units left in Gudang B.' } }))">Warning</x-ui.button>
        <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'danger', title: 'Payment failed', message: 'Midtrans declined the Rp 2.450.000 charge.' } }))">Danger</x-ui.button>
    </div>

    <div class="grid gap-3 sm:grid-cols-2">
        <div class="relative overflow-hidden rounded-card border border-border border-l-4 border-l-info bg-surface-raised p-4 shadow-lg ring-1 ring-border/60" role="status">
            <div class="flex items-start gap-3">
                <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-pill bg-info-soft text-xs font-bold tabular-nums text-info" aria-hidden="true">i</span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold tracking-tight text-fg">Sync queued</p>
                    <p class="mt-1 text-sm text-fg-muted leading-relaxed">Stock levels for Gudang A will refresh in ~30s.</p>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-card border border-border border-l-4 border-l-success bg-surface-raised p-4 shadow-lg ring-1 ring-border/60" role="status">
            <div class="flex items-start gap-3">
                <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-pill bg-success-soft text-xs font-bold tabular-nums text-success" aria-hidden="true">✓</span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold tracking-tight text-fg">Invoice sent</p>
                    <p class="mt-1 text-sm text-fg-muted leading-relaxed">INV-2026-089 emailed to finance@tokomaju.id.</p>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-card border border-border border-l-4 border-l-warning bg-surface-raised p-4 shadow-lg ring-1 ring-border/60" role="status">
            <div class="flex items-start gap-3">
                <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-pill bg-warning-soft text-xs font-bold tabular-nums text-warning" aria-hidden="true">!</span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold tracking-tight text-fg">Low stock</p>
                    <p class="mt-1 text-sm text-fg-muted leading-relaxed">SKU-2048 has 8 units left in Gudang B.</p>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-card border border-border border-l-4 border-l-danger bg-surface-raised p-4 shadow-lg ring-1 ring-border/60" role="alert">
            <div class="flex items-start gap-3">
                <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-pill bg-danger-soft text-xs font-bold tabular-nums text-danger" aria-hidden="true">!</span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold tracking-tight text-fg">Payment failed</p>
                    <p class="mt-1 text-sm text-fg-muted leading-relaxed">Midtrans declined the Rp 2.450.000 charge.</p>
                </div>
            </div>
        </div>
    </div>
</div>
