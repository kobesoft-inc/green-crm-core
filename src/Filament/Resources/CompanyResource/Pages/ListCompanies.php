<?php

namespace Green\CrmCore\Filament\Resources\CompanyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Green\CrmCore\Filament\Actions\CreateCompanyAction;
use Green\CrmCore\Filament\Resources\CompanyResource;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateCompanyAction::make()
                ->label(__('green-crm-core::company.actions.create'))
                ->modalHeading(__('green-crm-core::company.actions.create'))
                ->modalWidth('md')
                ->successRedirectUrl(fn ($record) => CompanyResource::getUrl('view', ['record' => $record])),
        ];
    }
}
