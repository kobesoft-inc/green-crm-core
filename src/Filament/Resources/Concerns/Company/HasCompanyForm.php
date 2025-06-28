<?php

namespace Green\CrmCore\Filament\Resources\Concerns\Company;

use Filament\Forms;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Green\CrmCore\Enums\RelationshipType;

trait HasCompanyForm
{
    /**
     * 会社の基本情報セクションを取得
     *
     * @return Forms\Components\Section 基本情報のセクションコンポーネント
     */
    protected static function getBasicInfoSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make(__('green-crm-core::company.sections.basic_info'))
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make(__('green-crm-core::company.sections.company_basic'))
                                    ->schema([
                                        static::getCompanyNameField(),
                                        static::getDomainsRepeaterField(),
                                        static::getCorporateNumberField(),
                                    ])
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make(__('green-crm-core::company.sections.company_details'))
                                    ->schema([
                                        static::getEstablishedDateField(),
                                        static::getFinancialFields(),
                                        static::getIndustryField(),
                                        static::getEmployeeCountField(),
                                        static::getEmailRepeaterField(),
                                        static::getAddressRepeaterField(),
                                    ])
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make(__('green-crm-core::company.sections.crm_info'))
                                    ->schema([
                                        static::getRelationshipTypesField(),
                                        static::getDescriptionField(),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }

    /**
     * 代表者情報セクションを取得
     *
     * @return Forms\Components\Section 代表者情報のセクションコンポーネント
     */
    protected static function getRepresentativeSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make(__('green-crm-core::company.sections.representative'))
            ->schema([
                static::getRepresentativeTitleField(),
                static::getRepresentativeNameFields(),
            ])
            ->collapsible();
    }

