<?php

namespace LaraZeus\Tartarus;

trait Configuration
{
    protected array $tartarusModels = [
        'Company' => \LaraZeus\Tartarus\Models\Company::class,
        'TagType' => \LaraZeus\Tartarus\Enums\TagTypes::class,
    ];

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
        return (new static)::get()->getTartarusModels()[$model];
    }
}
