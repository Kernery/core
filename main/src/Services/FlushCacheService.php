<?php

namespace Kernery\Main\Services;

class FlushCacheService
{
    public static function prepare(): FlushCacheService
    {
        return app(self::class);
    }

    public function purgeAllCache() {}
}
