<?php

namespace Green\CrmCore\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('family_name')
                            ->label(__('green-crm-core::contact.fields.family_name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('given_name')
                            ->label(__('green-crm-core::contact.fields.given_name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('family_name_kana')
                            ->label(__('green-crm-core::contact.fields.family_name_kana'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('given_name_kana')
                            ->label(__('green-crm-core::contact.fields.given_name_kana'))
                            ->maxLength(255),
                    ]),
                Forms\Components\TextInput::make('title')
                    ->label(__('green-crm-core::contact.fields.title'))
                    ->maxLength(255),
                Forms\Components\Section::make(__('green-crm-core::contact.sections.position_info'))
                    ->schema([
                        Forms\Components\TextInput::make('position')
                            ->label(__('green-crm-core::contact.fields.position'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('department')
                            ->label(__('green-crm-core::contact.fields.department'))
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('green-crm-core::contact.fields.full_name'))
                    ->searchable(['family_name', 'given_name']),
                Tables\Columns\TextColumn::make('full_name_kana')
                    ->label(__('green-crm-core::contact.fields.full_name_kana'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('position')
                    ->label(__('green-crm-core::contact.fields.position'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->label(__('green-crm-core::contact.fields.department'))
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emails.email')
                    ->label(__('green-crm-core::contact.fields.primary_email'))
                    ->getStateUsing(fn ($record) => $record->emails()->where('is_primary', true)->first()?->email)
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phones.number')
                    ->label(__('green-crm-core::contact.fields.primary_phone'))
                    ->getStateUsing(fn ($record) => $record->phones()->where('is_primary', true)->first()?->number)
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $pivotData = [];
                        if (isset($data['position'])) {
                            $pivotData['position'] = $data['position'];
                            unset($data['position']);
                        }
                        if (isset($data['department'])) {
                            $pivotData['department'] = $data['department'];
                            unset($data['department']);
                        }

                        return array_merge($data, ['pivot' => $pivotData]);
                    }),
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('position')
                            ->label(__('green-crm-core::contact.fields.position'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('department')
                            ->label(__('green-crm-core::contact.fields.department'))
                            ->maxLength(255),
                    ])
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data, $record): array {
                        $pivot = $record->pivot;
                        if ($pivot) {
                            $data['position'] = $pivot->position;
                            $data['department'] = $pivot->department;
                        }

                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $pivotData = [];
                        if (isset($data['position'])) {
                            $pivotData['position'] = $data['position'];
                            unset($data['position']);
                        }
                        if (isset($data['department'])) {
                            $pivotData['department'] = $data['department'];
                            unset($data['department']);
                        }

                        return array_merge($data, ['pivot' => $pivotData]);
                    }),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
