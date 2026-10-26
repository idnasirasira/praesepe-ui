<x-ui.table selectable label="Faktur terpilih">
    <x-ui.table.head>
        <x-ui.table.cell header select-all />
        <x-ui.table.cell header>Faktur</x-ui.table.cell>
        <x-ui.table.cell header>Jatuh tempo</x-ui.table.cell>
    </x-ui.table.head>
    <x-ui.table.body>
        <x-ui.table.row id="INV-1">
            <x-ui.table.cell select-id="INV-1" />
            <x-ui.table.cell>INV-1</x-ui.table.cell>
            <x-ui.table.cell>28 Okt 2026</x-ui.table.cell>
        </x-ui.table.row>
        <x-ui.table.row id="INV-2">
            <x-ui.table.cell select-id="INV-2" />
            <x-ui.table.cell>INV-2</x-ui.table.cell>
            <x-ui.table.cell>02 Nov 2026</x-ui.table.cell>
        </x-ui.table.row>
    </x-ui.table.body>
</x-ui.table>
