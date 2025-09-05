<?php

namespace Kernery\Main\Tests;

use Kernery\Main\Facades\AppHelper;
use Tests\TestCase;

class MainTest extends TestCase
{
    public function test_that_json_is_sanitized()
    {
        $helper = new AppHelper;

        $dirty_value = '{"name":"<b>Pelumi</b>","tags":["<i>cool</i>","<script>alert(1)</script>"]}';

        $expected_value = '{"name":"Pelumi","tags":["cool","alert(1)"]}';

        $this->assertSame(
            $expected_value,
            $helper->sanitizeJson($dirty_value)
        );
    }
}
