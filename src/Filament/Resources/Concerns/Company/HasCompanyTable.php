<?php

namespace Green\CrmCore\Filament\Resources\Concerns\Company;

use Filament\Tables;
use Green\CrmCore\Enums\RelationshipType;

trait HasCompanyTable
{
    /**
     * 会社テーブルのカラム定義を取得
     *
     * @return array テーブルカラムの配列
     */
    protected static function getTableColumns(): array
    {
        return [
            static::getCompanyNameColumn(),
            static::getCorporateNumberColumn(),
            static::getEstablishedDateColumn(),
            static::getIndustryColumn(),
            static::getEmployeeCountColumn(),
            static::getCapitalColumn(),
            static::getAnnualRevenueColumn(),
            static::getPrimaryDomainColumn(),
            static::getPrimaryEmailColumn(),
            static::getPrimaryAddressColumn(),
            static::getRepresentativeColumn(),
            static::getRelationshipTypesColumn(),
            static::getContactsCountColumn(),
            static::getCreatedAtColumn(),
            static::getUpdatedAtColumn(),
        ];
    }

    /**
     * 会社名カラムを取得
     *
     * @return Tables\Columns\TextColumn 会社名のテキストカラムコンポーネント
     */
    protected static function getCompanyNameColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('company_name')
            ->label(__('green-crm-core::company.fields.company_name'))
            ->searchable()
            ->sortable();
    }

    /**
     * 法人番号カラムを取得
     *
     * @return Tables\Columns\TextColumn 法人番号のテキストカラムコンポーネント
     */
    protected static function getCorporateNumberColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('corporate_number')
            ->label(__('green-crm-core::company.fields.corporate_number'))
            ->searchable()
            ->toggleable();
    }

    /**
     * 業界カラムを取得
     *
     * @return Tables\Columns\TextColumn 業界のテキストカラムコンポーネント
     */
    protected static function getIndustryColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('industry')
            ->label(__('green-crm-core::company.fields.industry'))
            ->searchable()
            ->toggleable();
    }

    /**
     * 従業員数カラムを取得
     *
     * @return Tables\Columns\TextColumn 従業員数のテキストカラムコンポーネント
     */
    protected static function getEmployeeCountColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('employee_count')
            ->label(__('green-crm-core::company.fields.employee_count'))
            ->numeric()
            ->sortable()
            ->toggleable();
    }

    /**
     * 資本金カラムを取得
     *
     * @return Tables\Columns\TextColumn 資本金のテキストカラムコンポーネント
     */
    protected static function getCapitalColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('capital')
            ->label(__('green-crm-core::company.fields.capital'))
            ->money('JPY')
            ->sortable()
            ->toggleable();
    }

    /**
     * 関係性カラムを取得
     *
     * @return Tables\Columns\TextColumn 関係性のテキストカラムコンポーネント
     */
    protected static function getRelationshipTypesColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('relationship_types')
            ->label(__('green-crm-core::company.fields.relationship_types'))
            ->badge()
            ->formatStateUsing(fn ($state) => collect($state)->map(fn ($type) => RelationshipType::from($type)->label())->join(', '));
    }

    /**
     * 連絡先数カラムを取得
     *
     * @return Tables\Columns\TextColumn 連絡先数のテキストカラムコンポーネント
     */
    protected static function getContactsCountColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('contacts_count')
            ->label(__('green-crm-core::company.fields.contacts_count'))
            ->counts('contacts')
            ->sortable();
    }

    /**
     * 設立日カラムを取得
     *
     * @return Tables\Columns\TextColumn 設立日のテキストカラムコンポーネント
     */
    protected static function getEstablishedDateColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('established_date')
            ->label(__('green-crm-core::company.fields.established_date'))
            ->date('Y-m-d')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * 年商カラムを取得
     *
     * @return Tables\Columns\TextColumn 年商のテキストカラムコンポーネント
     */
    protected static function getAnnualRevenueColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('annual_revenue')
            ->label(__('green-crm-core::company.fields.annual_revenue'))
            ->money('JPY')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * メインドメインカラムを取得
     *
     * @return Tables\Columns\TextColumn メインドメインのテキストカラムコンポーネント
     */
    protected static function getPrimaryDomainColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('domains.domain')
            ->label(__('green-crm-core::company.fields.domain'))
            ->getStateUsing(function ($record) {
                return $record->domains()->where('is_primary', true)->first()?->domain ?? 
                       $record->domains()->first()?->domain;
            })
            ->searchable()
            ->copyable()
            ->url(function ($record) {
                $domain = $record->domains()->where('is_primary', true)->first()?->domain ?? 
                         $record->domains()->first()?->domain;
                return $domain ? "https://{$domain}" : null;
            })
            ->openUrlInNewTab()
            ->toggleable();
    }

    /**
     * メインメールアドレスカラムを取得
     *
     * @return Tables\Columns\TextColumn メインメールアドレスのテキストカラムコンポーネント
     */
    protected static function getPrimaryEmailColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('emails.email')
            ->label(__('green-crm-core::company.fields.email_address'))
            ->getStateUsing(function ($record) {
                return $record->emails()->where('is_primary', true)->first()?->email ?? 
                       $record->emails()->first()?->email;
            })
            ->searchable()
            ->copyable()
            ->toggleable();
    }

    /**
     * メイン住所カラムを取得
     *
     * @return Tables\Columns\TextColumn メイン住所のテキストカラムコンポーネント
     */
    protected static function getPrimaryAddressColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('addresses.full_address')
            ->label(__('green-crm-core::company.fields.address'))
            ->getStateUsing(function ($record) {
                $address = $record->addresses()->where('is_primary', true)->first() ?? 
                          $record->addresses()->first();
                return $address ? $address->full_address : null;
            })
            ->limit(50)
            ->tooltip(function ($record) {
                $address = $record->addresses()->where('is_primary', true)->first() ?? 
                          $record->addresses()->first();
                return $address ? $address->full_address : null;
            })
            ->toggleable();
    }

    /**
     * 代表者カラムを取得
     *
     * @return Tables\Columns\TextColumn 代表者のテキストカラムコンポーネント
     */
    protected static function getRepresentativeColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('representative_with_title')
            ->label(__('green-crm-core::company.fields.representative'))
            ->searchable(['representative_family_name', 'representative_given_name'])
            ->toggleable();
    }

    /**
     * 作成日時カラムを取得
     *
     * @return Tables\Columns\TextColumn 作成日時のテキストカラムコンポーネント
     */
    protected static function getCreatedAtColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('created_at')
            ->label(__('green-crm-core::common.fields.created_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * 更新日時カラムを取得
     *
     * @return Tables\Columns\TextColumn 更新日時のテキストカラムコンポーネント
     */
    protected static function getUpdatedAtColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('updated_at')
            ->label(__('green-crm-core::common.fields.updated_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * 会社テーブルのフィルター定義を取得
     *
     * @return array テーブルフィルターの配列
     */
    protected static function getTableFilters(): array
    {
        return [
            static::getRelationshipTypesFilter(),
            static::getIndustryFilter(),
        ];
    }

    /**
     * 関係性フィルターを取得
     *
     * @return Tables\Filters\SelectFilter 関係性の選択フィルターコンポーネント
     */
    protected static function getRelationshipTypesFilter(): Tables\Filters\SelectFilter
    {
        return Tables\Filters\SelectFilter::make('relationship_types')
            ->label(__('green-crm-core::company.filters.relationship_types'))
            ->multiple()
            ->options(RelationshipType::labels());
    }

    /**
     * 業界フィルターを取得
     *
     * @return Tables\Filters\SelectFilter 業界の選択フィルターコンポーネント
     */
    protected static function getIndustryFilter(): Tables\Filters\SelectFilter
    {
        return Tables\Filters\SelectFilter::make('industry')
            ->label(__('green-crm-core::company.filters.industry'))
            ->searchable()
            ->preload();
    }

    /**
     * 会社テーブルの行アクション定義を取得
     *
     * @return array テーブル行アクションの配列
     */
    protected static function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ];
    }

    /**
     * 会社テーブルの一括アクション定義を取得
     *
     * @return array テーブル一括アクションの配列
     */
    protected static function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
}
