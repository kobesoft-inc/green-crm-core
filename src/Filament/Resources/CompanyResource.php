<?php

namespace Green\CrmCore\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Green\CrmCore\Filament\Resources\CompanyResource\Pages;
use Green\CrmCore\Filament\Resources\CompanyResource\RelationManagers;
use Green\CrmCore\Filament\Resources\Concerns\Company\HasCompanyForm;
use Green\CrmCore\Filament\Resources\Concerns\Company\HasCompanyTable;
use Green\CrmCore\Models\Company;

class CompanyResource extends Resource
{
    use HasCompanyForm, HasCompanyTable;

    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('green-crm-core::company.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('green-crm-core::company.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getBasicInfoSection(),
                static::getRepresentativeSection(),
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
            RelationManagers\ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
