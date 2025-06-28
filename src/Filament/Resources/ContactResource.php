<?php

namespace Green\CrmCore\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Green\CrmCore\Filament\Resources\Concerns\Contact\HasContactForm;
use Green\CrmCore\Filament\Resources\Concerns\Contact\HasContactTable;
use Green\CrmCore\Filament\Resources\ContactResource\Pages;
use Green\CrmCore\Models\Contact;

class ContactResource extends Resource
{
    use HasContactForm, HasContactTable;

    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('green-crm-core::contact.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('green-crm-core::contact.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                static::getBasicInfoSection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->filters(static::getTableFilters())
            ->actions(static::getTableActions())
            ->bulkActions(static::getTableBulkActions())
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
