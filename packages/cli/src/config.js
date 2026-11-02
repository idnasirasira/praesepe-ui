import fs from 'node:fs';
import path from 'node:path';

export const DEFAULT_REGISTRY = 'https://ui.praesepe.id/r';

/**
 * @param {string} cwd
 * @returns {string}
 */
export function componentsJsonPath(cwd) {
  return path.join(cwd, 'components.json');
}

/**
 * @param {string} cwd
 * @returns {{ $schema?: string, style: string, registry: string, aliases: { ui: string, icons: string, css: string } } | null}
 */
export function readComponentsConfig(cwd) {
  const file = componentsJsonPath(cwd);

  if (!fs.existsSync(file)) {
    return null;
  }

  return JSON.parse(fs.readFileSync(file, 'utf8'));
}

/**
 * @param {string} cwd
 * @param {{ style: string, registry: string, aliases: { ui: string, icons: string, css: string } }} config
 * @param {{ overwrite?: boolean }} [options]
 * @returns {'written' | 'skipped'}
 */
export function writeComponentsConfig(cwd, config, options = {}) {
  const file = componentsJsonPath(cwd);

  if (fs.existsSync(file) && !options.overwrite) {
    return 'skipped';
  }

  const payload = {
    $schema: 'https://ui.praesepe.id/r/schema.json',
    ...config,
  };

  fs.writeFileSync(file, `${JSON.stringify(payload, null, 2)}\n`, 'utf8');

  return 'written';
}

/**
 * @param {string} cwd
 * @param {string | undefined} registryOverride
 * @returns {string}
 */
export function resolveRegistryUrl(cwd, registryOverride) {
  if (registryOverride) {
    return registryOverride.replace(/\/$/, '');
  }

  if (process.env.PRAESEPE_REGISTRY) {
    return process.env.PRAESEPE_REGISTRY.replace(/\/$/, '');
  }

  const config = readComponentsConfig(cwd);

  if (config?.registry) {
    return String(config.registry).replace(/\/$/, '');
  }

  return DEFAULT_REGISTRY;
}
