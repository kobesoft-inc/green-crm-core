<?php

namespace Green\CrmCore\Filament\Resources\Concerns\Contact;

use Filament\Forms;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Green\CrmCore\Enums\RelationshipType;

trait HasContactForm
{
    /**
     * 連絡先の基本情報セクションを取得
     *
     * @return Forms\Components\Section 基本情報のセクションコンポーネント
     */
    protected static function getBasicInfoSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make(__('green-crm-core::contact.sections.basic_info'))
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make(__('green-crm-core::contact.sections.personal_info'))
                                    ->schema([
                                        static::getNameFields(),
                                        static::getPersonalInfoFields(),
                                    ])
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make(__('green-crm-core::contact.sections.contact_info'))
                                    ->schema([
                                        static::getEmailRepeaterField(),
                                        static::getAddressRepeaterField(),
                                    ])
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Section::make(__('green-crm-core::contact.sections.company_crm_info'))
                                    ->schema([
                                        static::getTitleField(),
                                        static::getCompanyNameField(),
                                        static::getRelationshipTypesField(),
                                        static::getNotesField(),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }

    /**
     * 氏名入力フィールドグループを取得
     *
     * @return Forms\Components\Grid 氏名フィールドのグリッドコンポーネント
     */
    protected static function getNameFields(): Forms\Components\Grid
    {
        return Forms\Components\Grid::make(2)
            ->schema([
                static::getFamilyNameField(),
                static::getGivenNameField(),
                static::getFamilyNameKanaField(),
                static::getGivenNameKanaField(),
            ]);
    }

    /**
     * 姓入力フィールドを取得
     *
     * @return Forms\Components\TextInput 姓のテキスト入力コンポーネント
     */
    protected static function getFamilyNameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('family_name')
            ->label(__('green-crm-core::contact.fields.family_name'))
            ->required()
            ->maxLength(255);
    }

