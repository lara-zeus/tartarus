<?php

namespace LaraZeus\Tartarus\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaraZeus\Chaos\Filament\ChaosResource\ChaosForms;
use LaraZeus\Tartarus\TartarusPlugin;

class RegisterCompany extends RegisterTenant
{
    public ?array $data = [];

    public ?Model $tenant = null;

    protected static ?string $slug = 'create-my-new-team';

    protected static string $view = 'zeus-tartarus::company.pages.create_company';

    public static function getLabel(): string
    {
        return __('Create New Company');
    }

    public function form(Schema $schema): Schema
    {
        return ChaosForms::make($schema, [
            Grid::make()
                ->columnSpanFull()
                ->columns(1)
                ->schema([
                    TextInput::make('name')
                        ->label(__('Company Name'))
                        ->helperText(__('Company Name desc'))
                        ->autofocus()
                        ->maxLength(255)
                        ->required(),
                ]),
        ])
            ->model(TartarusPlugin::getModel('Company'))
            ->statePath('data');
    }

    protected function handleRegistration(array $data): Model
    {
        $user = Auth::user();
        $newData = $this->form->getState();

        /** @phpstan-ignore-next-line */
        $company = $user?->ownedCompanies()->create([
            'name' => $newData['name'],
            'subdomain' => str($newData['name'])->slug(),
        ]);

        session()->put('company', $company);

        /** @phpstan-ignore-next-line */
        $user?->switchCompany($company);

        $name = $newData['name'];

        Notification::make()
            ->title(__('Company Created'))
            ->success()
            ->body(str(__('Company Created Successfully', compact('name')))->inlineMarkdown())
            ->send();

        return $company;
    }
}
