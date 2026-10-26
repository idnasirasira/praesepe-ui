import { expect, test } from '@playwright/test';

test.describe('keyboard interactions', () => {
    test('modal Escape close, focus trap, and focus return', async ({ page }) => {
        await page.goto('/docs/components/modal', { waitUntil: 'networkidle' });

        const openButton = page.getByRole('button', { name: 'Open dialog' }).first();
        await openButton.focus();
        await openButton.press('Enter');

        const dialog = page.getByRole('dialog').filter({ has: page.getByRole('heading', { name: 'Project details' }) });
        await expect(dialog).toBeVisible();

        const closeIcon = dialog.getByRole('button', { name: 'Close dialog' });
        const closeAction = dialog.getByRole('button', { name: 'Close', exact: true });
        await expect(closeIcon).toBeFocused();

        await page.keyboard.press('Tab');
        await expect(closeAction).toBeFocused();

        await page.keyboard.press('Tab');
        await expect(closeIcon).toBeFocused();

        await page.keyboard.press('Escape');
        await expect(dialog).toBeHidden();
        await expect(openButton).toBeFocused();
    });

    test('dropdown ArrowDown ArrowUp Home End Escape', async ({ page }) => {
        await page.goto('/docs/components/dropdown', { waitUntil: 'networkidle' });

        const trigger = page.getByRole('button', { name: 'Actions' }).first();
        await trigger.focus();
        await page.keyboard.press('ArrowDown');

        const menu = page.getByRole('menu').first();
        await expect(menu).toBeVisible();

        const items = menu.getByRole('menuitem');
        await expect(items.nth(0)).toBeFocused();

        await page.keyboard.press('ArrowDown');
        await expect(items.nth(1)).toBeFocused();

        await page.keyboard.press('ArrowUp');
        await expect(items.nth(0)).toBeFocused();

        await page.keyboard.press('End');
        await expect(items.last()).toBeFocused();

        await page.keyboard.press('Home');
        await expect(items.first()).toBeFocused();

        await page.keyboard.press('Escape');
        await expect(menu).toBeHidden();
        await expect(trigger).toBeFocused();
    });

    test('tabs ArrowRight and ArrowLeft', async ({ page }) => {
        await page.goto('/docs/components/tabs', { waitUntil: 'networkidle' });

        const tablist = page.locator('[role="tablist"][aria-orientation="horizontal"]').first();
        const tabs = tablist.getByRole('tab');

        await expect.poll(async () => tabs.first().getAttribute('aria-selected')).toBe('true');

        await tabs.first().focus();
        await expect(tabs.first()).toHaveAttribute('aria-selected', 'true');

        await page.keyboard.press('ArrowRight');
        await expect(tabs.nth(1)).toBeFocused();
        await expect(tabs.nth(1)).toHaveAttribute('aria-selected', 'true');

        await page.keyboard.press('ArrowLeft');
        await expect(tabs.first()).toBeFocused();
        await expect(tabs.first()).toHaveAttribute('aria-selected', 'true');
    });

    test('command palette opens with Cmd/Ctrl+K and /', async ({ page }) => {
        await page.goto('/docs', { waitUntil: 'networkidle' });

        const dialog = page.getByRole('dialog', { name: 'Search documentation' });
        const searchInput = dialog.getByRole('combobox', {
            name: 'Search components, props, variants, and docs',
        });

        const modifier = process.platform === 'darwin' ? 'Meta' : 'Control';
        await page.keyboard.press(`${modifier}+k`);
        await expect(dialog).toBeVisible();
        await expect(searchInput).toBeFocused();
        await expect(searchInput).toHaveAttribute('aria-expanded', 'true');
        await expect(searchInput).toHaveAttribute('aria-controls', 'search-results');

        await searchInput.fill('a');
        await expect(dialog.getByRole('option').first()).toBeVisible();
        await expect
            .poll(async () => dialog.getByRole('option').count())
            .toBeGreaterThan(1);
        await expect(searchInput).toHaveAttribute('aria-activedescendant', 'search-option-0');
        await page.keyboard.press('ArrowDown');
        await expect(searchInput).toHaveAttribute('aria-activedescendant', 'search-option-1');

        await page.keyboard.press('Escape');
        await expect(dialog).toBeHidden();

        await page.locator('#main-content').click();
        await page.keyboard.press('/');
        await expect(dialog).toBeVisible();
        await expect(searchInput).toBeFocused();
    });
});
