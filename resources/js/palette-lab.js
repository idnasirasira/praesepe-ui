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

const CHROMA_MIN = 0.02;
const CHROMA_MAX = 0.22;
const LIGHTNESS_MIN = 0.28;
const LIGHTNESS_MAX = 0.72;

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

function srgbChannelToLinear(channel) {
    return channel <= 0.04045
        ? channel / 12.92
        : ((channel + 0.055) / 1.055) ** 2.4;
}

function linearToSrgbChannel(channel) {
    const value = channel <= 0.0031308
        ? 12.92 * channel
        : 1.055 * (channel ** (1 / 2.4)) - 0.055;

    return clamp(value, 0, 1);
}

function parseHex(value) {
    const raw = String(value ?? '').trim().replace(/^#/, '');

    if (! /^[0-9a-fA-F]{3}$|^[0-9a-fA-F]{6}$/.test(raw)) {
        return null;
    }

    const hex = raw.length === 3
        ? raw.split('').map((char) => char + char).join('')
        : raw;

    return {
        r: Number.parseInt(hex.slice(0, 2), 16) / 255,
        g: Number.parseInt(hex.slice(2, 4), 16) / 255,
        b: Number.parseInt(hex.slice(4, 6), 16) / 255,
    };
}

export function hexToOklch(hex) {
    const rgb = parseHex(hex);

    if (! rgb) {
        return null;
    }

    const lr = srgbChannelToLinear(rgb.r);
    const lg = srgbChannelToLinear(rgb.g);
    const lb = srgbChannelToLinear(rgb.b);

    const l = 0.4122214708 * lr + 0.5363325363 * lg + 0.0514459929 * lb;
    const m = 0.2119034982 * lr + 0.6806995451 * lg + 0.1073969566 * lb;
    const s = 0.0883024619 * lr + 0.2817188376 * lg + 0.6299787005 * lb;

    const lRoot = Math.cbrt(l);
    const mRoot = Math.cbrt(m);
    const sRoot = Math.cbrt(s);

    const lightness = 0.2104542553 * lRoot + 0.7936177850 * mRoot - 0.0040720468 * sRoot;
    const a = 1.9779984951 * lRoot - 2.4285922050 * mRoot + 0.4505937099 * sRoot;
    const b = 0.0259040371 * lRoot + 0.7827717662 * mRoot - 0.8086757660 * sRoot;
    const chroma = Math.sqrt(a * a + b * b);
    let hue = Math.atan2(b, a) * (180 / Math.PI);

    if (hue < 0) {
        hue += 360;
    }

    return {
        hue: chroma < 0.0001 ? 0 : hue,
        chroma,
        lightness,
    };
}

export function oklchToHex(lightness, chroma, hue) {
    const h = (Number(hue) * Math.PI) / 180;
    const C = Number(chroma);
    const L = Number(lightness);
    const a = Math.cos(h) * C;
    const b = Math.sin(h) * C;

    const lRoot = L + 0.3963377774 * a + 0.2158037573 * b;
    const mRoot = L - 0.1055613458 * a - 0.0638541728 * b;
    const sRoot = L - 0.0894841775 * a - 1.2914855480 * b;

    const l = lRoot ** 3;
    const m = mRoot ** 3;
    const s = sRoot ** 3;

    const lr = +4.0767416621 * l - 3.3077115913 * m + 0.2309699292 * s;
    const lg = -1.2684380046 * l + 2.6097574011 * m - 0.3413193965 * s;
    const lb = -0.0041960863 * l - 0.7034186147 * m + 1.7076147010 * s;

    const toHex = (channel) => Math.round(linearToSrgbChannel(channel) * 255)
        .toString(16)
        .padStart(2, '0');

    return `#${toHex(lr)}${toHex(lg)}${toHex(lb)}`;
}

function clampLabValues({ hue, chroma, lightness }) {
    return {
        hue: Math.round(clamp(Number(hue), 0, 360)),
        chroma: Number(clamp(Number(chroma), CHROMA_MIN, CHROMA_MAX).toFixed(2)),
        lightness: Number(clamp(Number(lightness), LIGHTNESS_MIN, LIGHTNESS_MAX).toFixed(2)),
    };
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
    const initialHue = stored?.hue ?? defaults.hue;
    const initialChroma = stored?.chroma ?? defaults.chroma;
    const initialLightness = stored?.lightness ?? defaults.lightness;

    return {
        presets: PRESETS,
        name: stored?.name ?? 'My theme',
        hue: initialHue,
        chroma: initialChroma,
        lightness: initialLightness,
        hex: oklchToHex(initialLightness, initialChroma, initialHue),
        hexError: false,
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

        syncHexFromLab() {
            this.hex = oklchToHex(this.lightness, this.chroma, this.hue);
            this.hexError = false;
        },

        tokenMap() {
            return buildTokenMap(this.hue, this.chroma, this.lightness);
        },

        applyPreset(preset) {
            this.hue = preset.hue;
            this.chroma = preset.chroma;
            this.lightness = preset.lightness;
            this.syncHexFromLab();
            this.persist();

            if (this.active) {
                this.useAsTheme();
            }
        },

        onChange() {
            this.syncHexFromLab();
            this.persist();

            if (this.active) {
                applyCustomTokens(this.tokenMap());
            }
        },

        onHexInput() {
            const parsed = hexToOklch(this.hex);

            if (! parsed) {
                this.hexError = true;

                return;
            }

            const next = clampLabValues(parsed);

            this.hue = next.hue;
            this.chroma = next.chroma;
            this.lightness = next.lightness;
            this.hex = oklchToHex(next.lightness, next.chroma, next.hue);
            this.hexError = false;
            this.persist();

            if (this.active) {
                applyCustomTokens(this.tokenMap());
            }
        },

        onHexPicker(event) {
            this.hex = event.target.value;
            this.onHexInput();
        },

        persist() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify({
                name: String(this.name || 'My theme').slice(0, 40),
                hue: Number(this.hue),
                chroma: Number(this.chroma),
                lightness: Number(this.lightness),
                hex: this.hex,
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
