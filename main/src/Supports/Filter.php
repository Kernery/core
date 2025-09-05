<?php

namespace Kernery\Main\Supports;

class Filter extends ActionHookEvent
{
    public function fire(string $action, array $args)
    {
        $value = $args[0] ?? '';
        if (! $this->getListeners()) {
            return $value;
        }

        foreach ($this->getListeners() as $hook => $listeners) {
            ksort($listeners);
            foreach ($listeners as $arguments) {
                if ($hook === $action) {
                    $parameters = [$value];
                    for ($index = 1; $index < $arguments['arguments']; $index++) {
                        if (isset($args[$index])) {
                            $parameters[] = $args[$index];
                        }
                    }
                    $value = call_user_func_array($this->getFunction($arguments['callback']), $parameters);
                }
            }
        }

        return $value;
    }
}
