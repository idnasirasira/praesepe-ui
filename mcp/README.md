# Praesepe UI MCP (Laravel)

Coding agents discover Praesepe UI components through [Laravel MCP](https://laravel.com/docs/mcp).

Public consumer guide: `/docs/mcp` on the docs site.

## Public surface

| What | Purpose |
|------|---------|
| `POST {APP_URL}/mcp/praesepe-ui` | Remote HTTP MCP (no auth, throttled) |
| `/docs/mcp` | Human setup for Cursor and other clients |
| `app/Mcp/*` + `routes/ai.php` | Server and tools |

Local editor config (`.cursor/`, Boost MCP, etc.) is private maintainer tooling. It is not part of the public MCP product.

## Tools

| Tool | Purpose |
|------|---------|
| `list_components` | List components (optional `category`) |
| `search_components` | Search by name/slug/tags/props |
| `get_component` | Props, a11y notes, example slugs |
| `get_snippet` | Blade or HTML source for an example |
| `list_icons` | Built-in `x-icons.*` set |
| `get_guidelines` | Authoring rules for agents (same as resource below) |

### Resources

| URI | Purpose |
|-----|---------|
| `praesepe://guidelines` | Full consumer rules: Anti-generic, Taste rules, Blade/Alpine/tokens/icons |

Add new consumer rules here (`app/Docs/AgentGuidelines.php`), not in private `.cursor/rules`.

## Cursor (recommended): remote HTTP

Point at production. No clone required.

```json
{
  "mcpServers": {
    "praesepe-ui": {
      "url": "https://ui.praesepe.id/mcp/praesepe-ui"
    }
  }
}
```

Restart Cursor and enable **praesepe-ui**.

For local maintenance of this repo only, you can temporarily point at your `APP_URL` (for example `http://127.0.0.1:8000/mcp/praesepe-ui`) or use stdio below.

## Optional: local stdio

Only if you have this repo checked out and prefer stdio over HTTP. Add to your private Cursor MCP settings (do not commit editor config for consumers):

```json
{
  "mcpServers": {
    "praesepe-ui": {
      "type": "stdio",
      "command": "php",
      "args": [
        "/absolute/path/to/praesepe-ui/artisan",
        "mcp:start",
        "praesepe-ui"
      ]
    }
  }
}
```

Cursor starts `mcp:start`. Do not run it by hand.

## Manual checks

```bash
php artisan route:list --path=mcp
php artisan test --compact tests/Feature/PraesepeUiMcpTest.php
php artisan mcp:inspector praesepe-ui
```

## Agent workflow

1. `get_guidelines`
2. `search_components` / `list_components`
3. `get_component`
4. `get_snippet` (`blade` or `html`)
5. Adapt into the consuming app with long-form Alpine
