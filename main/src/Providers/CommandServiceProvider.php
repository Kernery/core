<?php

namespace Kernery\Main\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Kernery\Main\Commands\DeleteLogCommand;
use Kernery\Main\Commands\ExportDatabaseCommand;
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
            RefreshAppCommand::class
        ]);

        AboutCommand::add('Kernery Core Information', fn () => [
            'Core version' => '0.1.0',
            'App version' => env('APP_VERSION', '0.1.0'),
        ]);
    }
}
