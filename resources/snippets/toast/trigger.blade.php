<div class="flex flex-wrap gap-3">
    <x-ui.button
        x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'success', title: 'Deployed', message: 'Production is live.', duration: 4000 } }))"
    >
        Show success toast
    </x-ui.button>
    <x-ui.button
        variant="outline"
        x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'info', title: 'Queued', message: 'Your export will be ready shortly.' } }))"
    >
        Show info toast
    </x-ui.button>
</div>
