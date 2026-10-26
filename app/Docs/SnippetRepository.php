<?php

declare(strict_types=1);

namespace App\Docs;

use Illuminate\Support\Facades\Blade;
use InvalidArgumentException;
use RuntimeException;

class SnippetRepository
{
    public function __construct(
        private readonly string $basePath = '',
    ) {}

    private function basePath(): string
    {
        $path = $this->basePath !== '' ? $this->basePath : resource_path('snippets');
        $resolved = realpath($path);

        if ($resolved === false) {
            throw new RuntimeException('Snippets directory does not exist: '.$path);
        }

        return $resolved;
    }

    /**
     * Resolve a snippet path that is guaranteed to remain inside the snippets root.
     */
    public function resolvePath(string $componentSlug, string $exampleSlug, string $extension): string
    {
        if (! preg_match('/^[a-z0-9-]+$/', $componentSlug) || ! preg_match('/^[a-z0-9-]+$/', $exampleSlug)) {
            throw new InvalidArgumentException('Invalid snippet identifiers.');
        }

        if (! in_array($extension, ['html', 'blade.php'], true)) {
            throw new InvalidArgumentException('Unsupported snippet extension.');
        }

        $base = $this->basePath();
        $candidate = $base.DIRECTORY_SEPARATOR.$componentSlug.DIRECTORY_SEPARATOR.$exampleSlug.'.'.$extension;
        $resolved = realpath($candidate);

        if ($resolved === false || ! str_starts_with($resolved, $base.DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException("Snippet not found or outside snippets root: {$componentSlug}/{$exampleSlug}.{$extension}");
        }

        return $resolved;
    }

    public function raw(string $componentSlug, string $exampleSlug, string $extension): string
    {
        $path = $this->resolvePath($componentSlug, $exampleSlug, $extension);
        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException('Unable to read snippet: '.$path);
        }

        return $contents;
    }

    /**
     * @return array{html: string, blade: string, preview: string}
     */
    public function loadExample(string $componentSlug, string $exampleSlug): array
    {
        $html = $this->raw($componentSlug, $exampleSlug, 'html');
        $blade = $this->raw($componentSlug, $exampleSlug, 'blade.php');
        $preview = Blade::render($blade);

        return [
            'html' => $html,
            'blade' => $blade,
            'preview' => $preview,
        ];
    }

    public function exists(string $componentSlug, string $exampleSlug, string $extension): bool
    {
        try {
            $this->resolvePath($componentSlug, $exampleSlug, $extension);

            return true;
        } catch (InvalidArgumentException) {
            return false;
        }
    }
}
