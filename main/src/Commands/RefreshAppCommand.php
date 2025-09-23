<?php

namespace Kernery\Main\Commands;

use Exception;
use Illuminate\Console\Command;
use Kernery\Main\Services\RefreshDatabaseService;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\confirm;

#[AsCommand('kernery:app:refresh', 'Cleanup all records from the database except core system records needed to keep the app running.')]
class RefreshAppCommand extends Command
{
    public function handle(RefreshDatabaseService $refreshDatabaseService): int
    {
        try {

            if (! confirm('Are you sure you want to run this command?', false)) {
                return self::FAILURE;
            }

            $this->components->task('Refreshing DB...', fn () => $refreshDatabaseService->executeService());

            $this->components->info('✅ Database refresh sucessful');

        } catch (Exception $exception) {

            $this->components->error('Error during app refresh');

            $this->components->error($exception->getMessage());
        }

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addOption('force', '--f', null, 'Refresh app without confirmation.');
    }
}
