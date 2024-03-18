<?php

namespace LaraZeus\Tartarus\Filament\Pages;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaraZeus\Chaos\Filament\ChaosResource\ChaosForms;
use LaraZeus\Tartarus\Models\Company;

class RegisterCompany extends RegisterTenant
{
    public ?array $data = [];

    public ?Model $tenant = null;

    protected static string $view = 'zeus-tartarus::company.pages.create_company';

    public static function getLabel(): string
    {
        return __('Create New Company');
    }

    public function form(Form $form): Form
    {
        return ChaosForms::make($form, [
            Grid::make()->columns(1)->schema([
                TextInput::make('name')
                    ->label(__('Company Name'))
                    ->helperText(__('Company Name desc'))
                    ->autofocus()
                    ->maxLength(255)
                    ->required(),
            ]),
        ])
            ->model(Company::class)
            ->statePath('data');
    }

    protected function handleRegistration(array $data): Model
    {
        $user = Auth::user();
        $data = $this->form->getState();

        /** @phpstan-ignore-next-line */
        $company = $user?->ownedCompanies()->create([
            'name' => $data['name'],
            'subdomain' => str($data['name'])->slug(),
        ]);

        session()->put('company', $company);

        /** @phpstan-ignore-next-line */
        $user?->switchCompany($company);

        $name = $data['name'];

        Notification::make()
            ->title(__('Company Created'))
            ->success()
            ->body(str(__('Company Created Successfully', compact('name')))->inlineMarkdown())
            ->send();

        return $company;
    }
}
