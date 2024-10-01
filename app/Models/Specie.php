<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specie extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    protected $append = [
        'animals_count',
        'site_name',
        'status_uicn_label',
    ];
    
    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function alimentation(): HasMany
    {
        return $this->hasMany(Alimentation::class);
    }

    public function typeHabitat(): HasMany
    {
        return $this->hasMany(TypeHabitat::class);
    }

    public function siteSpecies(): BelongsToMany
    {
        return $this->belongsToMany(Specie::class);
    }

    public function getAnimalsCountAttribute()
    {
        $animals_count = Animal::where('specie_id', $this->id)
            ->where('state', 'present')
            ->count();
        return $animals_count;
    }

    public function getOrderNameAttribute()
    {
        return $this->order->name;
    }

    public function getClassificationNameAttribute()
    {
        return $this->classification->name;
    }

    public function getFamilyNameAttribute()
    {
        return $this->family->name;
    }

    public function getGenusNameAttribute()
    {
        return $this->genus->name;
    }

    public function getReignNameAttribute()
    {
        return $this->reign->name;
    }

    public function getBranchNameAttribute()
    {
        return $this->branch->name;
    }

    public function getSiteNameAttribute()
    {
        return $this->siteSpecies->site->name;
    }

    public function getStatusUicnLabelAttribute(){
        foreach (config('global.uicn_labels') as $key => $value) {
            if ($this->status_uicn == $key) {
                return $value;
            }
        }
    }
}
