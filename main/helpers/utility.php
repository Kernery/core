<?php

const CORE_V = '0.1.0';

if (! function_exists('get_core_version')) {
    function get_core_version(): string
    {
        return self::CORE_V;
    }
}

if (! function_exists('source_path')) {
    function source_path(?string $path = null): string
    {
        $path = ltrim($path, DIRECTORY_SEPARATOR);

        return base_path('source' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}

if (! function_exists('core_path')) {
    function core_path(?string $path = null): string
    {
        return source_path('core' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''));
    }
}

if (! function_exists('module_path')) {
    function module_path(?string $path = null): string
    {
        return source_path('modules' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''));
    }
}
