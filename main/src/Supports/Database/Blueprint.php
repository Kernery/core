<?php

namespace Kernery\Main\Supports\Database;
use Illuminate\Database\Schema\Blueprint as LaravelBlueprint;
use Closure;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\ColumnDefinition;

class Blueprint extends LaravelBlueprint
{

    public function __construct(Connection $connection, $table, Closure $callback = null)
    {
        // This constructor extends the parent DB class and adds a safeguard so Kernery migrations won’t fail on MySQL servers that enforce primary keys on all tables.

        parent::__construct($connection, $table, $callback);

        rescue(function () {
            if (DB::getDefaultConnection() === 'mysql') {
                DB::statement('SET SESSION sql_require_primary_key=0');
            }
        }, report: false);
    }

    public function foreignId($column): ColumnDefinition
    {
        return match ($this->getModelTypeOfId()) {
            'UUID' => $this->foreignUuid($column),
            'ULID' => $this->foreignUlid($column),
            default => parent::foreignId($column),
        };
    }

    public function id($column = 'id'): ColumnDefinition
    {
        return match ($this->getModelTypeOfId()) {
            'UUID' => $this->uuid($column)->primary(),
            'ULID' => $this->ulid($column)->primary(),
            default => parent::id($column),
        };
    }

    public function morphs($name, $indexName = null, $after = null): void
    {
        match ($this->getModelTypeOfId()) {
            'UUID' => $this->uuidMorphs($name, $indexName, $after),
            'ULID' => $this->ulidMorphs($name, $indexName, $after),
            default => parent::morphs($name, $indexName, $after),
        };
    }

    public function nullableMorphs($name, $indexName = null, $after = null): void
    {
        match ($this->getModelTypeOfId()) {
            'UUID' => $this->nullableUuidMorphs($name, $indexName, $after),
            'ULID' => $this->nullableUlidMorphs($name, $indexName, $after),
            default => parent::nullableMorphs($name, $indexName, $after),
        };
    }
}
