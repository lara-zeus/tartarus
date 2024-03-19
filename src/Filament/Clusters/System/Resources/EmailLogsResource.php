<?php

namespace LaraZeus\Tartarus\Filament\Clusters\System\Resources;

use Exception;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use LaraZeus\Chaos\Filament\ChaosResource;
use LaraZeus\Tartarus\Filament\Clusters\System;
use LaraZeus\Tartarus\Filament\Clusters\System\Resources\EmailLogsResource\Pages;
use RickDBCN\FilamentEmail\Mail\ResendMail;
use RickDBCN\FilamentEmail\Models\Email;

class EmailLogsResource extends ChaosResource
{
    protected static ?string $cluster = System::class;

    public static function getModel(): string
    {
        return config('filament-email.resource.model');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Envelope')
                    ->hiddenLabel()
                    ->schema([
                        TextInput::make('from')
                            ->label(__('From')),
                        Textinput::make('to')
                            ->label(__('To')),
                        TextInput::make('cc')
                            ->label(__('CC')),
                        TextInput::make('subject')
                            ->label(__('Subject'))
                            ->columnSpan(2),
                        TextInput::make('created_at')
                            ->label(__('Created at')),
                    ])->columns(3),
                Tabs::make('Content')->tabs([
                    Tabs\Tab::make('HTML')
                        ->schema([
                            ViewField::make('html_body')
                                ->view('filament-email::filament-email.emails.html')
                                ->view('filament-email::HtmlEmailView'),
                        ]),
                    Tabs\Tab::make('Text')
                        ->schema([
                            Textarea::make('text_body')->rows(20),
                        ]),
                    Tabs\Tab::make('Raw')
                        ->schema([
                            Textarea::make('raw_body')->rows(20),
                        ]),
                    Tabs\Tab::make('Debug info')
                        ->schema([
                            Textarea::make('sent_debug_info')->rows(20),
                        ]),
                ])->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort(
                config('filament-email.resource.default_sort_column'),
                config('filament-email.resource.default_sort_direction')
            )
            ->actions([
                Action::make('preview')
                    ->label(__('Preview'))
                    ->icon('heroicon-m-eye')
                    ->extraAttributes(['style' => 'h-41'])
                    ->modalFooterActions(
                        fn ($action): array => [
                            $action->getModalCancelAction(),
                        ]
                    )
                    ->fillForm(function (Email $record) {
                        $body = $record->html_body;

                        return [
                            'html_body' => $body,
                        ];
                    })
                    ->form([
                        ViewField::make('html_body')->hiddenLabel()
                            ->view('filament-email::filament-email.emails.html')->view('filament-email::HtmlEmailView'),
                    ]),
                Action::make('resend')
                    ->label(__('Send again'))
                    ->icon('heroicon-o-envelope')
                    ->requiresConfirmation()
                    ->action(function (Email $record) {
                        try {
                            Mail::to($record->to)
                                ->cc($record->cc)
                                ->bcc($record->bcc)
                                ->send(new ResendMail($record));
                            Notification::make()
                                ->title(__('E-mail has been successfully sent'))
                                ->success()
                                ->duration(5000)
                                ->send();
                        } catch (Exception) {
                            Notification::make()
                                ->title(__('Something went wrong'))
                                ->danger()
                                ->duration(5000)
                                ->send();
                        }
                    }),
            ])
            ->columns([
                TextColumn::make('to')
                    ->label(__('To'))
                    ->icon('heroicon-m-envelope')
                    ->description(fn ($record) => $record->subject)
                    ->toggleable()
                    ->searchable(),
                /*TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->icon('heroicon-m-chat-bubble-bottom-center')
                    ->limit(50),*/
                TextColumn::make('from')
                    ->label(__('From'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-m-envelope')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('sent at'))
                    ->toggleable()
                    ->dateTime()
                    ->icon('heroicon-m-calendar')
                    ->sortable(),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmails::route('/'),
            'view' => Pages\ViewEmail::route('/{record}'),
        ];
    }
}
