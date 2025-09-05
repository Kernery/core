<?php

namespace Kernery\Main\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Kernery\Main\Facades\AppHelper;

class SecureContent implements CastsAttributes
{
    public function set($model, string $key, $value, array $attributes)
    {
        return AppHelper::sanitize($value);
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return html_entity_decode(AppHelper::sanitize($value));
    }
}
