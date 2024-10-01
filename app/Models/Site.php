<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Site extends Model
{
    use HasFactory, SoftDeletes, HasUlids;

    protected $guarded = [];

    protected $append = ['biodiv_value', 'type_habitat_name', 'ong_country'];

    public function type_habitat(): BelongsTo
    {
        return $this->belongsTo(TypeHabitat::class);
    }

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function pens(): HasMany
    {
        return $this->hasMany(Pen::class);
    }

    public function siteSpecies(): BelongsToMany
    {
        return $this->belongsToMany(Specie::class);
    }

    public function ong(): BelongsTo
    {
        return $this->belongsTo(Ong::class);
    }

    public function getBiodivValueAttribute()
    {
        $biodiv_value = 0;
        $siteSpecies = $this->siteSpecies()->get();
        
        foreach ($siteSpecies as $siteSpecie) {
            $status_uicn = $siteSpecie->status_uicn;
            $uicn_values = config('global.uicn_values');
            
            if (array_key_exists($status_uicn, $uicn_values)) {
                $biodiv_value += $uicn_values[$status_uicn];
            }
        }
        return $biodiv_value;
    }

    public function getTypeHabitatNameAttribute()
    {
        return $this->type_habitat->name;
    }

    public function getOngCountryAttribute()
    {
        return $this->ong->country;
    }
}
