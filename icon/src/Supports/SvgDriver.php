<?php

namespace Kernery\Icon\Supports;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Kernery\Icon\Exceptions\SvgNotFoundException;

class SvgDriver extends IconDriver
{
    protected array $icons;

    protected array $cachedContents = [];

    public function __construct(
        protected Filesystem $files,
    ) {
        $this->setIconPath(core_path('icon/resources/svg'));
    }

    public function all(): array
    {
        return $this->icons ??= $this->discoverIcons();
    }

    public function render(string $name, array $attributes = []): string
    {

        if (! $this->has($name)) {
            throw_if(App::hasDebugModeEnabled(), SvgNotFoundException::missing($name));

            return '';
        }

        $contents = $this->getContents($name);

        $contents = trim(preg_replace('/^(<\?xml.+?\?>)/', '', $contents));

        return str_replace(
            '<svg',
            rtrim(sprintf('<svg %s', $this->parseAttributesToHtml($attributes))),
            $contents
        );
    }

    protected function getContents(string $name): string
    {
        if (! $this->has($name)) {
            return '';
        }

        return $this->cachedContents[$name]
            ??= $this->files->get($this->icons[$name]['path']);
    }

    public function has(string $name): bool
    {
        return $this->discoverIcon($name);
    }

    protected function discoverIcons(): array
    {
        if (! $this->files->isDirectory($this->iconPath())) {
            return [];
        }

        $files = $this->files->glob($this->iconPath() . '/*.svg');

        $icons = [];

        foreach ($files as $file) {
            $mainname = str_replace('.svg', '', basename($file));
            $name = sprintf('ti ti-%s', $mainname);
            $icons[$mainname] = [
                'name' => $name,
                'basename' => $mainname,
                'path' => $file,
            ];
        }

        return $icons;
    }

    protected function discoverIcon(string $name): bool
    {
        $name = Str::startsWith($name, 'ti ti-') ? $name : 'ti ti-' . $name;
        $mainname = $this->normalizeName($name);

        if (isset($this->icons[$mainname])) {
            return true;
        }

        $file = $this->iconPath() . '/' . $mainname . '.svg';

        if (! $this->files->exists($file)) {
            return false;
        }

        $this->icons[$mainname] = [
            'name' => $name,
            'basename' => $mainname,
            'path' => $file,
        ];

        return true;

    }

    public function normalizeName(string $name): string
    {
        return Str::after($name, 'ti ti-');

    }
}
