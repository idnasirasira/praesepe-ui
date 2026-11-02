<?php

declare(strict_types=1);

namespace App\Docs;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use RuntimeException;

class InstallRegistry
{
    public function __construct(
        private readonly ComponentRegistry $components,
        private readonly string $viewsComponentsPath = '',
        private readonly string $themeCssPath = '',
    ) {}

    /**
     * @return array{version: string, registry: string, items: list<array{slug: string, name: string, description: string, category: string}>}
     */
    public function index(): array
    {
        if (! app()->isLocal()) {
            /** @var array{version: string, registry: string, items: list<array{slug: string, name: string, description: string, category: string}>} */
            return Cache::rememberForever('ui.install-registry.index', fn (): array => $this->buildIndex());
        }

        return $this->buildIndex();
    }

    /**
     * @return array{
     *     slug: string,
     *     name: string,
     *     description: string,
     *     category: string,
     *     dependencies: list<string>,
     *     icons: list<string>,
     *     resolved: list<string>,
     *     files: list<array{path: string, type: string, content: string, dependency_of: string|null}>
     * }
     */
    public function package(string $slug): array
    {
        if (! preg_match('/^[a-z0-9-]+$/', $slug)) {
            throw new InvalidArgumentException("Invalid component slug: {$slug}");
        }

        if ($this->components->find($slug) === null) {
            throw new InvalidArgumentException("Unknown component slug: {$slug}");
        }

        if (! app()->isLocal()) {
            /** @var array{slug: string, name: string, description: string, category: string, dependencies: list<string>, icons: list<string>, resolved: list<string>, files: list<array{path: string, type: string, content: string, dependency_of: string|null}>} */
            return Cache::rememberForever(
                'ui.install-registry.package.'.$slug,
                fn (): array => $this->buildPackage([$slug]),
            );
        }

        return $this->buildPackage([$slug]);
    }

    /**
     * Resolve one or more component slugs into a deduplicated install payload.
     *
     * @param  list<string>  $slugs
     * @return array{
     *     slugs: list<string>,
     *     resolved: list<string>,
     *     files: list<array{path: string, type: string, content: string, dependency_of: string|null}>
     * }
     */
    public function resolve(array $slugs): array
    {
        $normalized = [];

        foreach ($slugs as $slug) {
            $slug = trim($slug);

            if ($slug === '') {
                continue;
            }

            if (! preg_match('/^[a-z0-9-]+$/', $slug)) {
                throw new InvalidArgumentException("Invalid component slug: {$slug}");
            }

            if ($this->components->find($slug) === null) {
                throw new InvalidArgumentException("Unknown component slug: {$slug}");
            }

            $normalized[] = $slug;
        }

        $normalized = array_values(array_unique($normalized));

        if ($normalized === []) {
            throw new InvalidArgumentException('At least one component slug is required.');
        }

        $package = $this->buildPackage($normalized);

        return [
            'slugs' => $normalized,
            'resolved' => $package['resolved'],
            'files' => $package['files'],
        ];
    }

    /**
     * @return array{path: string, content: string, checklist: list<string>}
     */
    public function init(): array
    {
        $themePath = $this->themeCssPath();
        $resolved = realpath($themePath);

        if ($resolved === false || ! is_file($resolved)) {
            throw new RuntimeException('theme.css not found: '.$themePath);
        }

        $content = file_get_contents($resolved);

        if ($content === false) {
            throw new RuntimeException('Unable to read theme.css');
        }

        return [
            'path' => 'resources/css/theme.css',
            'content' => $content,
            'checklist' => [
                'Ensure Tailwind CSS v4 with @tailwindcss/vite is installed.',
                'Import theme.css beside @import "tailwindcss"; in your app CSS.',
                'Add @source for Blade views that use Praesepe components.',
                'Install alpinejs and @alpinejs/focus; register the focus plugin once.',
                'Run npx @praesepe/ui add <component> (or MCP get_install_files) to copy primitives.',
            ],
        ];
    }

    public function themeCss(): string
    {
        return $this->init()['content'];
    }

