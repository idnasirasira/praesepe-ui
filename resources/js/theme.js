/**
 * Theme and color-scheme persistence for Praesepe UI.
 * Pair with the inline FOUC-prevention script in the document head.
 */

const THEME_KEY = 'praesepe-ui.theme';
const SCHEME_KEY = 'praesepe-ui.color-scheme';

const THEMES = ['praesepe', 'minimal', 'warm'];
const SCHEMES = ['light', 'dark', 'system'];

/**
 * @returns {'praesepe' | 'minimal' | 'warm'}
 */
export function getStoredTheme() {
    const value = localStorage.getItem(THEME_KEY);

    return THEMES.includes(value) ? value : 'praesepe';
}

/**
 * @returns {'light' | 'dark' | 'system'}
 */
export function getStoredColorScheme() {
    const value = localStorage.getItem(SCHEME_KEY);

    return SCHEMES.includes(value) ? value : 'system';
}

/**
 * @param {'praesepe' | 'minimal' | 'warm'} theme
 */
export function setTheme(theme) {
    if (!THEMES.includes(theme)) {
        return;
    }

    localStorage.setItem(THEME_KEY, theme);
    document.documentElement.setAttribute('data-theme', theme);
    window.dispatchEvent(new CustomEvent('ui-theme-change', { detail: { theme } }));
}

/**
 * @param {'light' | 'dark' | 'system'} scheme
 */
export function setColorScheme(scheme) {
    if (!SCHEMES.includes(scheme)) {
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

    document.documentElement.setAttribute('data-theme', theme);
    applyColorScheme(scheme);

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (getStoredColorScheme() === 'system') {
            applyColorScheme('system');
        }
    });

    window.PraesepeTheme = {
        getStoredTheme,
        getStoredColorScheme,
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
export const FOUC_SCRIPT = `(function(){try{var t=localStorage.getItem('praesepe-ui.theme')||'praesepe';var s=localStorage.getItem('praesepe-ui.color-scheme')||'system';var d=document.documentElement;d.setAttribute('data-theme',t);var dark=s==='dark'||(s==='system'&&window.matchMedia('(prefers-color-scheme: dark)').matches);d.classList.toggle('dark',dark);}catch(e){}})();`;
