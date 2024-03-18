<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\Chaos\Filament\ChaosResource;
use LaraZeus\Chaos\Filament\ChaosResource\ChaosForms;
use LaraZeus\Chaos\Filament\ChaosResource\ChaosTables;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource\Pages;
use LaraZeus\Tartarus\Models\Company;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class CompanyResource extends ChaosResource
{
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $model = Company::class;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return ChaosForms::make($form, [
            Section::make()
                ->columns()
                ->schema([
                    Select::make('user_id')
                        ->label(__('owner'))
                        ->relationship('owner', 'name')
                        ->required(),
                    TextInput::make('name')
                        ->label(__('Company Name')),
                    TextInput::make('subdomain')
                        ->label(__('Subdomain'))
                        ->maxLength(20),
                    // todo
                    /*CuratorPicker::make('logo')
                        ->directory(fn ($record) => $record->id . '/logos')
                        ->label(fn () => static::langFile() . '.logo')
                        ->buttonLabel(fn () => static::langFile() . '.select_logo')
                        ->columnSpanFull(),*/
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ChaosTables::make(
            static::class,
            $table,
            [
                TextColumn::make('name')
                    ->icon(fn (Company $record) => $record->getFilamentAvatarUrl())
                    ->description(fn (Company $record) => $record->subdomain)
                    ->label(__('Company'))
                    ->searchable(),
                TextColumn::make('owner.name')
                    /** @phpstan-ignore-next-line */
                    ->icon(fn (Company $record) => asset($record->owner->avatar))
                    /** @phpstan-ignore-next-line */
                    ->description(fn (Company $record) => $record->owner->email)
                    ->label(__('owner'))
                    ->sortable(),
            ],
            actions: [
                Impersonate::make()
                    ->grouped()
                    ->action(fn (
                        Impersonate $action,
                        Company $record
                    ) => $action->impersonate($record->owner)),
            ]
        );
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditCompany::class,
            Pages\CompanySettings::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
            'settings' => Pages\CompanySettings::route('/{record}/settings'),
        ];
    }
}
