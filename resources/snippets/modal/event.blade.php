<div class="flex flex-wrap items-center gap-3">
    <x-ui.button
        variant="outline"
        x-on:click="window.dispatchEvent(new CustomEvent('ui-modal-open', { detail: { id: 'demo-event' } }))"
    >
        Open via event
    </x-ui.button>

    <x-ui.modal
        id="demo-event"
        title="Approval queue"
        description="Open INV-2026-089 from the finance toolbar without nesting the trigger."
    >
        <p>Listen for the ui-modal-open window event and match detail.id.</p>
    </x-ui.modal>
</div>
