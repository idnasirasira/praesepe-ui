<x-ui.table striped hoverable label="Daftar pesanan">
    <x-ui.table.head>
        <x-ui.table.cell header>No. pesanan</x-ui.table.cell>
        <x-ui.table.cell header>Pelanggan</x-ui.table.cell>
        <x-ui.table.cell header>Status</x-ui.table.cell>
        <x-ui.table.cell header sortable sort="descending">Total</x-ui.table.cell>
    </x-ui.table.head>
    <x-ui.table.body>
        <x-ui.table.row>
            <x-ui.table.cell>ORD-2201</x-ui.table.cell>
            <x-ui.table.cell>Toko Maju Jaya</x-ui.table.cell>
            <x-ui.table.cell><x-ui.badge color="success" size="sm">Dikirim</x-ui.badge></x-ui.table.cell>
            <x-ui.table.cell>Rp 2.450.000</x-ui.table.cell>
        </x-ui.table.row>
        <x-ui.table.row>
            <x-ui.table.cell>ORD-2202</x-ui.table.cell>
            <x-ui.table.cell>CV Nusantara</x-ui.table.cell>
            <x-ui.table.cell><x-ui.badge color="warning" size="sm">Diproses</x-ui.badge></x-ui.table.cell>
            <x-ui.table.cell>Rp 780.000</x-ui.table.cell>
        </x-ui.table.row>
        <x-ui.table.row>
            <x-ui.table.cell>ORD-2203</x-ui.table.cell>
            <x-ui.table.cell>Warung Sederhana</x-ui.table.cell>
            <x-ui.table.cell><x-ui.badge color="info" size="sm">Baru</x-ui.badge></x-ui.table.cell>
            <x-ui.table.cell>Rp 125.000</x-ui.table.cell>
        </x-ui.table.row>
    </x-ui.table.body>
</x-ui.table>
