<?php

namespace LaraZeus\Tartarus\Enums;

use Filament\Support\Contracts\HasLabel;

enum TagTypes: string implements HasLabel
{
    case TestType = 'Test Type';

    case CustomerCategories = 'Customer Categories';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
