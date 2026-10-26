@props([
    'props' => [],
])

@if (count($props) > 0)
    <div class="overflow-x-auto rounded-card border border-border">
        <table class="min-w-full text-left text-sm">
            <caption class="sr-only">Component props</caption>
            <thead class="bg-surface-sunken text-fg-muted">
                <tr>
                    <th scope="col" class="px-4 py-2 font-medium">Prop</th>
                    <th scope="col" class="px-4 py-2 font-medium">Type</th>
                    <th scope="col" class="px-4 py-2 font-medium">Default</th>
                    <th scope="col" class="px-4 py-2 font-medium">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($props as $prop)
                    <tr class="border-t border-border">
                        <td class="px-4 py-2 font-mono text-xs text-fg">{{ $prop['name'] }}</td>
                        <td class="px-4 py-2 text-fg-muted">{{ $prop['type'] }}</td>
                        <td class="px-4 py-2 font-mono text-xs text-fg-subtle">{{ $prop['default'] ?? 'null' }}</td>
                        <td class="px-4 py-2 text-fg-muted">{{ $prop['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
