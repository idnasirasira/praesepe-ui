<div class="space-y-8">
    <x-ui.navbar brand-href="/" brand-name="Toko Kita">
        <x-slot:links>
            <x-ui.navbar.link href="#" current>Dashboard</x-ui.navbar.link>
            <x-ui.navbar.link href="#">Pesanan</x-ui.navbar.link>
            <x-ui.navbar.link href="#">Pelanggan</x-ui.navbar.link>
        </x-slot:links>

        <x-slot:actions>
            <x-ui.button variant="outline" size="sm">Akun</x-ui.button>
        </x-slot:actions>
    </x-ui.navbar>

    <x-ui.navbar brand-href="/" brand-name="Toko Kita" mobile-style="floating">
        <x-slot:links>
            <x-ui.navbar.link href="#" current>Dashboard</x-ui.navbar.link>
            <x-ui.navbar.link href="#">Stok</x-ui.navbar.link>
        </x-slot:links>

        <x-slot:actions>
            <x-ui.button size="sm">New PO</x-ui.button>
        </x-slot:actions>
    </x-ui.navbar>
</div>
