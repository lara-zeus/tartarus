<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource\Pages;

use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosCreateRecord;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource;

class CreateCompany extends ChaosCreateRecord
{
    protected static string $resource = CompanyResource::class;
}
