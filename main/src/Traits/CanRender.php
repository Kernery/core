<?php

namespace Kernery\Main\Traits;

use Closure;

trait CanRender
{
    protected Closure $renderUsing;

    protected array $beforeRenderingCallbacks = [];

    protected array $afterRenderingCallbacks = [];

    protected function dispatchBeforeRendering(): void
    {
        foreach ($this->beforeRenderingCallbacks as $beforeRender) {
            call_user_func($beforeRender, $this);
        }
    }

    public function afterRendering(Closure $afterRenderCallback): static
    {
        $this->afterRenderingCallbacks[] = $afterRenderCallback;

        return $this;
    }

    public function renderUsing(Closure $renderUsingCallback): static
    {
        $this->renderUsing = $renderUsingCallback;

        return $this;
    }

    public function beforeRendering(Closure $beforeRenderCallback): static
    {
        $this->beforeRenderingCallbacks[] = $beforeRenderCallback;

        return $this;
    }

    protected function dispatchAfterRendering(mixed $rendered): void
    {
        foreach ($this->afterRenderingCallbacks as $after) {
            call_user_func($after, $this, $rendered);
        }
    }

    public function rendering(Closure | string $content): mixed
    {
        $this->dispatchBeforeRendering();

        $content = value($content);

        $rendered = null;

        if (isset($this->renderUsing)) {
            $rendered = call_user_func($this->renderUsing, $this, $content);
        }

        $rendered = $rendered === null ? $content : $rendered;

        return tap($rendered, fn (mixed $rendered) => $this->dispatchAfterRendering($rendered));
    }
}