    /**
     * @return array{version: string, registry: string, items: list<array{slug: string, name: string, description: string, category: string}>}
     */
    private function buildIndex(): array
    {
        $items = [];

        foreach ($this->components->all() as $page) {
            $items[] = [
                'slug' => $page->slug,
                'name' => $page->name,
                'description' => $page->description,
                'category' => $page->category,
            ];
        }

        return [
            'version' => (string) config('ui-docs.version'),
            'registry' => rtrim((string) config('ui-docs.url'), '/').'/r',
            'items' => $items,
        ];
    }

    /**
     * @param  list<string>  $rootSlugs
     * @return array{
     *     slug: string,
     *     name: string,
     *     description: string,
     *     category: string,
     *     dependencies: list<string>,
     *     icons: list<string>,
     *     resolved: list<string>,
     *     files: list<array{path: string, type: string, content: string, dependency_of: string|null}>
     * }
     */
    private function buildPackage(array $rootSlugs): array
    {
        $ordered = $this->resolveDependencyOrder($rootSlugs);
        $filesByPath = [];
        $allIcons = [];

        foreach ($ordered as $slug) {
            $page = $this->components->findOrFail($slug);
            $componentFiles = $this->componentSourceFiles($page);
            $contents = [];

            foreach ($componentFiles as $relativePath) {
                $absolute = $this->assertReadableComponentPath($relativePath);
                $content = $this->readFile($absolute);
                $contents[] = $content;
                $filesByPath[$relativePath] ??= [
                    'path' => $relativePath,
                    'type' => 'component',
                    'content' => $content,
                    'dependency_of' => in_array($slug, $rootSlugs, true) ? null : $slug,
                ];
            }

            $icons = $page->icons !== []
                ? $page->icons
                : $this->detectIcons(implode("\n", $contents));

            foreach ($icons as $icon) {
                $allIcons[$icon] = true;
                $iconRelative = 'resources/views/components/icons/'.$icon.'.blade.php';
                $absolute = $this->assertReadableIconPath($icon);
                $filesByPath[$iconRelative] ??= [
                    'path' => $iconRelative,
                    'type' => 'icon',
                    'content' => $this->readFile($absolute),
                    'dependency_of' => $slug,
                ];
            }
        }

        $primary = $this->components->findOrFail($rootSlugs[0]);
        $directDeps = array_values(array_filter(
            $ordered,
            static fn (string $slug): bool => ! in_array($slug, $rootSlugs, true),
        ));

        return [
            'slug' => count($rootSlugs) === 1 ? $rootSlugs[0] : implode(',', $rootSlugs),
            'name' => count($rootSlugs) === 1 ? $primary->name : 'Multiple components',
            'description' => count($rootSlugs) === 1
                ? $primary->description
                : 'Install package for: '.implode(', ', $rootSlugs),
            'category' => $primary->category,
            'dependencies' => $directDeps,
            'icons' => array_keys($allIcons),
            'resolved' => $ordered,
            'files' => array_values($filesByPath),
        ];
    }

    /**
     * @param  list<string>  $rootSlugs
     * @return list<string>
     */
    private function resolveDependencyOrder(array $rootSlugs): array
    {
        $ordered = [];
        $visiting = [];

        $visit = function (string $slug) use (&$visit, &$ordered, &$visiting): void {
            if (in_array($slug, $ordered, true)) {
                return;
            }

            if (isset($visiting[$slug])) {
                throw new RuntimeException("Circular component dependency involving [{$slug}]");
            }

            $visiting[$slug] = true;
            $page = $this->components->findOrFail($slug);

            foreach ($this->dependenciesFor($page) as $dependency) {
                $visit($dependency);
            }

            unset($visiting[$slug]);
            $ordered[] = $slug;
        };

        foreach ($rootSlugs as $slug) {
            $visit($slug);
        }

        return $ordered;
    }

    /**
     * @return list<string>
     */
    private function dependenciesFor(ComponentPage $page): array
    {
        if ($page->dependencies !== []) {
            return $page->dependencies;
        }

        $contents = [];

        foreach ($this->componentSourceFiles($page) as $relativePath) {
            $contents[] = $this->readFile($this->assertReadableComponentPath($relativePath));
        }

        return $this->detectComponentDependencies(implode("\n", $contents), $page->slug);
    }

