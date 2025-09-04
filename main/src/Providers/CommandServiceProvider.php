<?php

namespace Kernery\Main\Providers;

use App;
use Kernery\Main\Commands\DeleteLogCommand;
use Kernery\Main\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! App::runningInConsole()) {
            return;
        }

        $this->commands([
            DeleteLogCommand::class,
        ]);
    }
}
