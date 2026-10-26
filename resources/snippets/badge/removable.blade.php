<div x-data="{ show: true }">
    <span x-show="show" x-cloak>
        <x-ui.badge
            variant="soft"
            color="brand"
            removable
            x-on:click="show = false"
        >
            Cabang Bandung
        </x-ui.badge>
    </span>
</div>
