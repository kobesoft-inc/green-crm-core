<?php

namespace Green\CrmCore\Enums;

enum RelationshipType: string
{
    case LEAD = 'lead';
    case PROSPECT = 'prospect';
    case CUSTOMER = 'customer';
    case VENDOR = 'vendor';
    case PARTNER = 'partner';
    case SUPPLIER = 'supplier';
    case CONTRACTOR = 'contractor';
    case OTHER = 'other';

    public function label(): string
    {
        return __('green-crm-core::enums.relationship_type.'.$this->value);
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
