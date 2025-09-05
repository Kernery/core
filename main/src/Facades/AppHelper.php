<?php

namespace Kernery\Main\Facades;

use Illuminate\Support\Facades\Facade;
use Kernery\Main\Helpers\AppHelper as AppHelperSupport;

class AppHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AppHelperSupport::class;
    }
}
