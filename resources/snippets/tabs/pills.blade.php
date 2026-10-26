<x-ui.tabs variant="pills" active="pipeline">
    <x-slot:list>
        <x-ui.tabs.tab id="pipeline">Order pipeline</x-ui.tabs.tab>
        <x-ui.tabs.tab id="stock">Stock moves</x-ui.tabs.tab>
    </x-slot:list>

    <x-ui.tabs.panel id="pipeline">Open, packed, and shipped counts for today.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="stock">Inbound receipts and pick-list adjustments.</x-ui.tabs.panel>
</x-ui.tabs>
