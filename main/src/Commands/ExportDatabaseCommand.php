<?php

namespace Kernery\Main\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\confirm;

#[AsCommand('kernery:db:export', 'Export application database to SQL file within the app.')]
class ExportDatabaseCommand extends Command
{
    public function handle(): int
    {
        try {

            if (! confirm('Are you sure you want to run this database command?', false)) {

                return self::FAILURE;
            }

            $getDbConfig = DB::getConfig();

            $dbDriver = $getDbConfig['driver'];

            switch ($dbDriver) {

                case 'mysql':

                    $sqlPath = db_path($getDbConfig['driver'] . '.database.sql');

                    $shellCommand = 'mysqldump --user="%s" --password="%s" --host="%s" --port="%s" "%s" > "%s"';

                    Process::fromShellCommandline(
                        sprintf($shellCommand, $getDbConfig['username'], $getDbConfig['password'], $getDbConfig['host'], $getDbConfig['port'], $getDbConfig['database'], $sqlPath)
                    )->mustRun();

                    $this->components->info('✅ Exported database to SQL file.');

                    return self::SUCCESS;

                case 'mariadb':

                    $sqlPath = db_path($getDbConfig['driver'] . '.database.sql');

                    $shellCommand = 'mysqldump --user="%s" --password="%s" --host="%s" --port="%s" "%s" > "%s"';

                    Process::fromShellCommandline(
                        sprintf($shellCommand, $getDbConfig['username'], $getDbConfig['password'], $getDbConfig['host'], $getDbConfig['port'], $getDbConfig['database'], $sqlPath)
                    )->mustRun();

                    $this->components->info('✅ Exported database to SQL file.');

                    return self::SUCCESS;

                case 'pgsql':

                    $sqlPath = db_path($getDbConfig['driver'] . '.database.sql');

                    $shellCommand = 'PGPASSWORD="%s" pg_dump --username="%s" --host="%s" --port="%s" --dbname="%s" -Fc > "%s"';

                    Process::fromShellCommandline(
                        sprintf($shellCommand, $getDbConfig['username'], $getDbConfig['password'], $getDbConfig['host'], $getDbConfig['port'], $getDbConfig['database'], $sqlPath)
                    )->mustRun();

                    $this->components->info('✅ Exported database to SQL file.');

                    return self::SUCCESS;
            }

            $this->components->error(sprintf('The driver [%s] does not support.', $dbDriver));

            return self::FAILURE;

        } catch (Exception $exception) {

            $this->components->error('Error during database export');

            $this->components->error($exception->getMessage());
        }

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addOption('force', '--f', null, 'Export database without confirmation.');
    }
}
