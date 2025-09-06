<?php

namespace Kernery\Main\Traits;

use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;

trait CanComponent
{
    protected static $components = [];

    public function __call($method, $parameters): mixed
    {
        if (static::hasComponent($method)) {

            return $this->renderComponent($method, $parameters);
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
    }

    public static function component($name, $view, array $signature): void
    {
        static::$components[$name] = compact('view', 'signature');
    }

    protected function renderComponent($name, array $arguments)
    {
        $component = static::$components[$name];

        $data = $this->getComponentData($component['signature'], $arguments);

        return new HtmlString(
            $this->view->make($component['view'], $data)->render()
        );
    }

    public static function hasComponent($name): bool
    {
        return isset(static::$components[$name]);
    }

    protected function getComponentData(array $signature, array $arguments)
    {
        $data = [];

        $i = 0;

        foreach ($signature as $variable => $default) {

            if (is_numeric($variable)) {

                $variable = $default;

                $default = null;
            }

            $data[$variable] = Arr::get($arguments, $i, $default);

            $i++;
        }

        return $data;
    }
}
