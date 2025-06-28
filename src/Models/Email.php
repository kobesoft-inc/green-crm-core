<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Email extends Model
{
    protected $fillable = [
        'email',
        'type',
        'label',
        'is_primary',
        'is_opted_in',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_opted_in' => 'boolean',
    ];

    public function emailable(): MorphTo
    {
        return $this->morphTo();
    }
}
