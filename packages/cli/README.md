# `@praesepe/ui`

CLI to wire Praesepe UI into a Laravel + Tailwind CSS v4 + Alpine.js app (copy-paste model).

> npm publish is pending. Until `@praesepe/ui` is on the registry, run the binary from this repo.

## Usage (from this monorepo)

```bash
node packages/cli/bin/praesepe-ui.js init --registry https://ui.praesepe.id/r
node packages/cli/bin/praesepe-ui.js add button modal --registry https://ui.praesepe.id/r
node packages/cli/bin/praesepe-ui.js add toast --overwrite
```

After publish:

```bash
npx @praesepe/ui@latest init
npx @praesepe/ui@latest add button
```

Default registry: `https://ui.praesepe.id/r`

Override with `--registry`, `components.json`, or `PRAESEPE_REGISTRY`.

## Local development

```bash
cd packages/cli
npm test
```
