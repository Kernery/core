<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('kernery:log:clear', 'Clear all log files within the storag/logs')]
class DeleteLogCommand extends Command
{
    public function handle(Filesystem $filesystem): int
    {
        $logDirectory = storage_path('logs');

        if ($filesystem->isDirectory($logDirectory)) {

            return self::FAILURE;
        }
        $allLogs = $filesystem->allFiles($logDirectory);

        if (empty($allLogs)) {

            $this->components->info('No logs file found');

            return self::SUCCESS;

        }

        $this->newLine();

        $this->components->task('Deleting log files in progress...', function () use ($allLogs, $filesystem) {
            foreach ($allLogs as $file) {
                $this->components->info(sprintf('Deleting [%s]', $file->getPathname()));
                $filesystem->delete($file->getPathname());
            }
        });

        $this->components->info('✔ Deleted log files successfully!');

        return self::SUCCESS;

    }
}
