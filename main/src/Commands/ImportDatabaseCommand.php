<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kernery\Main\Helpers\AppHelper;
use Kernery\Main\Supports\DatabaseOperation;

class ImportDatabaseCommand extends Command
{
    public function handle()
    {
        AppHelper::executeMaximumAndMemoryLimit();

        $filename = $this->argument('file');

        if (str_contains($filename, DIRECTORY_SEPARATOR)) {

            $filePath = $filename;

        } else {

            $filepath = db_path($filename);
        }

        if (! File::exists($filepath)) {

            $this->components->error('The Database SQL file not found.');

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

                return self::SUCCESS;

            case 'mariadb':

            case 'pgsql':
        }

        $this->components->error(sprintf('The driver [%s] does not support.', $dbDriver));

        return self::FAILURE;
    }

    protected function configure() {}
}
