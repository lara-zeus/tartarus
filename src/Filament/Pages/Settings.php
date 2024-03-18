<?php

namespace LaraZeus\Tartarus\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use LaraZeus\Tartarus\Filament\Schemata\Company\SettingsForm;

class Settings extends EditTenantProfile
{
    public static function langFile(): string
    {
        return 'companies';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...SettingsForm::mainSetting(),
                // todo
                /*CuratorPicker::make('logo')
                    ->directory(fn ($record) => $record->id . '/logos')
                    ->label(fn () => __(static::langFile() . '.logo'))
                    ->buttonLabel(fn () => __(static::langFile() . '.select_logo'))
                    ->columnSpanFull(),*/
            ]);
    }

    public static function getLabel(): string
    {
        return __('Company Settings');
    }
}
