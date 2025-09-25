<?php

namespace Kernery\Main\Supports;

class SystemCore
{
    protected static function prepare(): void
    {
        app(self::class);
    }
}
