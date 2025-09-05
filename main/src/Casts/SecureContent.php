<?php

namespace Kernery\Main\Casts;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
class SecureContent implements CastsAttributes 
{
     public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return html_entity_decode($value);
    }
}