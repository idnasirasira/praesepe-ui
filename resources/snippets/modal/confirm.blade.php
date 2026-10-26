<x-ui.modal
    id="demo-confirm"
    variant="confirm"
    title="Approve payout?"
    description="Release Rp 18.750.000 to CV Nusantara for PO-8841. This cannot be undone."
>
    <x-slot:trigger>
        <x-ui.button variant="danger">Approve payout</x-ui.button>
    </x-slot:trigger>

    <x-slot:action>
        <x-ui.button variant="danger" x-on:click="hide()">Approve</x-ui.button>
    </x-slot:action>
</x-ui.modal>
