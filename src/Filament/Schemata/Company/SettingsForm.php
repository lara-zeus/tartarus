<?php

namespace LaraZeus\Tartarus\Filament\Schemata\Company;

use Awcodes\PresetColorPicker\PresetColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Support\Facades\FilamentColor;
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

                    PresetColorPicker::make('primary_color')
                        ->colors(
                            collect(FilamentColor::getColors())
                                ->forget(['secondary', 'slate', 'zinc', 'neutral', 'stone'])
                                ->toArray()
                        ),
                ]),
        ];
    }
}
