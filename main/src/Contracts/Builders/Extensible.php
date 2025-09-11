<?php

namespace Kernery\Main\Contracts\Builders;

interface Extensible
{
    public static function getHookFilterPrefix(): string;

    public static function getGlobalClassName(): string;
}
