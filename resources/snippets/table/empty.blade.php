<x-ui.table label="Hasil pencarian kosong">
    <x-ui.table.head>
        <x-ui.table.cell header>Produk</x-ui.table.cell>
        <x-ui.table.cell header>Stok</x-ui.table.cell>
    </x-ui.table.head>
    <x-ui.table.body>
        <x-ui.table.empty
            title="Tidak ada produk"
            description="Coba ubah filter gudang atau kata kunci."
        >
            <x-slot:action>
                <x-ui.button size="sm">Tambah produk</x-ui.button>
            </x-slot:action>
        </x-ui.table.empty>
    </x-ui.table.body>
</x-ui.table>
