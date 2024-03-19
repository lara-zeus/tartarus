<?php

namespace LaraZeus\Tartarus\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Tartarus\Filament\Clusters\System;
use LaraZeus\Tartarus\Models\SoftDelete;

class Deleter extends Page implements HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $cluster = System::class;

    protected static ?int $navigationSort = 99;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'zeus-tartarus::pages.deleter';

    public static function langFile(): string
    {
        return 'deleter';
    }

    public function getTitle(): string | Htmlable
    {
        return __(static::langFile() . '.title');
    }

    public static function getNavigationLabel(): string
    {
        return __(static::langFile() . '.title');
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('table_count', 'desc')
            ->query(SoftDelete::query())
            ->columns([
                TextColumn::make('table_name'),
                TextColumn::make('table_count')
                    ->color(fn ($record) => ($record->table_count === null) ? 'gray' : 'danger')
                    ->default('not supported'),
            ])
            ->filters([
                Filter::make('created_before')
                    ->form([
                        DatePicker::make('created_before')->default(today()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query;
                    }),
            ])
            ->actions([
                Action::make('empty')
                    ->label(__(static::langFile() . '.delete'))
                    ->requiresConfirmation()
                    ->button()
                    ->size('sm')
                    ->action(function (SoftDelete $record) {
                        $endDate = $this->tableFilters['created_before']['created_before'] ?? '2019-01-01';
                        (new SoftDelete)->clean($record->table_name, $endDate);

                        Notification::make()
                            ->title('the table emptied successfully')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
