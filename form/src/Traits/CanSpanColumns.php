<?php

namespace Kernery\Form\Traits;

class CanSpanColumns
{
    protected int $colspan = 0;

    public function colspan(int $colspan): static
    {
        $this->colspan = $colspan;

        return $this;
    }

    public function getColspan(): int
    {
        return $this->colspan;
    }
}
