<?php

namespace Kernery\Form\Providers;

use Kernery\Main\Supports\ServiceProvider;
use Kernery\Main\Traits\LoadAndPublishDataTrait;

class FormServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->setNamespace('core/form')
            ->loadAndPublishConfigs('global')
            ->loadHelpers();
    }
}
