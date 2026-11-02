import { addCommand } from './commands/add.js';
import { initCommand } from './commands/init.js';

export async function run(argv) {
  const [command, ...rest] = argv;

  if (command === 'init') {
    return initCommand(rest);
  }

  if (command === 'add') {
    return addCommand(rest);
  }

  if (command === 'help' || command === '--help' || command === '-h' || !command) {
    printHelp();
    return;
  }

  throw new Error(`Unknown command: ${command}\n\nRun npx @praesepe/ui --help`);
}

function printHelp() {
  console.log(`Praesepe UI CLI

Usage:
  npx @praesepe/ui@latest init
  npx @praesepe/ui@latest add <components...> [--overwrite]
  npx @praesepe/ui@latest add button modal

Options:
  --registry <url>   Override registry base (default https://ui.praesepe.id/r)
  --cwd <path>       Working directory (default process.cwd())
  --overwrite        Replace existing component files on add
  -h, --help         Show help
`);
}
