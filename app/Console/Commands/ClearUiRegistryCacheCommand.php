<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Docs\InstallRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearUiRegistryCacheCommand extends Command
{
    protected $signature = 'ui:clear-registry-cache';

    protected $description = 'Clear cached docs component registry and install registry payloads';

    public function handle(InstallRegistry $installRegistry): int
    {
        $version = (string) config('ui-docs.version', '0');

        $installRegistry->flushCache();

        Cache::forget('ui.registry');
        Cache::forget('ui.registry.'.$version);
        Cache::forget('ui.search-index');
        Cache::forget('ui.search-index.'.$version);

        $this->info('Cleared UI registry caches for version '.$version);

        return self::SUCCESS;
    }
}
