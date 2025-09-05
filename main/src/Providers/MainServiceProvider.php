<?php

namespace Kernery\Main\Providers;

use Illuminate\Foundation\AliasLoader;
use Kernery\Main\Facades\AppHelper;
use Kernery\Main\Supports\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->prepareMissingAliases();
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
