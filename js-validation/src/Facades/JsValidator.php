<?php

namespace Kernery\JsValidation\Facades;

use Illuminate\Support\Facades\Facade;

class JsValidator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'js-validator';
    }
}
