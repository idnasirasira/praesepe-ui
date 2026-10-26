<x-ui.tabs variant="vertical" active="general">
    <x-slot:list>
        <x-ui.tabs.tab id="general">General</x-ui.tabs.tab>
        <x-ui.tabs.tab id="security">Security</x-ui.tabs.tab>
    </x-slot:list>

    <x-ui.tabs.panel id="general">Workspace name and default locale.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="security">Session lifetime and SSO providers.</x-ui.tabs.panel>
</x-ui.tabs>
