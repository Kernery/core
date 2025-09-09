<?php

namespace Kernery\Main\Exceptions;

use Exception;

class MissingCURLExtension extends Exception
{
    public function __construct()
    {
        parent::__construct('PHP cURL extension is not installed. Please install cURL');
    }
}
