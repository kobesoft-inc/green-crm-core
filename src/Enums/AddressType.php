<?php

namespace Green\CrmCore\Enums;

enum AddressType: string
{
    case OFFICE = 'office';
    case HOME = 'home';
    case OTHER = 'other';

    public function label(): string
    {
        return __('green-crm-core::enums.address_type.'.$this->value);
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
