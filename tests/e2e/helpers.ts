import fs from 'node:fs';
import path from 'node:path';

import AxeBuilder from '@axe-core/playwright';
import { expect, type Page } from '@playwright/test';

export const THEMES = ['praesepe', 'minimal', 'warm'] as const;
export const SCHEMES = ['light', 'dark'] as const;

export type ThemeId = (typeof THEMES)[number];
export type SchemeId = (typeof SCHEMES)[number];

export function componentSlugs(): string[] {
    const dir = path.join(process.cwd(), 'resources/docs/components');

    return fs
        .readdirSync(dir)
        .filter((file) => file.endsWith('.php'))
        .map((file) => file.replace(/\.php$/, ''))
        .sort();
}

export function docsRoutes(): string[] {
    return ['/', '/ui', '/docs', ...componentSlugs().map((slug) => `/docs/components/${slug}`)];
}

export async function applyThemeAndScheme(page: Page, theme: ThemeId, scheme: SchemeId): Promise<void> {
    await page.addInitScript(
        ({ themeId, schemeId }) => {
            window.localStorage.setItem('praesepe-ui.theme', themeId);
            window.localStorage.setItem('praesepe-ui.color-scheme', schemeId);
        },
        { themeId: theme, schemeId: scheme },
    );
}

function formatViolations(
    violations: Array<{
        id: string;
        impact?: string | null;
        help: string;
        nodes: Array<{ target: string[]; failureSummary?: string }>;
    }>,
): string {
    if (violations.length === 0) {
        return 'No critical or serious Axe violations';
    }

    return violations
        .map((violation) => {
            const nodes = violation.nodes
                .map((node) => `  - ${node.target.join(' ')}: ${node.failureSummary ?? 'n/a'}`)
                .join('\n');

            return `[${violation.impact}] ${violation.id}: ${violation.help}\n${nodes}`;
        })
        .join('\n\n');
}

export async function waitForThemeTokens(page: Page): Promise<void> {
    await expect
        .poll(async () => page.locator('body').evaluate((el) => getComputedStyle(el).getPropertyValue('--ui-fg').trim()))
        .not.toBe('');
}

export async function expectNoSeriousAxeViolations(page: Page): Promise<void> {
    await waitForThemeTokens(page);

    const results = await new AxeBuilder({ page })
        .withTags(['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa'])
        .analyze();

    const serious = results.violations.filter(
        (violation) => violation.impact === 'critical' || violation.impact === 'serious',
    );

    expect(serious, formatViolations(serious)).toHaveLength(0);
}
