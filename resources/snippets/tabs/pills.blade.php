<x-ui.tabs variant="pills" active="overview">
    <x-slot:list>
        <x-ui.tabs.tab id="overview">Overview</x-ui.tabs.tab>
        <x-ui.tabs.tab id="activity">Activity</x-ui.tabs.tab>
    </x-slot:list>

    <x-ui.tabs.panel id="overview">Project health and recent deploys.</x-ui.tabs.panel>
    <x-ui.tabs.panel id="activity">Audit log entries for this workspace.</x-ui.tabs.panel>
</x-ui.tabs>
