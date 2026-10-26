@props([
    'props' => [],
])

@if (count($props) > 0)
    <div class="overflow-hidden rounded-card border border-border bg-surface-raised shadow-2xs ring-1 ring-black/5">
        <table class="min-w-full text-left text-sm">
            <caption class="sr-only">Component props</caption>
            <thead class="border-b border-border bg-surface-sunken/80">
                <tr class="text-[11px] font-semibold uppercase tracking-wider text-fg-subtle">
                    <th scope="col" class="px-3 py-2.5 sm:px-4">Prop</th>
                    <th scope="col" class="hidden px-3 py-2.5 sm:table-cell sm:px-4">Type</th>
                    <th scope="col" class="hidden px-3 py-2.5 md:table-cell md:px-4">Default</th>
                    <th scope="col" class="px-3 py-2.5 sm:px-4">Description</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @foreach ($props as $prop)
                    @php
                        $name = (string) ($prop['name'] ?? '');
                        $type = (string) ($prop['type'] ?? '');
                        $default = $prop['default'] ?? 'null';
                        $description = (string) ($prop['description'] ?? '');
                        $defaultLabel = is_bool($default)
                            ? ($default ? 'true' : 'false')
                            : (string) $default;
                    @endphp
                    <tr class="align-top transition-colors duration-150 hover:bg-surface-sunken/40">
                        <td class="px-3 py-3 sm:px-4">
                            <code class="rounded-[5px] bg-brand/10 px-1.5 py-0.5 font-mono text-[12px] font-semibold tracking-tight text-brand">{{ $name }}</code>
                            <div class="mt-2 space-y-1.5 sm:hidden">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-fg-subtle">Type</span>
                                    <code class="rounded-[5px] border border-border bg-surface px-1.5 py-0.5 font-mono text-[11px] text-fg">{{ $type }}</code>
                                </div>
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-fg-subtle">Default</span>
                                    <code class="rounded-[5px] border border-border bg-surface-sunken px-1.5 py-0.5 font-mono text-[11px] tabular-nums text-fg-muted">{{ $defaultLabel }}</code>
                                </div>
                            </div>
                        </td>
                        <td class="hidden px-3 py-3 sm:table-cell sm:px-4">
                            <code class="inline-block max-w-[14rem] whitespace-pre-wrap break-words rounded-[5px] border border-border bg-surface px-1.5 py-0.5 font-mono text-[11px] leading-snug text-fg">{{ $type }}</code>
                        </td>
                        <td class="hidden px-3 py-3 md:table-cell md:px-4">
                            <code class="inline-block rounded-[5px] border border-border bg-surface-sunken px-1.5 py-0.5 font-mono text-[11px] tabular-nums text-fg-muted">{{ $defaultLabel }}</code>
                        </td>
                        <td class="px-3 py-3 text-[13px] leading-relaxed text-pretty text-fg-muted sm:px-4">
                            {{ $description }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
