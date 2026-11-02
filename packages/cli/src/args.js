/**
 * @param {string[]} argv
 * @returns {{ positionals: string[], flags: Record<string, string | boolean> }}
 */
export function parseArgs(argv) {
  const positionals = [];
  /** @type {Record<string, string | boolean>} */
  const flags = {};

  for (let i = 0; i < argv.length; i += 1) {
    const token = argv[i];

    if (token === '--overwrite') {
      flags.overwrite = true;
      continue;
    }

    if (token === '--registry' || token === '--cwd') {
      const value = argv[i + 1];
      if (!value || value.startsWith('-')) {
        throw new Error(`Missing value for ${token}`);
      }
      flags[token.slice(2)] = value;
      i += 1;
      continue;
    }

    if (token.startsWith('--registry=')) {
      flags.registry = token.slice('--registry='.length);
      continue;
    }

    if (token.startsWith('--cwd=')) {
      flags.cwd = token.slice('--cwd='.length);
      continue;
    }

    if (token.startsWith('-')) {
      throw new Error(`Unknown option: ${token}`);
    }

    positionals.push(token);
  }

  return { positionals, flags };
}
