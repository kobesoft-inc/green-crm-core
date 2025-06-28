<?php

return [
    'label' => '連絡先',
    'plural_label' => '連絡先',

    'sections' => [
        'basic_info' => '基本情報',
        'personal_info' => '個人情報',
        'contact_info' => '連絡先情報',
        'company_crm_info' => '会社・CRM情報',
        'position_info' => '所属情報',
        'company_info' => '会社情報',
        'companies' => '関連会社',
        'emails' => 'メールアドレス',
        'phones' => '電話番号',
        'addresses' => '住所',
    ],

    'fields' => [
        'full_name' => '氏名',
        'family_name' => '姓',
        'given_name' => '名',
        'full_name_kana' => '氏名（ふりがな）',
        'family_name_kana' => '姓（ふりがな）',
        'given_name_kana' => '名（ふりがな）',
        'title' => '役職',
        'company_name' => '会社名',
        'relationship_types' => '関係性',
        'notes' => '備考',
        'position' => '役職',
        'department' => '部署',
        'primary_email' => 'メインメール',
        'primary_phone' => 'メイン電話番号',
        'email' => 'メールアドレス',
        'company' => '会社',
        'birthdate' => '誕生日',
        'gender' => '性別',
        'established_date' => '設立日',
        
        // Email fields
        'emails' => 'メールアドレス',
        'email_address' => 'メールアドレス',
        'email_type' => 'メール種別',
        'email_label' => 'ラベル',
        'is_primary' => 'メイン',
        'is_opted_in' => 'メール配信許可',
        
        // Address fields
        'addresses' => '住所',
        'postal_code' => '郵便番号',
        'prefecture' => '都道府県',
        'city' => '市区町村',
        'town' => '町域',
        'building' => '建物名・部屋番号',
        'address_type' => '住所種別',
        'address_label' => 'ラベル',
    ],

    'filters' => [
        'relationship_types' => '関係性で絞り込み',
    ],

    'actions' => [
        'create' => '連絡先を作成',
    ],

    'email_types' => [
        'personal' => '個人',
        'work' => '仕事',
        'other' => 'その他',
    ],

    'address_types' => [
        'home' => '自宅',
        'work' => '職場',
        'other' => 'その他',
    ],

    'gender' => [
        'male' => '男性',
        'female' => '女性',
        'other' => 'その他',
    ],

    'placeholders' => [
        'email_label' => 'メインアドレス、サブアドレスなど',
        'prefecture' => '東京都',
        'city' => '渋谷区',
        'town' => '渋谷1-2-3',
        'building' => 'マンション名101号室',
        'address_label' => '自宅、職場など',
    ],

    'helpers' => [
        'company_auto_selected' => 'メールアドレスのドメインから会社が自動選択されました',
    ],
];
