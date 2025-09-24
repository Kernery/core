<?php

namespace Kernery\Main\Traits;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

trait LoadAndPublishDataTrait
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

        if (! Str::contains($moduleDirectory, base_path('core/plugins'))) {

            $moduleDirectory = base_path('source/' . $this->getDashedNamespace());
        }

        return $moduleDirectory . ($path ? '/' . ltrim($path, '/') : '');
    }

    protected function getDashedNamespace(): string
    {
        return str_replace('.', '/', $this->namespace);
    }

    protected function loadAndPublishConfigs(array | string $fileNames): self
    {
        $fileNames = is_array($fileNames) ? $fileNames : [$fileNames];

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

    protected function getConfigFilePath(string $file): string
    {
        return $this->getPath('config/' . $file . '.php');
    }

    protected function loadRoutes(array | string $fileNames = ['web']): self
    {
        if (! is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $this->loadRoutesFrom($this->getRouteFilePath($fileName));
        }

        return $this;
    }

    protected function getDotedNamespace(): string
    {
        return str_replace('/', '.', $this->namespace);
    }

    protected function loadAndPublishViews(): self
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->getDashedNamespace());

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$this->getViewsPath() => resource_path('views/vendor/' . $this->getDashedNamespace())],
                'kernery-views'
            );
        }

        return $this;
    }

    protected function getRouteFilePath(string $file): string
    {
        return $this->getPath('routes/' . $file . '.php');
    }

    protected function getViewsPath(): string
    {
        return $this->getPath('/resources/views');
    }

    public function loadAndPublishTranslations(): self
    {
        $this->loadTranslationsFrom($this->getTranslationsPath(), $this->getDashedNamespace());
        $this->publishes(
            [$this->getTranslationsPath() => lang_path('vendor/' . $this->getDashedNamespace())],
            'cms-lang'
        );

        return $this;
    }

    protected function loadMigrations(): self
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());

        return $this;
    }

    protected function getTranslationsPath(): string
    {
        return $this->getPath('/resources/lang');
    }

    protected function getMigrationsPath(): string
    {
        return $this->getPath('/database/migrations');
    }

    protected function publishAssets(?string $path = null): self
    {
        if (empty($path)) {
            $path = 'vendor/core/' . $this->getDashedNamespace();
        }

        $this->publishes([$this->getAssetsPath() => public_path($path)], 'kernery-public');

        return $this;
    }

    protected function loadAnonymousComponents(): self
    {
        Blade::anonymousComponentPath(
            $this->getViewsPath() . '/components',
            str_replace('/', '-', $this->namespace)
        );

        return $this;
    }

    protected function getAssetsPath(): string
    {
        return $this->getPath('public');
    }

    protected function loadHelpers(): self
    {
        $this->getPath('/helpers');

        return $this;
    }
}
