<?php

namespace Green\CrmCore\Enums;

enum UrlType: string
{
    case WEBSITE = 'website';
    case SOCIAL = 'social';
    case OTHER = 'other';

    public function label(): string
    {
        return __('green-crm-core::enums.url_type.'.$this->value);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }

        return $labels;
    }
}
