<x-ui.sidebar label="Operasional">
    <x-slot:brand>Operasional</x-slot:brand>

    <x-ui.sidebar.section title="Penjualan">
        <x-ui.sidebar.item href="#" current label="Pesanan">
            <x-slot:icon><x-icons.search class="size-4" /></x-slot:icon>
            Pesanan
        </x-ui.sidebar.item>
        <x-ui.sidebar.item href="#" label="Faktur">
            <x-slot:icon><x-icons.copy class="size-4" /></x-slot:icon>
            Faktur
        </x-ui.sidebar.item>
    </x-ui.sidebar.section>

    <x-ui.sidebar.section title="Inventori">
        <x-ui.sidebar.item href="#" label="Stok gudang">
            <x-slot:icon><x-icons.menu class="size-4" /></x-slot:icon>
            Stok gudang
        </x-ui.sidebar.item>
    </x-ui.sidebar.section>
</x-ui.sidebar>
