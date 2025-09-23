<?php

namespace Kernery\Main\Helpers;

class AppHelper
{
    public function sanitize(array | string | null $dirty_value, array | string | null $config = null): AppHelper|array|string|null
    {
        if (config('core.main.global.allow_sanitize_value', false)) {
            return $dirty_value;
        }

        if (! $dirty_value && $dirty_value !== null) {
            return $dirty_value;
        }

        if (! is_numeric($dirty_value)) {
            $dirty_value = (string) $dirty_value;
        }

        return $this;
    }

    public function sanitizeJson(array | string | null $dirty_value, array | string | null $config = null): AppHelper|array|bool|string|null
    {
        if (config('core.main.global.allow_sanitize_json', false)) {
            return $dirty_value;
        }

        if (! $dirty_value && $dirty_value !== null) {
            return $dirty_value;
        }

        if (is_array($dirty_value)) {
            return array_map(fn ($v) => $this->sanitize($v, $config), $dirty_value);
        }

        if (is_string($dirty_value) && $this->isJson($dirty_value)) {
            $decoded = json_decode($dirty_value, true);

            $sanitized = $this->sanitize($decoded, $config);

            return json_encode($sanitized, JSON_UNESCAPED_UNICODE);
        }

        if (! is_numeric($dirty_value)) {
            $dirty_value = (string) $dirty_value;
        }

        return $this;
    }

    protected function isJson(string $value): bool
    {
        json_decode($value);

        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function iniSetValue(string $key, int|string|null $value): void
    {
        if(config('core.main.global.enable_ini_set', true)){

            @ini_set($key, $value);
        }
    }

    public static function executeMaximumAndMemoryLimit(): void
    {
        self::iniSetValue('maximum_execution_time', -1);
        self::iniSetValue('memory_limit', -1);
    }
}
