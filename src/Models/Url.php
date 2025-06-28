<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Url extends Model
{
    protected $fillable = [
        'url',
        'type',
        'label',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function urlable(): MorphTo
    {
        return $this->morphTo();
    }
}
