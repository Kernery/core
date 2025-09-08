<?php

namespace Kernery\Icon\Exceptions;

use Exception;

class SvgNotFoundException extends Exception
{
    public static function missing(string $name): self
    {
        return new self(sprintf('SVG icon with name [%s] is not found.', $name));
    }
}
