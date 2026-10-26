<fieldset class="grid max-w-xl gap-3 sm:grid-cols-2">
    <legend class="mb-1 text-sm font-medium text-fg">Fulfillment warehouse</legend>
    <x-ui.radio
        variant="card"
        name="warehouse"
        value="jkt"
        label="Jakarta Pusat"
        description="Same-day for Jabodetabek orders."
        checked
    />
    <x-ui.radio
        variant="card"
        name="warehouse"
        value="sby"
        label="Surabaya Timur"
        description="East Java hub with cold-chain bay."
    />
</fieldset>
