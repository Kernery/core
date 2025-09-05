<?php

namespace Kernery\Main\Contracts;

interface HasTreeStep
{
    public static function updateTree(array $data): void;
}