    /**
     * @return list<string> Relative paths from the project root
     */
    private function componentSourceFiles(ComponentPage $page): array
    {
        if ($page->files !== []) {
            return array_values(array_unique($page->files));
        }

        $root = $this->viewsComponentsPath();
        $single = $root.DIRECTORY_SEPARATOR.'ui'.DIRECTORY_SEPARATOR.$page->slug.'.blade.php';
        $directory = $root.DIRECTORY_SEPARATOR.'ui'.DIRECTORY_SEPARATOR.$page->slug;

        if (is_file($single)) {
            return ['resources/views/components/ui/'.$page->slug.'.blade.php'];
        }

        if (is_dir($directory)) {
            $files = [];

            foreach (File::allFiles($directory) as $file) {
                if ($file->getExtension() !== 'php' || ! str_ends_with($file->getFilename(), '.blade.php')) {
                    continue;
                }

                $relativeInside = str_replace('\\', '/', substr($file->getPathname(), strlen($directory) + 1));
                $files[] = 'resources/views/components/ui/'.$page->slug.'/'.$relativeInside;
            }

            sort($files);

            if ($files === []) {
                throw new RuntimeException("No Blade files found for component [{$page->slug}]");
            }

            return $files;
        }

        throw new RuntimeException("Unable to locate install files for component [{$page->slug}]");
    }

    /**
     * @return list<string>
     */
    private function detectComponentDependencies(string $contents, string $currentSlug): array
    {
        preg_match_all('/<x-ui\.([a-z0-9-]+)/', $contents, $matches);
        $deps = [];

        foreach ($matches[1] as $name) {
            if ($name === $currentSlug) {
                continue;
            }

            if ($this->components->find($name) === null) {
                continue;
            }

            $deps[$name] = true;
        }

        return array_keys($deps);
    }

    /**
     * @return list<string>
     */
    private function detectIcons(string $contents): array
    {
        preg_match_all('/<x-icons\.([a-z0-9-]+)/', $contents, $matches);
        $icons = [];

        foreach ($matches[1] as $name) {
            $icons[$name] = true;
        }

        ksort($icons);

        return array_keys($icons);
    }

    private function assertReadableComponentPath(string $relativePath): string
    {
        $relativePath = str_replace('\\', '/', $relativePath);

        if (! str_starts_with($relativePath, 'resources/views/components/ui/')) {
            throw new InvalidArgumentException('Install file must live under resources/views/components/ui/: '.$relativePath);
        }

        $suffix = substr($relativePath, strlen('resources/views/components/'));
        $candidate = $this->viewsComponentsPath().DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $suffix);
        $base = realpath($this->viewsComponentsPath());
        $resolved = realpath($candidate);

        if ($base === false || $resolved === false || ! is_file($resolved)) {
            throw new InvalidArgumentException('Install file not found: '.$relativePath);
        }

        if (! str_starts_with($resolved, $base.DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException('Install file escapes components root: '.$relativePath);
        }

        return $resolved;
    }

    private function assertReadableIconPath(string $icon): string
    {
        if (! preg_match('/^[a-z0-9-]+$/', $icon)) {
            throw new InvalidArgumentException('Invalid icon name: '.$icon);
        }

        $candidate = $this->viewsComponentsPath().DIRECTORY_SEPARATOR.'icons'.DIRECTORY_SEPARATOR.$icon.'.blade.php';
        $base = realpath($this->viewsComponentsPath().DIRECTORY_SEPARATOR.'icons');
        $resolved = realpath($candidate);

        if ($base === false || $resolved === false || ! is_file($resolved)) {
            throw new InvalidArgumentException("Icon not found: {$icon}");
        }

        if (! str_starts_with($resolved, $base.DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException('Icon path escapes icons root: '.$icon);
        }

        return $resolved;
    }

    private function readFile(string $absolutePath): string
    {
        $contents = file_get_contents($absolutePath);

        if ($contents === false) {
            throw new RuntimeException('Unable to read file: '.$absolutePath);
        }

        return $contents;
    }

    private function viewsComponentsPath(): string
    {
        $path = $this->viewsComponentsPath !== ''
            ? $this->viewsComponentsPath
            : resource_path('views/components');

        $resolved = realpath($path);

        if ($resolved === false) {
            throw new RuntimeException('Components directory does not exist: '.$path);
        }

        return $resolved;
    }

    private function themeCssPath(): string
    {
        return $this->themeCssPath !== ''
            ? $this->themeCssPath
            : resource_path('css/theme.css');
    }
}
