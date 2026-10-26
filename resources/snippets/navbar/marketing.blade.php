<x-ui.navbar brand-href="/" brand-name="Praesepe" mobile-style="floating" :sticky="true">
    <x-slot:links>
        <x-ui.navbar.link href="#product">Product</x-ui.navbar.link>
        <x-ui.navbar.link href="#pricing">Pricing</x-ui.navbar.link>
        <x-ui.navbar.link href="#docs" current>Docs</x-ui.navbar.link>
    </x-slot:links>

    <x-slot:actions>
        <x-ui.button variant="ghost" size="sm" href="#">Sign in</x-ui.button>
        <x-ui.button size="sm" href="#">Start free</x-ui.button>
    </x-slot:actions>

    <x-slot:mobileFooter>
        <div class="flex flex-col gap-2">
            <x-ui.button variant="ghost" size="sm" class="w-full justify-center" href="#">Sign in</x-ui.button>
            <x-ui.button size="sm" class="w-full justify-center" href="#">Start free</x-ui.button>
        </div>
    </x-slot:mobileFooter>
</x-ui.navbar>
