<x-ui.modal
    id="demo-confirm"
    variant="confirm"
    title="Delete project?"
    description="This action cannot be undone."
>
    <x-slot:trigger>
        <x-ui.button variant="danger">Delete project</x-ui.button>
    </x-slot:trigger>

    <x-slot:action>
        <x-ui.button variant="danger" x-on:click="hide()">Delete</x-ui.button>
    </x-slot:action>
</x-ui.modal>
