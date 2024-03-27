<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource\Pages;

use Filament\Actions;
use LaraZeus\Chaos\Filament\ChaosResource\Pages\ChaosEditRecord;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource;

class EditCompany extends ChaosEditRecord
{
    protected static string $resource = CompanyResource::class;

    public static function getNavigationLabel(): string
    {
        return __('zeus-tartarus::tartarus.edit_company_label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
