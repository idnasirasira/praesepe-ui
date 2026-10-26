import { expect, test } from '@playwright/test';

import {
    SCHEMES,
    THEMES,
    applyThemeAndScheme,
    docsRoutes,
    expectNoSeriousAxeViolations,
} from './helpers';

const routes = docsRoutes();

for (const theme of THEMES) {
    for (const scheme of SCHEMES) {
        test.describe(`${theme} / ${scheme}`, () => {
            for (const route of routes) {
                test(`Axe WCAG 2.2 AA on ${route}`, async ({ page }) => {
                    await applyThemeAndScheme(page, theme, scheme);
                    await page.goto(route, { waitUntil: 'networkidle' });
                    await expect(page.locator('html')).toHaveAttribute('data-theme', theme);
                    await expect
                        .poll(async () => page.locator('html').evaluate((el) => el.classList.contains('dark')))
                        .toBe(scheme === 'dark');
                    await expectNoSeriousAxeViolations(page);
                });
            }
        });
    }
}
