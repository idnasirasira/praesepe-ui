<x-ui.accordion type="multiple" :default="['webhooks', 'limits']">
    <x-ui.accordion.item id="webhooks" title="Order webhooks">
        Subscribe to order.paid, order.packed, and invoice.voided events.
    </x-ui.accordion.item>
    <x-ui.accordion.item id="limits" title="API rate limits">
        Standard workspaces share 60 requests per minute per API key.
    </x-ui.accordion.item>
    <x-ui.accordion.item id="tokens" title="Staff access tokens">
        Generate personal access tokens from Settings → Integrations.
    </x-ui.accordion.item>
</x-ui.accordion>
