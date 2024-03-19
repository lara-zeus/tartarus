<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource\Pages;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\CompanyResource;
use LaraZeus\Tartarus\Filament\Schemata\Company\SettingsForm;
use LaraZeus\Tartarus\Models\Company;

/**
 * @property mixed $form
 */
class CompanySettings extends Page
{
    use InteractsWithRecord;

    public Model | int | string | null $record;

    public ?array $data = [];

    protected static string $resource = CompanyResource::class;

    protected static string $view = 'zeus-tartarus::company.pages.company-settings';

    public static function langFile(): string
    {
        return 'companies';
    }

    public function mount(int | string $record): void
    {
        /**
         * @var Company $getRecord
         */
        $getRecord = $this->resolveRecord($record);
        $this->form->fill([
            ...$getRecord->toArray(),
            /** @phpstan-ignore-next-line */
            'settings' => $getRecord
                ->settings()
                ->withoutCompany()
                ->pluck('payload', 'name'),
        ]);

        $this->record = $getRecord;
    }

    public function form(Form $form): Form
    {
        return $form
            ->model($this->record)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('main')
                            ->schema([
                                ...SettingsForm::mainSetting(),
                                /*CuratorPicker::make('logo')
                                    ->directory(fn ($record) => $record->id . '/logos')
                                    ->label(fn () => static::langFile() . '.logo')
                                    ->buttonLabel(fn () => static::langFile() . '.select_logo')
                                    ->columnSpanFull(),*/
                            ]),
                        Tabs\Tab::make('settings.country')
                            ->schema([
                                TextInput::make('settings.country')->required(),
                                TextInput::make('settings.state')->required(),
                                TextInput::make('settings.city')->required(),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function saveSettings(): void
    {
        /**
         * @var Company $getRecord
         */
        $getRecord = $this->resolveRecord($this->record);

        /** @phpstan-ignore-next-line */
        $data = collect($this->form->getState());

        $mainData = $data->except('settings')->toArray();

        $getRecord->update($mainData);

        $getRecord->saveCompanySettings($data['settings']);

        Notification::make()
            ->title(__('Saved!'))
            ->body(__('Company Settings Saved successfully'))
            ->success()
            ->send();
    }
}
