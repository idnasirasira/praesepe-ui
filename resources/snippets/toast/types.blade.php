<div class="flex flex-wrap gap-3">
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'info', title: 'Info', message: 'Informational update.' } }))">Info</x-ui.button>
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'success', title: 'Success', message: 'Changes saved.' } }))">Success</x-ui.button>
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'warning', title: 'Warning', message: 'Quota is almost full.' } }))">Warning</x-ui.button>
    <x-ui.button variant="outline" size="sm" x-on:click="window.dispatchEvent(new CustomEvent('ui:toast', { detail: { type: 'danger', title: 'Error', message: 'Request failed.' } }))">Danger</x-ui.button>
</div>
