<x-ui.accordion type="multiple" :default="['api', 'webhooks']">
    <x-ui.accordion.item id="api" title="API access">
        Generate personal access tokens from Settings.
    </x-ui.accordion.item>
    <x-ui.accordion.item id="webhooks" title="Webhooks">
        Subscribe to deploy and billing events.
    </x-ui.accordion.item>
    <x-ui.accordion.item id="limits" title="Rate limits">
        Free workspaces share a 60 request per minute budget.
    </x-ui.accordion.item>
</x-ui.accordion>
