<?php

namespace Green\CrmCore\Filament\Resources\ContactResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Green\CrmCore\Filament\Resources\ContactResource;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

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
                'title' => __('green-crm-core::contact.sections.basic_info'),
                'url' => $this->getUrl(),
                'icon' => 'heroicon-o-user',
                'isActive' => request()->routeIs('filament.admin.resources.contacts.edit'),
            ],
            [
                'title' => __('green-crm-core::contact.sections.companies'),
                'url' => $this->getUrl().'#companies',
                'icon' => 'heroicon-o-building-office',
                'badge' => $this->record->companies()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::contact.sections.emails'),
                'url' => $this->getUrl().'#emails',
                'icon' => 'heroicon-o-envelope',
                'badge' => $this->record->emails()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::contact.sections.phones'),
                'url' => $this->getUrl().'#phones',
                'icon' => 'heroicon-o-phone',
                'badge' => $this->record->phones()->count(),
                'isActive' => false,
            ],
            [
                'title' => __('green-crm-core::contact.sections.addresses'),
                'url' => $this->getUrl().'#addresses',
                'icon' => 'heroicon-o-map-pin',
                'badge' => $this->record->addresses()->count(),
                'isActive' => false,
            ],
        ];
    }
}
