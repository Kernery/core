<?php

namespace Kernery\Main\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Kernery\Main\Commands\DeleteLogCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if( !App::runningInConsole()) {
            return;
        }

        $this->commands([
            DeleteLogCommand::class,
        ]);
    }
}
