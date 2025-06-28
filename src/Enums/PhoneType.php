<?php

namespace Green\CrmCore\Enums;

enum PhoneType: string
{
    case MOBILE = 'mobile';
    case WORK = 'work';
    case FAX = 'fax';
    case HOME = 'home';
    case OTHER = 'other';

    public function label(): string
    {
        return __('green-crm-core::enums.phone_type.'.$this->value);
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
