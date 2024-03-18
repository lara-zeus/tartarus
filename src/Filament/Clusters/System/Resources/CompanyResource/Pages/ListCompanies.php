<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource\Pages;

use Filament\Actions;
use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosListRecords;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource;

class ListCompanies extends ChaosListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
