<?php

return [
    'label' => '会社',
    'plural_label' => '会社',

    'sections' => [
        'basic_info' => '基本情報',
        'company_basic' => '会社基本情報',
        'company_details' => '会社詳細情報',
        'crm_info' => 'CRM情報',
        'representative' => '代表者情報',
        'contacts' => '関連連絡先',
        'branches' => '支店',
        'emails' => 'メールアドレス',
        'phones' => '電話番号',
        'addresses' => '住所',
    ],

    'fields' => [
        'company_name' => '会社名',
        'corporate_number' => '法人番号',
        'capital' => '資本金',
        'annual_revenue' => '年商',
        'industry' => '業界',
        'employee_count' => '従業員数',
        'relationship_types' => '関係性',
        'description' => '会社概要',
        'representative' => '代表者',
        'representative_title' => '代表者役職',
        'representative_family_name' => '代表者姓',
        'representative_given_name' => '代表者名',
        'representative_family_name_kana' => '代表者姓（ふりがな）',
        'representative_given_name_kana' => '代表者名（ふりがな）',
        'representative_kana' => '代表者（ふりがな）',
        'contacts_count' => '連絡先数',
        'established_date' => '設立日',
        'url' => 'URL',
        'domain' => 'ドメイン',
        'domains' => 'ドメイン',
        'domain_label' => 'ドメインラベル',
        'is_primary' => 'メイン',
        
        // Email fields
        'emails' => 'メールアドレス',
        'email_address' => 'メールアドレス',
        'email_type' => 'メール種別',
        'email_label' => 'ラベル',
        
        // Address fields
        'addresses' => '住所',
        'postal_code' => '郵便番号',
        'prefecture' => '都道府県',
        'city' => '市区町村',
        'town' => '町域',
        'building' => '建物名・部屋番号',
        'address_type' => '住所種別',
        'address_label' => 'ラベル',
        'address' => '住所',
    ],

    'filters' => [
        'relationship_types' => '関係性で絞り込み',
        'industry' => '業界で絞り込み',
    ],

    'actions' => [
        'create' => '会社を作成',
    ],

    'email_types' => [
        'info' => '問い合わせ',
        'sales' => '営業',
        'support' => 'サポート',
        'other' => 'その他',
    ],

    'address_types' => [
        'headquarters' => '本社',
        'branch' => '支社・支店',
        'other' => 'その他',
    ],

    'placeholders' => [
        'domain_label' => 'メインサイト、採用サイトなど',
        'email_label' => 'メインアドレス、サポートなど',
        'prefecture' => '東京都',
        'city' => '千代田区',
        'town' => '丸の内1-2-3',
        'building' => 'ビル名10階',
        'address_label' => '本社、営業所など',
    ],

    'helpers' => [
        'url_auto_domain' => 'URLからドメインが自動で抽出されます',
    ],
];
