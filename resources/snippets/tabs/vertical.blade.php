<x-ui.tabs variant="vertical" active="general">
    <x-slot:list>
        <x-ui.tabs.tab id="general">Store defaults</x-ui.tabs.tab>
        <x-ui.tabs.tab id="security">Access & 2FA</x-ui.tabs.tab>
    </x-slot:list>

    <x-ui.tabs.panel id="general">Currency IDR, timezone Asia/Jakarta, and receipt footer.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="security">Owner passkeys and staff session timeout policies.</x-ui.tabs.panel>
</x-ui.tabs>
