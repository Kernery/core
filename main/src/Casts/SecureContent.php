<?php

namespace Kernery\Main\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Kernery\Main\Facades\AppHelper;

class SecureContent implements CastsAttributes
{
    /**
     * Cast the given value when setting into database.
     */
    public function set($model, string $key, $value, array $attributes): array | string | null
    {
        return AppHelper::sanitize($value);
    }

    /**
     * Cast the given value when retrieving from database.
     */
    public function get($model, string $key, $value, array $attributes): string
    {
        return html_entity_decode(AppHelper::sanitize($value));
    }
}
