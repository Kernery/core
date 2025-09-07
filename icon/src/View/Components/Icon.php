<?php

namespace Kernery\Icon\Supports;
use Illuminate\View\Component;
class Icon extends Component
{
    public function __construct(
        public string $name,
        public string|null $size = null
    ) {
    }
}