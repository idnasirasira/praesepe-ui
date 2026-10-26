<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders dropdown trigger and menu aria contracts', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.dropdown label="Actions">
            <x-ui.dropdown.item>Edit</x-ui.dropdown.item>
            <x-ui.dropdown.item variant="disabled">Locked</x-ui.dropdown.item>
            <x-ui.dropdown.separator />
            <x-ui.dropdown.item variant="danger">Delete</x-ui.dropdown.item>
        </x-ui.dropdown>
    BLADE);

    expect($html)->toContain('aria-haspopup="menu"')
        ->and($html)->toContain('x-bind:aria-expanded')
        ->and($html)->toContain('role="menu"')
        ->and($html)->toContain('role="menuitem"')
        ->and($html)->toContain('role="separator"')
        ->and($html)->toContain('aria-disabled="true"');
});

it('renders tabs aria contracts for tablist tab and panel', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.tabs variant="underline" active="account">
            <x-slot:list>
                <x-ui.tabs.tab id="account">Account</x-ui.tabs.tab>
                <x-ui.tabs.tab id="billing" disabled>Billing</x-ui.tabs.tab>
            </x-slot:list>
            <x-ui.tabs.panel id="account">Profile</x-ui.tabs.panel>
            <x-ui.tabs.panel id="billing">Invoices</x-ui.tabs.panel>
        </x-ui.tabs>
    BLADE);

    expect($html)->toContain('role="tablist"')
        ->and($html)->toContain('role="tab"')
        ->and($html)->toContain('role="tabpanel"')
        ->and($html)->toContain('x-bind:aria-selected')
        ->and($html)->toContain('aria-controls="account-panel"')
        ->and($html)->toContain('aria-labelledby="account-tab"')
        ->and($html)->toContain('aria-disabled="true"');
});

it('renders accordion aria contracts for header and region', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.accordion type="single" default="shipping">
            <x-ui.accordion.item id="shipping" title="Shipping">Ships soon.</x-ui.accordion.item>
        </x-ui.accordion>
    BLADE);

    expect($html)->toContain('x-bind:aria-expanded')
        ->and($html)->toContain('aria-controls="shipping-panel"')
        ->and($html)->toContain('role="region"')
        ->and($html)->toContain('aria-labelledby="shipping-header"');
});

it('renders tooltip with role and focus or escape handlers', function (): void {
    $html = Blade::render(<<<'BLADE'
        <x-ui.tooltip id="demo-tip" content="More detail" position="top">
            <button type="button">Info</button>
        </x-ui.tooltip>
    BLADE);

    expect($html)->toContain('role="tooltip"')
        ->and($html)->toContain('id="demo-tip-tip"')
        ->and($html)->toContain('aria-describedby')
        ->and($html)->toContain('x-on:focusin')
        ->and($html)->toContain('x-on:keydown.escape')
        ->and($html)->toContain('x-teleport="body"')
        ->and($html)->toContain('w-max');
});

it('renders alert roles for status and danger variants', function (): void {
    $info = Blade::render('<x-ui.alert variant="info" title="Note">Hello</x-ui.alert>');
    $danger = Blade::render('<x-ui.alert variant="danger" title="Error" dismissible>Failed</x-ui.alert>');

    expect($info)->toContain('role="status"')
        ->and($danger)->toContain('role="alert"')
        ->and($danger)->toContain('x-on:click="show = false"')
        ->and($danger)->toContain('aria-label="Dismiss alert"');
});

it('renders toast viewport with live region at body level', function (): void {
    $html = Blade::render('<x-ui.toast-viewport position="bottom-right" />');

    expect($html)->toContain('data-ui-toast-viewport')
        ->and($html)->toContain('aria-live="polite"')
        ->and($html)->toContain('$store.toasts')
        ->and($html)->toContain("toast.type === 'danger' ? 'alert' : 'status'");
});

it('registers the toast store module from app.js', function (): void {
    $appJs = file_get_contents(resource_path('js/app.js'));
    $toastJs = file_get_contents(resource_path('js/toast.js'));

    expect($appJs)->toContain("import { registerToastStore } from './toast'")
        ->and($appJs)->toContain('registerToastStore(Alpine)')
        ->and($toastJs)->toContain("Alpine.store('toasts'")
        ->and($toastJs)->toContain("window.addEventListener('ui:toast'");
});
