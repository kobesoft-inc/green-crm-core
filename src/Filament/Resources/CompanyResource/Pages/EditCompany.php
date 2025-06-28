<?php

namespace Green\CrmCore\Filament\Resources\CompanyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Green\CrmCore\Filament\Resources\CompanyResource;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSubNavigationItems(): array
    {
        return [
            [
                'title' => __('green-crm-core::company.sections.basic_info'),
                'url' => $this->getUrl(),
                'icon' => 'heroicon-o-information-circle',
                'isActive' => request()->routeIs('filament.admin.resources.companies.edit'),
            ],
            [
                'title' => __('green-crm-core::company.sections.contacts'),
                'url' => $this->getUrl().'#contacts',
                'icon' => 'heroicon-o-users',
                'badge' => $this->record->contacts()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::company.sections.branches'),
                'url' => $this->getUrl().'#branches',
                'icon' => 'heroicon-o-building-office-2',
                'badge' => $this->record->branches()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::company.sections.emails'),
                'url' => $this->getUrl().'#emails',
                'icon' => 'heroicon-o-envelope',
                'badge' => $this->record->emails()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::company.sections.phones'),
                'url' => $this->getUrl().'#phones',
                'icon' => 'heroicon-o-phone',
                'badge' => $this->record->phones()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::company.sections.addresses'),
                'url' => $this->getUrl().'#addresses',
                'icon' => 'heroicon-o-map-pin',
                'badge' => $this->record->addresses()->count(),
                'isActive' => false,
            ],
        ];
    }
}
