<x-ui.tabs variant="underline" active="account">
    <x-slot:list>
        <x-ui.tabs.tab id="account">Account</x-ui.tabs.tab>
        <x-ui.tabs.tab id="billing">Billing</x-ui.tabs.tab>
        <x-ui.tabs.tab id="team" disabled>Team</x-ui.tabs.tab>
    </x-slot:list>

    <x-ui.tabs.panel id="account">Manage your profile and sign-in methods.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="billing">Invoices, payment methods, and plan changes.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="team">Invite teammates once this plan is upgraded.</x-ui.tabs.panel>
</x-ui.tabs>
