<?php

namespace Kernery\Main\Supports;

use Illuminate\Support\Facades\DB;

class Database
{
    public static function restoreFromPath(?string $connection = null): void
    {
        DB::connection()->setDatabaseName(DB::getDatabaseName());
        DB::getSchemaBuilder()->dropAllTables();
        DB::purge($connection);
    }
}
