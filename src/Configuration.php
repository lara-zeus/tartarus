<?php

namespace LaraZeus\Tartarus;

use Closure;

trait Configuration
{
    /**
     * the resources navigation group
     */
    protected Closure | string $navigationGroupLabel = 'Tartarus';

    protected array $tartarusModels = [
        //'Notification' => \LaraZeus\Tartarus\Models\Notification::class,
    ];

    public function navigationGroupLabel(Closure | string $label): static
    {
        $this->navigationGroupLabel = $label;

        return $this;
    }

    public function getNavigationGroupLabel(): Closure | string
    {
        return $this->evaluate($this->navigationGroupLabel);
    }

    public function tartarusModels(array $models): static
    {
        $this->tartarusModels = $models;

        return $this;
    }

    public function getTartarusModels(): array
    {
        return $this->tartarusModels;
    }

    public static function getModel(string $model): string
    {
        return (new static())::get()->getTartarusModels()[$model];
    }
}
