<div class="flex flex-wrap gap-3">
    <x-ui.button
        x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'success', title: 'Payout approved', message: 'Rp 18.750.000 released to CV Nusantara.', duration: 4000 } }))"
    >
        Show success toast
    </x-ui.button>
    <x-ui.button
        variant="outline"
        x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'info', title: 'Export queued', message: 'Orders CSV for Oct 2026 will be ready shortly.' } }))"
    >
        Show info toast
    </x-ui.button>
</div>