    /**
     * 会社名入力フィールドを取得
     *
     * @return Forms\Components\TextInput 会社名のテキスト入力コンポーネント
     */
    protected static function getCompanyNameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('company_name')
            ->label(__('green-crm-core::company.fields.company_name'))
            ->required()
            ->maxLength(255);
    }

    /**
     * 法人番号入力フィールドを取得
     *
     * @return Forms\Components\TextInput 法人番号のテキスト入力コンポーネント
     */
    protected static function getCorporateNumberField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('corporate_number')
            ->label(__('green-crm-core::company.fields.corporate_number'))
            ->maxLength(13)
            ->mask('9-9999-9999-9999');
    }

    /**
     * 設立日入力フィールドを取得
     *
     * @return Forms\Components\DatePicker 設立日の日付選択コンポーネント
     */
    protected static function getEstablishedDateField(): Forms\Components\DatePicker
    {
        return Forms\Components\DatePicker::make('established_date')
            ->label(__('green-crm-core::company.fields.established_date'))
            ->native(false);
    }

    /**
     * 財務情報フィールドグループを取得
     *
     * @return Forms\Components\Grid 財務情報フィールドのグリッドコンポーネント
     */
    protected static function getFinancialFields(): Forms\Components\Grid
    {
        return Forms\Components\Grid::make(2)
            ->schema([
                static::getCapitalField(),
                static::getAnnualRevenueField(),
            ]);
    }

    /**
     * 資本金入力フィールドを取得
     *
     * @return Forms\Components\TextInput 資本金のテキスト入力コンポーネント
     */
    protected static function getCapitalField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('capital')
            ->label(__('green-crm-core::company.fields.capital'))
            ->numeric()
            ->prefix('¥');
    }

    /**
     * 年商入力フィールドを取得
     *
     * @return Forms\Components\TextInput 年商のテキスト入力コンポーネント
     */
    protected static function getAnnualRevenueField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('annual_revenue')
            ->label(__('green-crm-core::company.fields.annual_revenue'))
            ->numeric()
            ->prefix('¥');
    }

    /**
     * 業界入力フィールドを取得
     *
     * @return Forms\Components\TextInput 業界のテキスト入力コンポーネント
     */
    protected static function getIndustryField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('industry')
            ->label(__('green-crm-core::company.fields.industry'))
            ->maxLength(255);
    }

    /**
     * 従業員数入力フィールドを取得
     *
     * @return Forms\Components\TextInput 従業員数のテキスト入力コンポーネント
     */
    protected static function getEmployeeCountField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('employee_count')
            ->label(__('green-crm-core::company.fields.employee_count'))
            ->numeric();
    }

    /**
     * 関係性選択フィールドを取得
     *
     * @return Forms\Components\Select 関係性の選択コンポーネント
     */
    protected static function getRelationshipTypesField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('relationship_types')
            ->label(__('green-crm-core::company.fields.relationship_types'))
            ->multiple()
            ->options(RelationshipType::labels());
    }

    /**
     * 会社概要入力フィールドを取得
     *
     * @return Forms\Components\Textarea 会社概要のテキストエリアコンポーネント
     */
    protected static function getDescriptionField(): Forms\Components\Textarea
    {
        return Forms\Components\Textarea::make('description')
            ->label(__('green-crm-core::company.fields.description'))
            ->columnSpanFull();
    }

    /**
     * 代表者役職入力フィールドを取得
     *
     * @return Forms\Components\TextInput 代表者役職のテキスト入力コンポーネント
     */
    protected static function getRepresentativeTitleField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('representative_title')
            ->label(__('green-crm-core::company.fields.representative_title'))
            ->maxLength(255);
    }

    /**
     * 代表者氏名フィールドグループを取得
     *
     * @return Forms\Components\Grid 代表者氏名フィールドのグリッドコンポーネント
     */
    protected static function getRepresentativeNameFields(): Forms\Components\Grid
    {
        return Forms\Components\Grid::make(2)
            ->schema([
                static::getRepresentativeFamilyNameField(),
                static::getRepresentativeGivenNameField(),
                static::getRepresentativeFamilyNameKanaField(),
                static::getRepresentativeGivenNameKanaField(),
            ]);
    }

    /**
     * 代表者姓入力フィールドを取得
     *
     * @return Forms\Components\TextInput 代表者姓のテキスト入力コンポーネント
     */
    protected static function getRepresentativeFamilyNameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('representative_family_name')
            ->label(__('green-crm-core::company.fields.representative_family_name'))
            ->maxLength(255);
    }

    /**
     * 代表者名入力フィールドを取得
     *
     * @return Forms\Components\TextInput 代表者名のテキスト入力コンポーネント
     */
    protected static function getRepresentativeGivenNameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('representative_given_name')
            ->label(__('green-crm-core::company.fields.representative_given_name'))
            ->maxLength(255);
    }

    /**
     * 代表者姓（ふりがな）入力フィールドを取得
     *
     * @return Forms\Components\TextInput 代表者姓（ふりがな）のテキスト入力コンポーネント
     */
    protected static function getRepresentativeFamilyNameKanaField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('representative_family_name_kana')
            ->label(__('green-crm-core::company.fields.representative_family_name_kana'))
            ->maxLength(255);
    }

    /**
     * 代表者名（ふりがな）入力フィールドを取得
     *
     * @return Forms\Components\TextInput 代表者名（ふりがな）のテキスト入力コンポーネント
     */
    protected static function getRepresentativeGivenNameKanaField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('representative_given_name_kana')
            ->label(__('green-crm-core::company.fields.representative_given_name_kana'))
            ->maxLength(255);
    }

    /**
     * ドメインRepeaterフィールドを取得
     *
     * @return Forms\Components\Repeater ドメインのRepeaterコンポーネント
     */
    protected static function getDomainsRepeaterField(): TableRepeater
    {
        return TableRepeater::make('domains')
            ->label(__('green-crm-core::company.fields.domains'))
            ->relationship()
            ->headers([
                Header::make('domain')->label(__('green-crm-core::company.fields.domain')),
                Header::make('label')->label(__('green-crm-core::company.fields.domain_label')),
                Header::make('is_primary')->label(__('green-crm-core::company.fields.is_primary')),
            ])
            ->schema([
                Forms\Components\TextInput::make('domain')
                    ->placeholder('example.com')
                    ->required(),
                Forms\Components\TextInput::make('label')
                    ->placeholder(__('green-crm-core::company.placeholders.domain_label')),
                Forms\Components\Toggle::make('is_primary')
                    ->default(false),
            ])
            ->defaultItems(1)
            ->reorderable(false)
            ->columnSpanFull();
    }

    /**
     * メールアドレスRepeaterフィールドを取得
     *
     * @return Forms\Components\Repeater メールアドレスのRepeaterコンポーネント
     */
    protected static function getEmailRepeaterField(): TableRepeater
    {
        return TableRepeater::make('emails')
            ->label(__('green-crm-core::company.fields.emails'))
            ->relationship()
            ->headers([
                Header::make('email')->label(__('green-crm-core::company.fields.email_address')),
                Header::make('type')->label(__('green-crm-core::company.fields.email_type')),
                Header::make('label')->label(__('green-crm-core::company.fields.email_label')),
                Header::make('is_primary')->label(__('green-crm-core::company.fields.is_primary')),
            ])
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'info' => __('green-crm-core::company.email_types.info'),
                        'sales' => __('green-crm-core::company.email_types.sales'),
                        'support' => __('green-crm-core::company.email_types.support'),
                        'other' => __('green-crm-core::company.email_types.other'),
                    ])
                    ->default('info'),
                Forms\Components\TextInput::make('label')
                    ->placeholder(__('green-crm-core::company.placeholders.email_label')),
                Forms\Components\Toggle::make('is_primary')
                    ->default(false),
            ])
            ->defaultItems(1)
            ->reorderable(false)
            ->columnSpanFull();
    }

    /**
     * 住所Repeaterフィールドを取得
     *
     * @return Forms\Components\Repeater 住所のRepeaterコンポーネント
     */
    protected static function getAddressRepeaterField(): TableRepeater
    {
        return TableRepeater::make('addresses')
            ->label(__('green-crm-core::company.fields.addresses'))
            ->relationship()
            ->headers([
                Header::make('postal_code')->label(__('green-crm-core::company.fields.postal_code')),
                Header::make('type')->label(__('green-crm-core::company.fields.address_type')),
                Header::make('prefecture')->label(__('green-crm-core::company.fields.prefecture')),
                Header::make('city')->label(__('green-crm-core::company.fields.city')),
                Header::make('town')->label(__('green-crm-core::company.fields.town')),
                Header::make('building')->label(__('green-crm-core::company.fields.building')),
                Header::make('label')->label(__('green-crm-core::company.fields.address_label')),
                Header::make('is_primary')->label(__('green-crm-core::company.fields.is_primary')),
            ])
            ->schema([
                Forms\Components\TextInput::make('postal_code')
                    ->placeholder('123-4567')
                    ->maxLength(8),
                Forms\Components\Select::make('type')
                    ->options([
                        'headquarters' => __('green-crm-core::company.address_types.headquarters'),
                        'branch' => __('green-crm-core::company.address_types.branch'),
                        'other' => __('green-crm-core::company.address_types.other'),
                    ])
                    ->default('headquarters'),
                Forms\Components\TextInput::make('prefecture')
                    ->placeholder(__('green-crm-core::company.placeholders.prefecture')),
                Forms\Components\TextInput::make('city')
                    ->placeholder(__('green-crm-core::company.placeholders.city')),
                Forms\Components\TextInput::make('town')
                    ->placeholder(__('green-crm-core::company.placeholders.town')),
                Forms\Components\TextInput::make('building')
                    ->placeholder(__('green-crm-core::company.placeholders.building')),
                Forms\Components\TextInput::make('label')
                    ->placeholder(__('green-crm-core::company.placeholders.address_label')),
                Forms\Components\Toggle::make('is_primary')
                    ->default(false),
            ])
            ->defaultItems(1)
            ->reorderable(false)
            ->columnSpanFull();
    }
}
