import assert from 'node:assert/strict';
import { describe, it } from 'node:test';
import { parseArgs } from '../src/args.js';
import { isAllowedInstallPath } from '../src/fs.js';
import { resolveInstallFiles } from '../src/registry.js';

describe('parseArgs', () => {
  it('parses positionals and flags', () => {
    const result = parseArgs(['button', 'modal', '--overwrite', '--registry', 'http://127.0.0.1:8000/r']);

    assert.deepEqual(result.positionals, ['button', 'modal']);
    assert.equal(result.flags.overwrite, true);
    assert.equal(result.flags.registry, 'http://127.0.0.1:8000/r');
  });
});

describe('isAllowedInstallPath', () => {
  it('allows component, icon, and css paths only', () => {
    assert.equal(isAllowedInstallPath('resources/views/components/ui/button.blade.php'), true);
    assert.equal(isAllowedInstallPath('resources/views/components/icons/x.blade.php'), true);
    assert.equal(isAllowedInstallPath('resources/css/theme.css'), true);
    assert.equal(isAllowedInstallPath('.env'), false);
    assert.equal(isAllowedInstallPath('../etc/passwd'), false);
    assert.equal(isAllowedInstallPath('app/Http/Kernel.php'), false);
  });
});

describe('resolveInstallFiles', () => {
  it('dedupes dependency files in topological order', async () => {
    /** @type {Record<string, any>} */
    const packages = {
      button: {
        slug: 'button',
        dependencies: [],
        files: [
          {
            path: 'resources/views/components/ui/button.blade.php',
            type: 'component',
            content: 'button',
            dependency_of: null,
          },
        ],
      },
      modal: {
        slug: 'modal',
        dependencies: ['button'],
        files: [
          {
            path: 'resources/views/components/ui/modal.blade.php',
            type: 'component',
            content: 'modal',
            dependency_of: null,
          },
          {
            path: 'resources/views/components/ui/button.blade.php',
            type: 'component',
            content: 'button-from-modal',
            dependency_of: 'button',
          },
        ],
      },
    };

    const result = await resolveInstallFiles('https://example.test/r', ['modal'], async (_url, slug) => {
      return packages[slug];
    });

    assert.deepEqual(result.resolved, ['button', 'modal']);
    assert.equal(result.files.length, 2);
    assert.equal(
      result.files.find((file) => file.path.endsWith('button.blade.php'))?.content,
      'button',
    );
  });
});
