import fs from 'node:fs';
import path from 'node:path';

const ALLOWED_PREFIXES = [
  'resources/views/components/ui/',
  'resources/views/components/icons/',
  'resources/css/',
];

/**
 * @param {string} relativePath
 * @returns {boolean}
 */
export function isAllowedInstallPath(relativePath) {
  const normalized = relativePath.replace(/\\/g, '/').replace(/^\.\//, '');

  if (normalized.includes('..') || path.isAbsolute(normalized)) {
    return false;
  }

  return ALLOWED_PREFIXES.some((prefix) => normalized === prefix.slice(0, -1) || normalized.startsWith(prefix));
}

/**
 * @param {string} cwd
 * @param {string} relativePath
 * @param {string} content
 * @param {{ overwrite?: boolean }} [options]
 * @returns {'written' | 'skipped'}
 */
export function writeProjectFile(cwd, relativePath, content, options = {}) {
  const normalized = relativePath.replace(/\\/g, '/');

  if (!isAllowedInstallPath(normalized)) {
    throw new Error(
      `Refusing to write disallowed path: ${relativePath}. Allowed: ${ALLOWED_PREFIXES.join(', ')}`,
    );
  }

  const target = path.resolve(cwd, normalized);
  const root = path.resolve(cwd);

  if (!target.startsWith(root + path.sep) && target !== root) {
    throw new Error(`Refusing to write outside project: ${relativePath}`);
  }

  if (fs.existsSync(target) && !options.overwrite) {
    return 'skipped';
  }

  fs.mkdirSync(path.dirname(target), { recursive: true });
  fs.writeFileSync(target, content, 'utf8');

  return 'written';
}

/**
 * @param {string} cwd
 * @returns {boolean}
 */
export function looksLikeLaravelApp(cwd) {
  return fs.existsSync(path.join(cwd, 'artisan')) && fs.existsSync(path.join(cwd, 'composer.json'));
}

/**
 * Ensure theme import and a views @source exist in the consumer CSS entry.
 *
 * @param {string} cssPath
 * @returns {string[]}
 */
export function ensureAppCssWiring(cssPath) {
  if (!fs.existsSync(cssPath)) {
    return [`Skipped CSS wiring: ${cssPath} not found. Import theme.css manually.`];
  }

  let source = fs.readFileSync(cssPath, 'utf8');
  const notes = [];

  if (!source.includes('theme.css')) {
    if (source.includes('@import "tailwindcss";')) {
      source = source.replace(
        '@import "tailwindcss";',
        '@import "tailwindcss";\n@import "./theme.css";',
      );
    } else if (source.includes("@import 'tailwindcss';")) {
      source = source.replace(
        "@import 'tailwindcss';",
        "@import 'tailwindcss';\n@import \"./theme.css\";",
      );
    } else {
      source = `@import "./theme.css";\n${source}`;
    }
    notes.push(`Added @import "./theme.css"; to ${path.basename(cssPath)}`);
  }

  if (!source.includes('@source') || !source.includes('views')) {
    source = `${source.trimEnd()}\n\n@source "../views/**/*.blade.php";\n`;
    notes.push(`Added @source "../views/**/*.blade.php"; to ${path.basename(cssPath)}`);
  }

  fs.writeFileSync(cssPath, source.endsWith('\n') ? source : `${source}\n`, 'utf8');

  return notes;
}
