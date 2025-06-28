<?php

namespace Green\CrmCore\Filament\Resources\ContactResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Green\CrmCore\Filament\Actions\CreateContactAction;
use Green\CrmCore\Filament\Resources\ContactResource;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateContactAction::make()
                ->label(__('green-crm-core::contact.actions.create'))
                ->modalHeading(__('green-crm-core::contact.actions.create'))
                ->modalWidth('lg')
                ->successRedirectUrl(fn ($record) => ContactResource::getUrl('view', ['record' => $record])),
        ];
    }
}
