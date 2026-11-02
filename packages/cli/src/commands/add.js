import path from 'node:path';
import { parseArgs } from '../args.js';
import { readComponentsConfig, resolveRegistryUrl } from '../config.js';
import { writeProjectFile } from '../fs.js';
import { resolveInstallFiles } from '../registry.js';

/**
 * @param {string[]} argv
 */
export async function addCommand(argv) {
  const { positionals, flags } = parseArgs(argv);
  const cwd = path.resolve(String(flags.cwd ?? process.cwd()));
  const overwrite = Boolean(flags.overwrite);
  const registry = resolveRegistryUrl(cwd, typeof flags.registry === 'string' ? flags.registry : undefined);

  if (positionals.length === 0) {
    throw new Error('Usage: npx @praesepe/ui add <component...> [--overwrite]');
  }

  if (!readComponentsConfig(cwd)) {
    console.warn('Warning: components.json missing. Run init first, or pass --registry.');
  }

  const { resolved, files } = await resolveInstallFiles(registry, positionals);

  let written = 0;
  let skipped = 0;

  for (const file of files) {
    const result = writeProjectFile(cwd, file.path, file.content, { overwrite });
    if (result === 'written') {
      written += 1;
      console.log(`+ ${file.path}`);
    } else {
      skipped += 1;
      console.log(`= ${file.path} (exists)`);
    }
  }

  console.log(
    `\nInstalled ${resolved.join(', ')}: ${written} written, ${skipped} skipped.${
      skipped > 0 && !overwrite ? ' Re-run with --overwrite to replace.' : ''
    }`,
  );
}
