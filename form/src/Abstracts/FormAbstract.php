<?php

namespace Kernery\Form\Abstracts;

use Illuminate\Support\Str;
use Kernery\Form\Forms\Form;
use Kernery\Main\Contracts\Builders\Extensible as ExtensibleContract;

abstract class FormAbstract extends Form implements ExtensibleContract
{
    protected string $breakFieldPoint = '';

    protected bool $useInlineJs = false;

    protected string $wrapperClass = 'form-body';

    protected bool $onlyValidatedData = false;

    protected bool $withoutActionButtons = false;

    protected array $options = [];

    protected string $title = '';

    protected string $validatorClass = '';

    protected array $metaBoxes = [];

    protected string $actionButtons = '';

    public function __construct()
    {
        $this->setMethod('POST');
        $this->template('core/form::forms.form');
        $this->setFormOption('id', strtolower(Str::slug(Str::snake(static::class))));
        $this->setFormOption('class', 'js-base-form');
    }

    public function setupForm()
    {
        $this->withCustomFields();

        $this->setup();

        if (! $this->model) {
            $this->model = new MainModelInstance;
        }

        $this->setupExtended();
    }

    public function setup(): void {}
}
