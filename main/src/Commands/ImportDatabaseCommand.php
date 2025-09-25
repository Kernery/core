<?php

namespace Kernery\Main\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kernery\Main\Helpers\AppHelper;
use Kernery\Main\Services\FlushCacheService;
use Kernery\Main\Supports\DatabaseOperation;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;

use function Laravel\Prompts\confirm;

#[AsCommand('kernery:db:import', 'Import database from SQL file in path.')]
class ImportDatabaseCommand extends Command
{
    public function handle(): int
    {
        try {
            if (! confirm('Are you sure you want to run this database command?', false)) {

                return self::FAILURE;
            }

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
                        fn () => DatabaseOperation::loadSqlFromPath($filepath, null)
                    );

                    $this->components->task(
                        'Flushing app cache',
                        fn () => FlushCacheService::prepare()->purgeAllCache()
                    );

                    return self::SUCCESS;

                case 'mariadb':

                case 'pgsql':

            }

            $this->components->error(sprintf('The driver [%s] does not support importing.', $dbDriver));

            return self::FAILURE;

        } catch (Exception $exception) {

            $this->components->error('Error during database export');

            $this->components->error($exception->getMessage());
        }

        $this->components->error(sprintf('The driver [%s] doesn\'t support.', $dbDriver));

        return self::SUCCESS;
    }

    protected function configure(): void
    {

        $this->addArgument('file', InputArgument::OPTIONAL, 'The SQL file to import.', 'mysql.database.sql');
    }
}
