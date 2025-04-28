<?php

namespace LaraZeus\Tartarus\Filament\Schemata\Company;

use Awcodes\PresetColorPicker\PresetColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
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
                        ->label(__('Primary Color'))
                        ->colors(
                            collect(FilamentColor::getColors())
                                ->forget(['primary', 'secondary', 'warning', 'info', 'danger', 'success', 'slate', 'zinc', 'neutral', 'stone'])
                                ->toArray()
                        ),
                ]),
        ];
    }
}
