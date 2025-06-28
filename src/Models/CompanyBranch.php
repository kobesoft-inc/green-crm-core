<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CompanyBranch extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'branch_type',
        'description',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function urls(): MorphMany
    {
        return $this->morphMany(Url::class, 'urlable');
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function domains(): MorphMany
    {
        return $this->morphMany(Domain::class, 'domainable');
    }
}
