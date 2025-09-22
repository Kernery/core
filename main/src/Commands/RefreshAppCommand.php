<?php

namespace Kernery\Main\Commands;

use Exception;

use function Laravel\Prompts\confirm;

#[AsCommand('kernery:app:refresh', 'Cleanup all records from the database except core system records needed to keep the app running.')]
class RefreshAppCommand
{
    public function handle()
    {
        try {
            if (! confirm('Are you sure you want to run this command?', false)) {
                return self::FAILURE;
            }
        } catch (Exception $exception) {

        }
    }
}
