# `@praesepe/ui`

CLI to wire Praesepe UI into a Laravel + Tailwind CSS v4 + Alpine.js app (copy-paste model, like shadcn).

## Usage

```bash
npx @praesepe/ui@latest init
npx @praesepe/ui@latest add button modal
npx @praesepe/ui@latest add toast --overwrite
```

Default registry: `https://ui.praesepe.id/r`

Override with `--registry`, `components.json`, or `PRAESEPE_REGISTRY`.

## Local development

From this monorepo:

```bash
cd packages/cli
npm test
node bin/praesepe-ui.js init --cwd /path/to/laravel --registry http://127.0.0.1:8000/r
```

Publishing to npm is a separate maintainer step after the registry is live in production.
