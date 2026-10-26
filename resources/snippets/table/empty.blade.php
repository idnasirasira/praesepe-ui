<x-ui.table label="Hasil pencarian kosong">
    <x-ui.table.head>
        <x-ui.table.cell header>SKU</x-ui.table.cell>
        <x-ui.table.cell header>Stock</x-ui.table.cell>
    </x-ui.table.head>
    <x-ui.table.body>
        <x-ui.table.empty
            title="No products match"
            description="Try Gudang A / Bandung or clear the SKU filter."
        >
            <x-slot:action>
                <x-ui.button size="sm">Add product</x-ui.button>
            </x-slot:action>
        </x-ui.table.empty>
    </x-ui.table.body>
</x-ui.table>
