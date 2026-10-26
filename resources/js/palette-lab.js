const STORAGE_KEY = 'praesepe-ui.custom-theme';

const PAGE_VARS = [
    '--ui-brand',
    '--ui-on-brand',
    '--ui-ring',
    '--ui-success',
    '--ui-on-success',
    '--ui-warning',
    '--ui-on-warning',
    '--ui-danger',
    '--ui-on-danger',
    '--ui-info',
    '--ui-on-info',
];

const PRESETS = [
    { id: 'indigo', label: 'Indigo', hue: 278, chroma: 0.17, lightness: 0.46 },
    { id: 'teal', label: 'Teal', hue: 195, chroma: 0.10, lightness: 0.46 },
    { id: 'coral', label: 'Coral', hue: 25, chroma: 0.16, lightness: 0.58 },
    { id: 'forest', label: 'Forest', hue: 155, chroma: 0.12, lightness: 0.42 },
    { id: 'sand', label: 'Sand', hue: 75, chroma: 0.08, lightness: 0.52 },
    { id: 'rose', label: 'Rose', hue: 350, chroma: 0.14, lightness: 0.50 },
];

function clamp(value, min, max) {
    return Math.min(max, Math.max(min, value));
}

function oklch(lightness, chroma, hue) {
    return `oklch(${lightness.toFixed(2)} ${chroma.toFixed(2)} ${Math.round(hue)})`;
}

function onColor(lightness, hue) {
    return lightness >= 0.65
        ? oklch(0.22, 0.04, hue)
        : oklch(0.99, 0.01, hue);
}

function readStored() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);

        if (! raw) {
            return null;
        }

        return JSON.parse(raw);
    } catch {
        return null;
    }
}

export function buildTokenMap(hue, chroma, lightness) {
    const h = Number(hue);
    const c = Number(chroma);
    const l = Number(lightness);
    const brand = oklch(l, c, h);

    return {
        '--ui-brand': brand,
        '--ui-on-brand': onColor(l, h),
        '--ui-ring': oklch(clamp(l + 0.08, 0.35, 0.78), clamp(c * 0.85, 0.04, 0.18), h),
        '--ui-success': oklch(0.48, 0.12, 155),
        '--ui-on-success': oklch(0.99, 0.01, 155),
        '--ui-warning': oklch(0.68, 0.17, 55),
        '--ui-on-warning': oklch(0.99, 0.01, 70),
        '--ui-danger': oklch(0.52, 0.19, 25),
        '--ui-on-danger': oklch(0.99, 0.01, 25),
        '--ui-info': oklch(0.52, 0.12, 250),
        '--ui-on-info': oklch(0.99, 0.01, 250),
    };
}

export function applyCustomTokens(tokens) {
    Object.entries(tokens).forEach(([key, value]) => {
        document.documentElement.style.setProperty(key, value);
    });
}

export function clearCustomTokens() {
    PAGE_VARS.forEach((key) => {
        document.documentElement.style.removeProperty(key);
    });
}

export function paletteLab() {
    const stored = readStored();
    const defaults = PRESETS[0];

    return {
        presets: PRESETS,
        name: stored?.name ?? 'My theme',
        hue: stored?.hue ?? defaults.hue,
        chroma: stored?.chroma ?? defaults.chroma,
        lightness: stored?.lightness ?? defaults.lightness,
        active: window.PraesepeTheme?.getStoredTheme?.() === 'custom',
        copied: false,

        init() {
            window.addEventListener('ui-theme-change', (event) => {
                this.active = event.detail?.theme === 'custom';
            });
        },

        get previewStyle() {
            return Object.entries(this.tokenMap())
                .map(([key, value]) => `${key}:${value}`)
                .join(';');
        },

        get exportCss() {
            return Object.entries(this.tokenMap())
                .map(([key, value]) => `    ${key}: ${value};`)
                .join('\n');
        },

        get brandSwatch() {
            return oklch(Number(this.lightness), Number(this.chroma), Number(this.hue));
        },

        tokenMap() {
            return buildTokenMap(this.hue, this.chroma, this.lightness);
        },

        applyPreset(preset) {
            this.hue = preset.hue;
            this.chroma = preset.chroma;
            this.lightness = preset.lightness;
            this.persist();

            if (this.active) {
                this.useAsTheme();
            }
        },

        onChange() {
            this.persist();

            if (this.active) {
                applyCustomTokens(this.tokenMap());
            }
        },

        persist() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify({
                name: String(this.name || 'My theme').slice(0, 40),
                hue: Number(this.hue),
                chroma: Number(this.chroma),
                lightness: Number(this.lightness),
                tokens: this.tokenMap(),
            }));
        },

        useAsTheme() {
            this.persist();
            window.PraesepeTheme?.setTheme('custom');
            this.active = true;
        },

        clearTheme() {
            clearCustomTokens();
            this.active = false;

            if (window.PraesepeTheme?.getStoredTheme?.() === 'custom') {
                window.PraesepeTheme.setTheme('praesepe');
            }
        },

        reset() {
            this.name = 'My theme';
            this.applyPreset(PRESETS[0]);
            this.clearTheme();
            localStorage.removeItem(STORAGE_KEY);
        },

        async copyCss() {
            const block = `[data-theme='custom'] {\n${this.exportCss}\n}`;

            try {
                await navigator.clipboard.writeText(block);
                this.copied = true;
                window.setTimeout(() => {
                    this.copied = false;
                }, 1600);
            } catch {
                this.copied = false;
            }
        },
    };
}
