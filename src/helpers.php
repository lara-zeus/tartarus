<?php

use Filament\Facades\Filament;

if (! function_exists('tenant')) {
    function tenant(?string $key = null): ?LaraZeus\Tartarus\Models\Company
    {
        /**
         * @var \LaraZeus\Tartarus\Models\Company $getTenant
         */
        $getTenant = Filament::getTenant();

        if ($getTenant !== null && $key !== null) {
            return $getTenant->getAttribute($key);
        }

        return $getTenant;
    }
}
