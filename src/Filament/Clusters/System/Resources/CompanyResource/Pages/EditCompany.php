<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource\Pages;

use Filament\Actions;
use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosEditRecord;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource;

class EditCompany extends ChaosEditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
