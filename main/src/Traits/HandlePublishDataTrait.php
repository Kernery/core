<?php

namespace Kernery\Main\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

class HandlePublishDataTrait
{
    protected ?string $namespace = null;

    protected function setNamespace(string $namespace): self
    {
        $this->namespace = ltrim(rtrim($namespace, '/'), '/');

        $this->app['config']->set(['core.global.plugin_' . File::basename($this->getPath()) => $namespace . '_namespace']);

        return $this;
    }

    protected function getPath(?string $path = null): string
    {
        $reflectionClass = new ReflectionClass($this);

        $moduleDirectory = str_replace('/src/Providers', '', File::dirname($reflectionClass->getFilename()));

        if (! Str::contains($moduleDirectory, base_path('platform/plugins'))) {

            $moduleDirectory = base_path('source/' . $this->getDashedNamespace());
        }

        return $moduleDirectory . ($path ? '/' . ltrim($path, '/') : '');
    }

    protected function getDashedNamespace(): string
    {
        return str_replace('.', '/', $this->namespace);
    }

    protected function loadAndPublishConfigs(array|string $fileNames): self
    {
        if (! is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $this->mergeConfigFrom($this->getConfigFilePath($fileName), $this->getDotedNamespace() . '.' . $fileName);

            if ($this->app->runningInConsole()) {
                $this->publishes([
                    $this->getConfigFilePath($fileName) => config_path($this->getDashedNamespace() . '/' . $fileName . '.php'),
                ], 'kernery-config');
            }
        }

        return $this;
    }
}
