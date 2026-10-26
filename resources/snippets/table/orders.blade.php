<x-ui.table striped hoverable sticky-header label="Daftar pesanan">
    <x-ui.table.head>
        <x-ui.table.cell header>Invoice</x-ui.table.cell>
        <x-ui.table.cell header>Customer</x-ui.table.cell>
        <x-ui.table.cell header>Status</x-ui.table.cell>
        <x-ui.table.cell header sortable sort="descending" numeric>Total</x-ui.table.cell>
    </x-ui.table.head>
    <x-ui.table.body>
        <x-ui.table.row>
            <x-ui.table.cell numeric>INV-2026-089</x-ui.table.cell>
            <x-ui.table.cell>Toko Maju Jaya</x-ui.table.cell>
            <x-ui.table.cell><x-ui.badge color="success" size="sm">Paid</x-ui.badge></x-ui.table.cell>
            <x-ui.table.cell numeric>Rp 2.450.000</x-ui.table.cell>
        </x-ui.table.row>
        <x-ui.table.row>
            <x-ui.table.cell numeric>INV-2026-090</x-ui.table.cell>
            <x-ui.table.cell>CV Nusantara</x-ui.table.cell>
            <x-ui.table.cell><x-ui.badge color="warning" size="sm">Pending</x-ui.badge></x-ui.table.cell>
            <x-ui.table.cell numeric>USD 480.00</x-ui.table.cell>
        </x-ui.table.row>
        <x-ui.table.row>
            <x-ui.table.cell numeric>INV-2026-091</x-ui.table.cell>
            <x-ui.table.cell>Warung Sederhana</x-ui.table.cell>
            <x-ui.table.cell><x-ui.badge color="info" size="sm">Draft</x-ui.badge></x-ui.table.cell>
            <x-ui.table.cell numeric>Rp 125.000</x-ui.table.cell>
        </x-ui.table.row>
    </x-ui.table.body>
</x-ui.table>
