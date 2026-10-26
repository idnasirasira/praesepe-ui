<fieldset class="grid max-w-xl gap-3 sm:grid-cols-2">
    <legend class="mb-1 text-sm font-medium text-fg">Deployment region</legend>
    <x-ui.radio
        variant="card"
        name="region"
        value="sg"
        label="Singapore"
        description="Lowest latency for SEA users."
        checked
    />
    <x-ui.radio
        variant="card"
        name="region"
        value="eu"
        label="Frankfurt"
        description="EU data residency friendly."
    />
</fieldset>
