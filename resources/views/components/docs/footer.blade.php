<footer class="border-t border-border px-4 py-8 sm:px-6 lg:px-10">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-docs.logo />
            <p class="mt-2 inline-flex items-center gap-1.5 text-sm text-fg-muted">
                Open-source Blade components by
                <a
                    href="{{ config('ui-docs.praesepe_url') }}"
                    class="inline-flex items-center gap-1.5 font-medium text-fg underline decoration-border underline-offset-2 hover:text-brand"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    <x-icons.praesepe class="size-3.5 shrink-0" />
                    Praesepe
                </a>.
            </p>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-fg-muted">
            <a href="{{ route('docs.index') }}" class="hover:text-fg">Docs</a>
            <a href="{{ route('ui.index') }}" class="hover:text-fg">Kitchen sink</a>
            <a href="{{ config('ui-docs.github_url') }}" class="hover:text-fg" rel="noopener noreferrer" target="_blank">GitHub</a>
            <a href="{{ config('ui-docs.whatsapp_url') }}" class="hover:text-fg" rel="noopener noreferrer" target="_blank">WhatsApp</a>
        </div>
    </div>
    <p class="mt-6 text-xs text-fg-subtle">MIT License. Version {{ config('ui-docs.version') }}.</p>
</footer>
