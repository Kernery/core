<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Kernery\Main\Helpers\AppHelper;
use Kernery\Main\Supports\SystemCore;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('kernery:update', 'Update app to the latest version.')]
class AppUpdateCommand extends Command
{
    public function __construct(protected SystemCore $systemCore)
    {
        parent::__construct();
    }

    public function handle()
    {
        if (! config('core.main.global.app_update', true)) {

            $this->components->error('Please enable app update in your config.');

            return self::FAILURE;
        }

        AppHelper::executeMaximumAndMemoryLimit();

        $this->components->info('Checking for latest version...');
    }
}
