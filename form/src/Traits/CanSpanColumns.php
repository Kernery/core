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

    public function getColumnSpan(int | string | null $breakpoint = null)
    {
        $columnSpan = [];

        $span = $this->getOption('colspan');

        $parent = $this->getParent();

        if ($span === 'full') {
            $parentSpan = $parent->getColumns();

            if ($breakpoint !== null) {
                $span = $parentSpan[$breakpoint] ?? null;
            }
        }

        if (! is_array($span)) {
            $span = [
                'lg' => ceil(12 / ((int) $parent->getColumns('lg')) * $span),
            ];
        }

        $columnSpan = [
            ...$columnSpan,
            ...$span,
        ];

        if ($breakpoint !== null) {
            return $columnSpan[$breakpoint] ?? null;
        }

        return array_map(fn ($value) => $value * $span, $parent->getColumns());
    }
}
