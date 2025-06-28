<?php

namespace Green\CrmCore\Filament\Resources\CompanyResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Green\CrmCore\Enums\RelationshipType;
use Green\CrmCore\Filament\Resources\CompanyResource;

class ViewCompany extends ViewRecord
{
    protected static string $resource = CompanyResource::class;

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
                Infolists\Components\Section::make(__('green-crm-core::company.sections.basic_info'))
                    ->schema([
                        Infolists\Components\TextEntry::make('company_name')
                            ->label(__('green-crm-core::company.fields.company_name')),
                        Infolists\Components\TextEntry::make('formatted_corporate_number')
                            ->label(__('green-crm-core::company.fields.corporate_number')),
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('capital')
                                    ->label(__('green-crm-core::company.fields.capital'))
                                    ->money('JPY'),
                                Infolists\Components\TextEntry::make('annual_revenue')
                                    ->label(__('green-crm-core::company.fields.annual_revenue'))
                                    ->money('JPY'),
                            ]),
                        Infolists\Components\TextEntry::make('industry')
                            ->label(__('green-crm-core::company.fields.industry')),
                        Infolists\Components\TextEntry::make('employee_count')
                            ->label(__('green-crm-core::company.fields.employee_count'))
                            ->numeric(),
                        Infolists\Components\TextEntry::make('relationship_types')
                            ->label(__('green-crm-core::company.fields.relationship_types'))
                            ->badge()
                            ->formatStateUsing(fn ($state) => collect($state)->map(fn ($type) => RelationshipType::from($type)->label())->toArray()),
                        Infolists\Components\TextEntry::make('description')
                            ->label(__('green-crm-core::company.fields.description'))
                            ->columnSpanFull(),
                    ]),
                Infolists\Components\Section::make(__('green-crm-core::company.sections.representative'))
                    ->schema([
                        Infolists\Components\TextEntry::make('representative_with_title')
                            ->label(__('green-crm-core::company.fields.representative')),
                        Infolists\Components\TextEntry::make('representative_full_name_kana')
                            ->label(__('green-crm-core::company.fields.representative_kana')),
                    ])
                    ->visible(fn ($record) => $record->representative_full_name),
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
                'title' => __('green-crm-core::company.sections.basic_info'),
                'url' => $this->getUrl(),
                'icon' => 'heroicon-o-information-circle',
                'isActive' => request()->routeIs('filament.admin.resources.companies.view'),
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
