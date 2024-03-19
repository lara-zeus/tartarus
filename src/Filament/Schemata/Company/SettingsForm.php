<?php

namespace LaraZeus\Tartarus\Filament\Schemata\Company;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use LaraZeus\Chaos\Forms\Components\MultiLang;

class SettingsForm
{
    public static function mainSetting(): array
    {
        return [
            Section::make()
                ->schema([
                    MultiLang::make('name')
                        ->live()
                        ->label(__('Company Name')),
                    TextInput::make('subdomain')
                        ->live()
                        ->extraAttributes(['style' => 'direction: ltr;'])
                        ->prefixIcon('tabler-link')
                        ->label(__('Slug')),
                    ViewField::make('primary_color')
                        ->live()
                        ->view('zeus-tartarus::fields.color-picker'),
                ]),
        ];
    }
}
