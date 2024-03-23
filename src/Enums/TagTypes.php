<?php

namespace LaraZeus\Tartarus\Enums;

use Filament\Support\Contracts\HasLabel;

enum TagTypes: string implements HasLabel
{
    case TestType = 'Tag';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
