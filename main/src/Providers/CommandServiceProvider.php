<?php

namespace Kernery\Main\Providers;

use Kernery\Main\Commands\DeleteLogCommand;
use Kernery\Main\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            DeleteLogCommand::class,
        ]);
    }
}
