<?php

namespace Kernery\Main\Providers;

use Illuminate\Foundation\AliasLoader;
use Kernery\Main\Facades\AppHelper;
use Kernery\Main\Supports\ServiceProvider;
use Kernery\Main\Traits\LoadAndPublishDataTrait;

class MainServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->setNamespace('core/main')
            ->loadAndPublishConfigs('global')
            ->loadHelpers();

        $this->prepareMissingAliases();

        $this->app->singleton('core.app-fonts', AppFont::class);
    }

    public function boot(): void {}

    protected function prepareMissingAliases(): void
    {
        $aliasLoader = AliasLoader::getInstance();

        if (! class_exists('AppHelper')) {

            $aliasLoader->alias('AppHelper', AppHelper::class);
        }
    }
}
