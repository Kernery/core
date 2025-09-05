<?php

namespace Kernery\Main\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Kernery\Main\Facades\AppHelper;

class SecureJson implements CastsAttributes
{
    /**
     * Cast the given value when setting into database.
     */
    public function set($model, string $key, $value, array $attributes): bool | string
    {
        return AppHelper::sanitizeJson( $value );
    }

    /**
     * Cast the given value when retrieving from database.
     */
    public function get($model, string $key, $value, array $attributes): mixed
    {
        return json_decode(AppHelper::sanitizeJson( $value ) );
    }
}
