<?php

namespace Kernery\Icon\Providers;

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
        
    }
}