<?php

namespace Kernery\Main\Exceptions;

use Exception;

class MissingZipException extends Exception
{
    public function __construct()
    {
        parent::__construct('PHP Zip extension is not installed. Please install it.');
    }
}
