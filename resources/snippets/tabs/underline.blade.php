<x-ui.tabs variant="underline" active="profile">
    <x-slot:list>
        <x-ui.tabs.tab id="profile">Store profile</x-ui.tabs.tab>
        <x-ui.tabs.tab id="tax">Tax & e-Faktur</x-ui.tabs.tab>
        <x-ui.tabs.tab id="team" disabled>Team roles</x-ui.tabs.tab>
    </x-slot:list>

    <x-ui.tabs.panel id="profile">Legal name, NPWP, and storefront contact for Toko Maju.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="tax">PPN rates, invoice numbering, and e-Faktur API credentials.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="team">Invite cashiers and warehouse leads once billing is active.</x-ui.tabs.panel>
</x-ui.tabs>
