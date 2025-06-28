<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'postal_code',
        'prefecture',
        'city',
        'town',
        'building',
        'type',
        'label',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            "〒{$this->postal_code}",
            $this->prefecture,
            $this->city,
            $this->town,
            $this->building,
        ]);

        return implode(' ', $parts);
    }

    public function getFormattedPostalCodeAttribute(): string
    {
        if (strlen($this->postal_code) === 7) {
            return substr($this->postal_code, 0, 3).'-'.substr($this->postal_code, 3);
        }

        return $this->postal_code;
    }
}
