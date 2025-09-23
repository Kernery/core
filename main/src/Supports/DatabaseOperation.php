<?php

namespace Kernery\Main\Supports;

use Illuminate\Support\Facades\DB;

class DatabaseOperation
{
    public static function loadSqlFromPath(string $pathToSqlFile, string $connection = null)
    {
        DB::purge($connection);
        DB::connection()->setDatabaseName(DB::getDatabaseName());
        DB::getSchemaBuilder()->dropAllTables();
        DB::unprepared(file_get_contents($pathToSqlFile));
    }
}