<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Contact extends Model
{
    protected $fillable = [
        'family_name',
        'given_name',
        'family_name_kana',
        'given_name_kana',
        'title',
        'company_name',
        'relationship_types',
        'birthdate',
        'gender',
        'established_date',
        'notes',
    ];

    protected $casts = [
        'relationship_types' => 'array',
        'birthdate' => 'date',
        'established_date' => 'date',
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'contact_companies')
            ->withPivot(['position', 'department'])
            ->withTimestamps();
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

    public function getFullNameAttribute(): string
    {
        return "{$this->family_name} {$this->given_name}";
    }

    public function getFullNameKanaAttribute(): string
    {
        return "{$this->family_name_kana} {$this->given_name_kana}";
    }
}
