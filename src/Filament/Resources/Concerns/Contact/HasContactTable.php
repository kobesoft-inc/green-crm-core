<?php

namespace Green\CrmCore\Filament\Resources\Concerns\Contact;

use Filament\Tables;
use Green\CrmCore\Enums\RelationshipType;

trait HasContactTable
{
    /**
     * 連絡先テーブルのカラム定義を取得
     *
     * @return array テーブルカラムの配列
     */
    protected static function getTableColumns(): array
    {
        return [
            static::getFullNameColumn(),
            static::getFullNameKanaColumn(),
            static::getCompanyNameColumn(),
            static::getTitleColumn(),
            static::getPrimaryEmailColumn(),
            static::getPrimaryPhoneColumn(),
            static::getPrimaryAddressColumn(),
            static::getBirthdateColumn(),
            static::getGenderColumn(),
            static::getRelationshipTypesColumn(),
            static::getCreatedAtColumn(),
            static::getUpdatedAtColumn(),
        ];
    }

    /**
     * 氏名カラムを取得
     *
     * @return Tables\Columns\TextColumn 氏名のテキストカラムコンポーネント
     */
    protected static function getFullNameColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('full_name')
            ->label(__('green-crm-core::contact.fields.full_name'))
            ->searchable(['family_name', 'given_name'])
            ->sortable(['family_name', 'given_name']);
    }

    /**
     * 氏名（ふりがな）カラムを取得
     *
     * @return Tables\Columns\TextColumn 氏名（ふりがな）のテキストカラムコンポーネント
     */
    protected static function getFullNameKanaColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('full_name_kana')
            ->label(__('green-crm-core::contact.fields.full_name_kana'))
            ->searchable(['family_name_kana', 'given_name_kana'])
            ->toggleable();
    }

    /**
     * 会社名カラムを取得
     *
     * @return Tables\Columns\TextColumn 会社名のテキストカラムコンポーネント
     */
    protected static function getCompanyNameColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('company_name')
            ->label(__('green-crm-core::contact.fields.company_name'))
            ->searchable()
            ->toggleable();
    }

    /**
     * 役職カラムを取得
     *
     * @return Tables\Columns\TextColumn 役職のテキストカラムコンポーネント
     */
    protected static function getTitleColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('title')
            ->label(__('green-crm-core::contact.fields.title'))
            ->searchable()
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
            ->label(__('green-crm-core::contact.fields.relationship_types'))
            ->badge()
            ->formatStateUsing(fn ($state) => collect($state)->map(fn ($type) => RelationshipType::from($type)->label())->join(', '));
    }

    /**
     * メインメールアドレスカラムを取得
     *
     * @return Tables\Columns\TextColumn メインメールアドレスのテキストカラムコンポーネント
     */
    protected static function getPrimaryEmailColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('emails.email')
            ->label(__('green-crm-core::contact.fields.primary_email'))
            ->getStateUsing(function ($record) {
                return $record->emails()->where('is_primary', true)->first()?->email ?? 
                       $record->emails()->first()?->email;
            })
            ->searchable()
            ->copyable()
            ->toggleable();
    }

    /**
     * メイン電話番号カラムを取得
     *
     * @return Tables\Columns\TextColumn メイン電話番号のテキストカラムコンポーネント
     */
    protected static function getPrimaryPhoneColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('phones.phone')
            ->label(__('green-crm-core::contact.fields.primary_phone'))
            ->getStateUsing(function ($record) {
                return $record->phones()->where('is_primary', true)->first()?->phone ?? 
                       $record->phones()->first()?->phone;
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
            ->label(__('green-crm-core::contact.fields.primary_address'))
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
     * 誕生日カラムを取得
     *
     * @return Tables\Columns\TextColumn 誕生日のテキストカラムコンポーネント
     */
    protected static function getBirthdateColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('birthdate')
            ->label(__('green-crm-core::contact.fields.birthdate'))
            ->date('Y-m-d')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * 性別カラムを取得
     *
     * @return Tables\Columns\TextColumn 性別のテキストカラムコンポーネント
     */
    protected static function getGenderColumn(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('gender')
            ->label(__('green-crm-core::contact.fields.gender'))
            ->formatStateUsing(fn ($state) => $state ? __("green-crm-core::contact.gender.{$state}") : '')
            ->badge()
            ->color(fn ($state) => match($state) {
                'male' => 'blue',
                'female' => 'pink',
                'other' => 'gray',
                default => 'gray',
            })
            ->toggleable(isToggledHiddenByDefault: true);
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
     * 連絡先テーブルのフィルター定義を取得
     *
     * @return array テーブルフィルターの配列
     */
    protected static function getTableFilters(): array
    {
        return [
            static::getRelationshipTypesFilter(),
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
            ->label(__('green-crm-core::contact.filters.relationship_types'))
            ->multiple()
            ->options(RelationshipType::labels());
    }

    /**
     * 連絡先テーブルの行アクション定義を取得
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
     * 連絡先テーブルの一括アクション定義を取得
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
