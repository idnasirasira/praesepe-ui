<footer class="border-t border-border px-4 py-8 sm:px-6 lg:px-10">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-fg">{{ config('ui-docs.name') }}</p>
            <p class="mt-1 text-sm text-fg-muted">
                Open-source Blade components by
                <a href="{{ config('ui-docs.praesepe_url') }}" class="underline decoration-border underline-offset-2 hover:text-fg" rel="noopener noreferrer" target="_blank">Praesepe</a>.
            </p>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-fg-muted">
            <a href="{{ route('docs.index') }}" class="hover:text-fg">Docs</a>
            <a href="{{ route('ui.index') }}" class="hover:text-fg">Kitchen sink</a>
            @if (config('ui-docs.github_url'))
                <a href="{{ config('ui-docs.github_url') }}" class="hover:text-fg" rel="noopener noreferrer" target="_blank">GitHub</a>
            @else
                {{-- TODO: github_url once repository is public --}}
                <span class="text-fg-subtle">GitHub: TODO</span>
            @endif
            @if (config('ui-docs.whatsapp_url'))
                <a href="{{ config('ui-docs.whatsapp_url') }}" class="hover:text-fg" rel="noopener noreferrer" target="_blank">WhatsApp</a>
            @else
                {{-- TODO: whatsapp_url once published --}}
                <span class="text-fg-subtle">WhatsApp: TODO</span>
            @endif
        </div>
    </div>
    <p class="mt-6 text-xs text-fg-subtle">MIT License. Version {{ config('ui-docs.version') }}.</p>
</footer>
