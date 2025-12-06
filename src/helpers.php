<?php

use Filament\Facades\Filament;
use LaraZeus\Tartarus\Models\Company;

if (! function_exists('tenant')) {
    function tenant(?string $key = null): mixed
    {
        /**
         * @var Company $getTenant
         */
        $getTenant = Filament::getTenant() ?? session('company') ?? null;

        if ($getTenant !== null && $key !== null) {
            return $getTenant->getAttribute($key);
        }

        return $getTenant;
    }
}
