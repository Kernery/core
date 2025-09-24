<?php

namespace Kernery\Main\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Kernery\Main\Commands\DeleteLogCommand;
use Kernery\Main\Commands\ExportDatabaseCommand;
use Kernery\Main\Commands\FetchAndLoadFontCommand;
use Kernery\Main\Commands\ImportDatabaseCommand;
use Kernery\Main\Commands\RefreshAppCommand;
use Kernery\Main\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            DeleteLogCommand::class,
            ExportDatabaseCommand::class,
            RefreshAppCommand::class,
            ImportDatabaseCommand::class,
            FetchAndLoadFontCommand::class,
        ]);

        AboutCommand::add('About Kernery', fn () => [
            'Core version' => app_core_version(),
            'App version' => env('APP_VERSION', '0.1.0'),
        ]);
    }
}
