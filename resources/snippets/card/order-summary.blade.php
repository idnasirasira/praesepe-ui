<x-ui.card class="max-w-md">
    <x-slot:header>
        <p class="text-sm font-semibold tracking-tight text-fg">Invoice #INV-2026-089</p>
        <p class="text-xs text-fg-muted leading-relaxed">Toko Sumber Makmur · Bandung</p>
    </x-slot:header>

    <div class="space-y-2 text-sm text-fg">
        <div class="flex justify-between"><span class="text-fg-muted">Subtotal</span><span class="tabular-nums">Rp 1.250.000</span></div>
        <div class="flex justify-between"><span class="text-fg-muted">Shipping</span><span class="tabular-nums">Rp 18.000</span></div>
        <div class="flex justify-between font-medium"><span>Total due</span><span class="tabular-nums">Rp 1.268.000</span></div>
    </div>

    <x-slot:footer>
        <p class="text-sm text-fg-muted">ETA: 2 business days · Paid via QRIS</p>
    </x-slot:footer>
</x-ui.card>
