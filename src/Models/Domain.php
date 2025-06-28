<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Domain extends Model
{
    protected $fillable = [
        'domain',
        'type',
        'label',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function domainable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFormattedDomainAttribute(): string
    {
        if (! str_starts_with($this->domain, 'http://') && ! str_starts_with($this->domain, 'https://')) {
            return "https://{$this->domain}";
        }

        return $this->domain;
    }
}
