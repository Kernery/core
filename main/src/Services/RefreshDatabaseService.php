<?php

namespace Kernery\Main\Services;

use Throwable;

class RefreshDatabaseService
{
    public function ignoreTables(): array
    {
        return [
            'users',
            'pages',
            'settings',
        ];
    }

    public function executeService(array $exclude = [])
    {
        $exclude = array_merge($exclude, $this->ignoreTables());

        try {

        } catch (Throwable) {

        }
    }
}
