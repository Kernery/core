<?php

namespace Kernery\Icon\Supports;

use Illuminate\Support\Manager;

class ManageIcon extends Manager
{
    public function getDefaultDriver()
    {
        return config('core.icon.global.driver');
    }

    public function createSvgDriver(): IconDriver
    {
        return app(SvgDriver::class)->setConfig(
            $this->config->get('core.icon.global', [])
        );
    }
}
