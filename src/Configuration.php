<?php

namespace LaraZeus\Tartarus;

use Closure;

trait Configuration
{
    /**
     * the resources navigation group
     */
    protected Closure | string $navigationGroupLabel = 'Tartarus';

    public function navigationGroupLabel(Closure | string $label): static
    {
        $this->navigationGroupLabel = $label;

        return $this;
    }

    public function getNavigationGroupLabel(): Closure | string
    {
        return $this->evaluate($this->navigationGroupLabel);
    }
}
