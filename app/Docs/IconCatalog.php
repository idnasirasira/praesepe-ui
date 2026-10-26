<?php

declare(strict_types=1);

namespace App\Docs;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class IconCatalog
{
    /**
     * @return list<array{name: string, component: string, usage: string}>
     */
    public function all(): array
    {
        $directory = resource_path('views/components/icons');

        if (! File::isDirectory($directory)) {
            return [];
        }

        $icons = [];

        foreach (File::files($directory) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $basename = $file->getFilename();

            if (! str_ends_with($basename, '.blade.php')) {
                continue;
            }

            $name = Str::before($basename, '.blade.php');

            if ($name === '' || ! preg_match('/^[a-z0-9-]+$/', $name)) {
                continue;
            }

            $icons[] = [
                'name' => $name,
                'component' => 'icons.'.$name,
                'usage' => '<x-icons.'.$name.' class="size-4 shrink-0" />',
            ];
        }

        usort($icons, static fn (array $a, array $b): int => $a['name'] <=> $b['name']);

        return $icons;
    }
}
