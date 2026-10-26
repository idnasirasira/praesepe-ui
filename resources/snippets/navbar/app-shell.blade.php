<x-ui.navbar brand-href="/">
    <x-slot:brand>Toko Kita</x-slot:brand>

    <x-slot:links>
        <x-ui.navbar.link href="#" current>Dashboard</x-ui.navbar.link>
        <x-ui.navbar.link href="#">Pesanan</x-ui.navbar.link>
        <x-ui.navbar.link href="#">Pelanggan</x-ui.navbar.link>
    </x-slot:links>

    <x-slot:actions>
        <x-ui.button variant="outline" size="sm">Akun</x-ui.button>
    </x-slot:actions>
</x-ui.navbar>
