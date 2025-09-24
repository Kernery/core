<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kernery\Main\Helpers\AppHelper;
use Kernery\Main\Services\FlushCacheService;
use Kernery\Main\Supports\DatabaseOperation;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('kernery:db:import', 'Import database from SQL file in path.')]
class ImportDatabaseCommand extends Command
{
    public function handle()
    {
        AppHelper::executeMaximumAndMemoryLimit();

        $filename = $this->argument('file');

        if (str_contains($filename, DIRECTORY_SEPARATOR)) {

            $filepath = $filename;

        } else {

            $filepath = db_path($filename);
        }

        if (! File::exists($filepath)) {

            $this->components->error('The Database SQL file not found in path.');

            return self::FAILURE;
        }

        $getDbConfig = DB::getConfig();

        $dbDriver = $getDbConfig['driver'];

        switch ($dbDriver) {

            case 'mysql':

                $this->components->task(
                    'Importing database from SQL file path',
                    fn () => DatabaseOperation::loadSqlFromPath($filepath)
                );

                $this->components->task(
                    'Flushing app cache',
                    fn () => FlushCacheService::prepare()->purgeAllCache()
                );

                return self::SUCCESS;

            case 'mariadb':

            case 'pgsql':
        }

        $this->components->error(sprintf('The driver [%s] doesn\'t support.', $dbDriver));

        return self::FAILURE;
    }

    protected function configure()
    {

        $this->addArgument('file', InputArgument::OPTIONAL, 'The SQL file to import.', 'mysql.database.sql');
    }
}