    /**
     * 名入力フィールドを取得
     *
     * @return Forms\Components\TextInput 名のテキスト入力コンポーネント
     */
    protected static function getGivenNameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('given_name')
            ->label(__('green-crm-core::contact.fields.given_name'))
            ->required()
            ->maxLength(255);
    }

    /**
     * 姓（ふりがな）入力フィールドを取得
     *
     * @return Forms\Components\TextInput 姓（ふりがな）のテキスト入力コンポーネント
     */
    protected static function getFamilyNameKanaField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('family_name_kana')
            ->label(__('green-crm-core::contact.fields.family_name_kana'))
            ->maxLength(255);
    }

    /**
     * 名（ふりがな）入力フィールドを取得
     *
     * @return Forms\Components\TextInput 名（ふりがな）のテキスト入力コンポーネント
     */
    protected static function getGivenNameKanaField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('given_name_kana')
            ->label(__('green-crm-core::contact.fields.given_name_kana'))
            ->maxLength(255);
    }

    /**
     * 役職入力フィールドを取得
     *
     * @return Forms\Components\TextInput 役職のテキスト入力コンポーネント
     */
    protected static function getTitleField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('title')
            ->label(__('green-crm-core::contact.fields.title'))
            ->maxLength(255);
    }

    /**
     * 会社名入力フィールドを取得
     *
     * @return Forms\Components\TextInput 会社名のテキスト入力コンポーネント
     */
    protected static function getCompanyNameField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('company_name')
            ->label(__('green-crm-core::contact.fields.company_name'))
            ->maxLength(255);
    }

    /**
     * 関係性選択フィールドを取得
     *
     * @return Forms\Components\Select 関係性の選択コンポーネント
     */
    protected static function getRelationshipTypesField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('relationship_types')
            ->label(__('green-crm-core::contact.fields.relationship_types'))
            ->multiple()
            ->options(RelationshipType::labels());
    }

    /**
     * 個人情報フィールドグループを取得
     *
     * @return Forms\Components\Grid 個人情報フィールドのグリッドコンポーネント
     */
    protected static function getPersonalInfoFields(): Forms\Components\Grid
    {
        return Forms\Components\Grid::make(2)
            ->schema([
                static::getBirthdateField(),
                static::getGenderField(),
            ]);
    }

    /**
     * 誕生日入力フィールドを取得
     *
     * @return Forms\Components\DatePicker 誕生日の日付選択コンポーネント
     */
    protected static function getBirthdateField(): Forms\Components\DatePicker
    {
        return Forms\Components\DatePicker::make('birthdate')
            ->label(__('green-crm-core::contact.fields.birthdate'))
            ->native(false);
    }

    /**
     * 性別選択フィールドを取得
     *
     * @return Forms\Components\Select 性別の選択コンポーネント
     */
    protected static function getGenderField(): Forms\Components\Select
    {
        return Forms\Components\Select::make('gender')
            ->label(__('green-crm-core::contact.fields.gender'))
            ->options([
                'male' => __('green-crm-core::contact.gender.male'),
                'female' => __('green-crm-core::contact.gender.female'),
                'other' => __('green-crm-core::contact.gender.other'),
            ]);
    }

    /**
     * メールアドレスRepeaterフィールドを取得
     *
     * @return Forms\Components\Repeater メールアドレスのRepeaterコンポーネント
     */
    protected static function getEmailRepeaterField(): TableRepeater
    {
        return TableRepeater::make('emails')
            ->label(__('green-crm-core::contact.fields.emails'))
            ->relationship()
            ->headers([
                Header::make('email')->label(__('green-crm-core::contact.fields.email_address')),
                Header::make('type')->label(__('green-crm-core::contact.fields.email_type')),
                Header::make('label')->label(__('green-crm-core::contact.fields.email_label')),
                Header::make('is_primary')->label(__('green-crm-core::contact.fields.is_primary')),
                Header::make('is_opted_in')->label(__('green-crm-core::contact.fields.is_opted_in')),
            ])
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'personal' => __('green-crm-core::contact.email_types.personal'),
                        'work' => __('green-crm-core::contact.email_types.work'),
                        'other' => __('green-crm-core::contact.email_types.other'),
                    ])
                    ->default('personal'),
                Forms\Components\TextInput::make('label')
                    ->placeholder(__('green-crm-core::contact.placeholders.email_label')),
                Forms\Components\Toggle::make('is_primary')
                    ->default(false),
                Forms\Components\Toggle::make('is_opted_in')
                    ->default(true),
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
            ->label(__('green-crm-core::contact.fields.addresses'))
            ->relationship()
            ->headers([
                Header::make('postal_code')->label(__('green-crm-core::contact.fields.postal_code')),
                Header::make('type')->label(__('green-crm-core::contact.fields.address_type')),
                Header::make('prefecture')->label(__('green-crm-core::contact.fields.prefecture')),
                Header::make('city')->label(__('green-crm-core::contact.fields.city')),
                Header::make('town')->label(__('green-crm-core::contact.fields.town')),
                Header::make('building')->label(__('green-crm-core::contact.fields.building')),
                Header::make('label')->label(__('green-crm-core::contact.fields.address_label')),
                Header::make('is_primary')->label(__('green-crm-core::contact.fields.is_primary')),
            ])
            ->schema([
                Forms\Components\TextInput::make('postal_code')
                    ->placeholder('123-4567')
                    ->maxLength(8),
                Forms\Components\Select::make('type')
                    ->options([
                        'home' => __('green-crm-core::contact.address_types.home'),
                        'work' => __('green-crm-core::contact.address_types.work'),
                        'other' => __('green-crm-core::contact.address_types.other'),
                    ])
                    ->default('home'),
                Forms\Components\TextInput::make('prefecture')
                    ->placeholder(__('green-crm-core::contact.placeholders.prefecture')),
                Forms\Components\TextInput::make('city')
                    ->placeholder(__('green-crm-core::contact.placeholders.city')),
                Forms\Components\TextInput::make('town')
                    ->placeholder(__('green-crm-core::contact.placeholders.town')),
                Forms\Components\TextInput::make('building')
                    ->placeholder(__('green-crm-core::contact.placeholders.building')),
                Forms\Components\TextInput::make('label')
                    ->placeholder(__('green-crm-core::contact.placeholders.address_label')),
                Forms\Components\Toggle::make('is_primary')
                    ->default(false),
            ])
            ->defaultItems(1)
            ->reorderable(false)
            ->columnSpanFull();
    }

    /**
     * 備考入力フィールドを取得
     *
     * @return Forms\Components\Textarea 備考のテキストエリアコンポーネント
     */
    protected static function getNotesField(): Forms\Components\Textarea
    {
        return Forms\Components\Textarea::make('notes')
            ->label(__('green-crm-core::contact.fields.notes'))
            ->columnSpanFull();
    }
}
