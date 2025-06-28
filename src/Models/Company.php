<?php

namespace Green\CrmCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    protected $fillable = [
        'company_name',
        'corporate_number',
        'representative_title',
        'representative_family_name',
        'representative_given_name',
        'representative_family_name_kana',
        'representative_given_name_kana',
        'description',
        'industry',
        'employee_count',
        'capital',
        'annual_revenue',
        'relationship_types',
    ];

    protected $casts = [
        'capital' => 'integer',
        'annual_revenue' => 'integer',
        'relationship_types' => 'array',
    ];

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_companies')
            ->withPivot(['position', 'department'])
            ->withTimestamps();
    }

    public function branches(): HasMany
    {
        return $this->hasMany(CompanyBranch::class);
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

    public function getFormattedCorporateNumberAttribute(): ?string
    {
        if (! $this->corporate_number) {
            return null;
        }

        if (strlen($this->corporate_number) === 13) {
            return substr($this->corporate_number, 0, 1).'-'.
                substr($this->corporate_number, 1, 4).'-'.
                substr($this->corporate_number, 5, 4).'-'.
                substr($this->corporate_number, 9, 4);
        }

        return $this->corporate_number;
    }

    public function getRepresentativeFullNameAttribute(): ?string
    {
        if (! $this->representative_family_name && ! $this->representative_given_name) {
            return null;
        }

        return trim("{$this->representative_family_name} {$this->representative_given_name}");
    }

    public function getRepresentativeFullNameKanaAttribute(): ?string
    {
        if (! $this->representative_family_name_kana && ! $this->representative_given_name_kana) {
            return null;
        }

        return trim("{$this->representative_family_name_kana} {$this->representative_given_name_kana}");
    }

    public function getRepresentativeWithTitleAttribute(): ?string
    {
        $name = $this->representative_full_name;

        if (! $name) {
            return null;
        }

        if ($this->representative_title) {
            return "{$this->representative_title} {$name}";
        }

        return $name;
    }
}
