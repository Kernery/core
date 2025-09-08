<?php

namespace Kernery\Icon\Facades;

use Illuminate\Support\Facades\Facade;
use Kernery\Icon\Supports\ManageIcon;

class Icon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ManageIcon::class;
    }
}
