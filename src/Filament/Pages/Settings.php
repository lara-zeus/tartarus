<?php

namespace LaraZeus\Tartarus\Filament\Pages;

use App\Filament\Schemata\Company\SettingsForm;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

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
                CuratorPicker::make('logo')
                    ->directory(fn ($record) => $record->id . '/logos')
                    ->label(fn () => __(static::langFile() . '.logo'))
                    ->buttonLabel(fn () => __(static::langFile() . '.select_logo'))
                    ->columnSpanFull(),
            ]);
    }

    public static function getLabel(): string
    {
        return __('Company Settings');
    }
}
