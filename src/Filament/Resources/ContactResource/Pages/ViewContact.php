<?php

namespace Green\CrmCore\Filament\Resources\ContactResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Green\CrmCore\Enums\RelationshipType;
use Green\CrmCore\Filament\Resources\ContactResource;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('green-crm-core::contact.sections.basic_info'))
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('family_name')
                                    ->label(__('green-crm-core::contact.fields.family_name')),
                                Infolists\Components\TextEntry::make('given_name')
                                    ->label(__('green-crm-core::contact.fields.given_name')),
                                Infolists\Components\TextEntry::make('family_name_kana')
                                    ->label(__('green-crm-core::contact.fields.family_name_kana')),
                                Infolists\Components\TextEntry::make('given_name_kana')
                                    ->label(__('green-crm-core::contact.fields.given_name_kana')),
                            ]),
                        Infolists\Components\TextEntry::make('title')
                            ->label(__('green-crm-core::contact.fields.title')),
                        Infolists\Components\TextEntry::make('company_name')
                            ->label(__('green-crm-core::contact.fields.company_name')),
                        Infolists\Components\TextEntry::make('relationship_types')
                            ->label(__('green-crm-core::contact.fields.relationship_types'))
                            ->badge()
                            ->formatStateUsing(fn ($state) => collect($state)->map(fn ($type) => RelationshipType::from($type)->label())->toArray()),
                        Infolists\Components\TextEntry::make('notes')
                            ->label(__('green-crm-core::contact.fields.notes'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    protected function getSubNavigationItems(): array
    {
        return [
            [
                'title' => __('green-crm-core::contact.sections.basic_info'),
                'url' => $this->getUrl(),
                'icon' => 'heroicon-o-user',
                'isActive' => request()->routeIs('filament.admin.resources.contacts.view'),
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
