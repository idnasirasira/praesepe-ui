/**
 * Theme and color-scheme persistence for Praesepe UI.
 * Pair with the inline FOUC-prevention script in the document head.
 */

import { applyCustomTokens, clearCustomTokens } from './palette-lab';

const THEME_KEY = 'praesepe-ui.theme';
const SCHEME_KEY = 'praesepe-ui.color-scheme';
const CUSTOM_KEY = 'praesepe-ui.custom-theme';

const THEMES = ['praesepe', 'minimal', 'warm', 'custom'];
const SCHEMES = ['light', 'dark', 'system'];

/**
 * @returns {'praesepe' | 'minimal' | 'warm' | 'custom'}
 */
export function getStoredTheme() {
    const value = localStorage.getItem(THEME_KEY);

    if (value === 'custom' && ! hasCustomTheme()) {
        return 'praesepe';
    }

    return THEMES.includes(value) ? value : 'praesepe';
}

/**
 * @returns {'light' | 'dark' | 'system'}
 */
export function getStoredColorScheme() {
    const value = localStorage.getItem(SCHEME_KEY);

    return SCHEMES.includes(value) ? value : 'system';
}

export function hasCustomTheme() {
    try {
        const raw = localStorage.getItem(CUSTOM_KEY);

        if (! raw) {
            return false;
        }

        const parsed = JSON.parse(raw);

        return Boolean(parsed?.tokens?.['--ui-brand']);
    } catch {
        return false;
    }
}

export function getCustomThemeMeta() {
    try {
        const raw = localStorage.getItem(CUSTOM_KEY);

        if (! raw) {
            return null;
        }

        const parsed = JSON.parse(raw);

        return {
            name: parsed.name || 'My theme',
            brand: parsed.tokens?.['--ui-brand'] || 'oklch(0.46 0.17 278)',
            tokens: parsed.tokens || null,
        };
    } catch {
        return null;
    }
}

/**
 * @param {'praesepe' | 'minimal' | 'warm' | 'custom'} theme
 */
export function setTheme(theme) {
    if (! THEMES.includes(theme)) {
        return;
    }

    if (theme === 'custom' && ! hasCustomTheme()) {
        return;
    }

    localStorage.setItem(THEME_KEY, theme);

    if (theme === 'custom') {
        const meta = getCustomThemeMeta();
        document.documentElement.setAttribute('data-theme', 'praesepe');

        if (meta?.tokens) {
            applyCustomTokens(meta.tokens);
        }
    } else {
        clearCustomTokens();
        document.documentElement.setAttribute('data-theme', theme);
    }

    window.dispatchEvent(new CustomEvent('ui-theme-change', { detail: { theme } }));
}

/**
 * @param {'light' | 'dark' | 'system'} scheme
 */
export function setColorScheme(scheme) {
    if (! SCHEMES.includes(scheme)) {
        return;
    }

    localStorage.setItem(SCHEME_KEY, scheme);
    applyColorScheme(scheme);
    window.dispatchEvent(new CustomEvent('ui-color-scheme-change', { detail: { scheme } }));
}

/**
 * @param {'light' | 'dark' | 'system'} scheme
 */
export function applyColorScheme(scheme) {
    const root = document.documentElement;
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = scheme === 'dark' || (scheme === 'system' && prefersDark);

    root.classList.toggle('dark', isDark);
}

export function initTheme() {
    const theme = getStoredTheme();
    const scheme = getStoredColorScheme();

    if (theme === 'custom') {
        document.documentElement.setAttribute('data-theme', 'praesepe');
        const meta = getCustomThemeMeta();

        if (meta?.tokens) {
            applyCustomTokens(meta.tokens);
        }
    } else {
        clearCustomTokens();
        document.documentElement.setAttribute('data-theme', theme);
    }

    applyColorScheme(scheme);

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (getStoredColorScheme() === 'system') {
            applyColorScheme('system');
        }
    });

    window.PraesepeTheme = {
        getStoredTheme,
        getStoredColorScheme,
        getCustomThemeMeta,
        hasCustomTheme,
        setTheme,
        setColorScheme,
        applyColorScheme,
        themes: THEMES,
        schemes: SCHEMES,
    };
}

/**
 * Inline FOUC script source. Keep in sync with layouts/app.blade.php.
 */
export const FOUC_SCRIPT = `(function(){try{var t=localStorage.getItem('praesepe-ui.theme')||'praesepe';var s=localStorage.getItem('praesepe-ui.color-scheme')||'system';var d=document.documentElement;var custom=null;try{custom=JSON.parse(localStorage.getItem('praesepe-ui.custom-theme')||'null');}catch(e){custom=null;}if(t==='custom'&&custom&&custom.tokens){d.setAttribute('data-theme','praesepe');Object.keys(custom.tokens).forEach(function(k){d.style.setProperty(k,custom.tokens[k]);});}else{d.setAttribute('data-theme',t==='custom'?'praesepe':t);}var dark=s==='dark'||(s==='system'&&window.matchMedia('(prefers-color-scheme: dark)').matches);d.classList.toggle('dark',dark);}catch(e){}})();`;
