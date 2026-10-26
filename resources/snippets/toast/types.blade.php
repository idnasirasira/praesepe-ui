<div class="flex flex-wrap gap-3">
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'info', title: 'Sync queued', message: 'Stock levels for Gudang A will refresh in ~30s.' } }))">Info</x-ui.button>
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'success', title: 'Invoice sent', message: 'INV-2026-089 emailed to finance@tokomaju.id.' } }))">Success</x-ui.button>
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'warning', title: 'Low stock', message: 'SKU-2048 has 8 units left in Gudang B.' } }))">Warning</x-ui.button>
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'danger', title: 'Payment failed', message: 'Midtrans declined the Rp 2.450.000 charge.' } }))">Danger</x-ui.button>
</div>
