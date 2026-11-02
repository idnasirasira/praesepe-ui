import fs from 'node:fs';
import path from 'node:path';
import { parseArgs } from '../args.js';
import { DEFAULT_REGISTRY, resolveRegistryUrl, writeComponentsConfig } from '../config.js';
import { ensureAppCssWiring, looksLikeLaravelApp, writeProjectFile } from '../fs.js';
import { fetchThemeCss } from '../registry.js';

/**
 * @param {string[]} argv
 */
export async function initCommand(argv) {
  const { flags } = parseArgs(argv);
  const cwd = path.resolve(String(flags.cwd ?? process.cwd()));
  const registry = resolveRegistryUrl(cwd, typeof flags.registry === 'string' ? flags.registry : undefined);

  if (!looksLikeLaravelApp(cwd)) {
    console.warn('Warning: artisan/composer.json not found. Continuing anyway.');
  }

  const configResult = writeComponentsConfig(
    cwd,
    {
      style: 'praesepe',
      registry: registry || DEFAULT_REGISTRY,
      aliases: {
        ui: 'resources/views/components/ui',
        icons: 'resources/views/components/icons',
        css: 'resources/css',
      },
    },
    { overwrite: Boolean(flags.overwrite) },
  );

  console.log(
    configResult === 'written'
      ? 'Wrote components.json'
      : 'Skipped components.json (exists; pass --overwrite to replace)',
  );

  const themeCss = await fetchThemeCss(registry);
  const themeResult = writeProjectFile(cwd, 'resources/css/theme.css', themeCss, {
    overwrite: Boolean(flags.overwrite),
  });
  console.log(
    themeResult === 'written'
      ? 'Wrote resources/css/theme.css'
      : 'Skipped resources/css/theme.css (exists; pass --overwrite to replace)',
  );

  const appCss = path.join(cwd, 'resources/css/app.css');
  for (const note of ensureAppCssWiring(appCss)) {
    console.log(note);
  }

  const pkgPath = path.join(cwd, 'package.json');
  if (fs.existsSync(pkgPath)) {
    const pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf8'));
    const deps = { ...(pkg.dependencies ?? {}), ...(pkg.devDependencies ?? {}) };
    const missing = ['alpinejs', '@alpinejs/focus'].filter((name) => !deps[name]);

    if (missing.length > 0) {
      console.log(`\nInstall Alpine next:\n  npm install ${missing.join(' ')}`);
      console.log('Then register the focus plugin once in your JS entry.');
    } else {
      console.log('\nAlpine packages already present in package.json.');
    }
  }

  console.log('\nNext: npx @praesepe/ui add button');
}
