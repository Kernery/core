<?php

namespace Kernery\Icon\Providers;

use Illuminate\Foundation\AliasLoader;
use Kernery\Icon\Facades\Icon as IconFacade;
use Kernery\Main\Supports\ServiceProvider;
use Kernery\Main\Traits\LoadAndPublishDataTrait;

class IconServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this
            ->setNamespace('core/icon')
            ->loadAndPublishConfigs('icon');
    }

    public function boot(): void
    {

        $aliasLoader = AliasLoader::getInstance();

        if (! class_exists('AppIcon')) {
            $aliasLoader->alias('AppIcon', IconFacade::class);
        }
    }
}
