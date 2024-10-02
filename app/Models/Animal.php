<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    protected $append = [
        'age',
        'ong_name',
        'site_name',
        'specie_name',
        'pen_number',
        'parent',
        'formated_created_at',
    ];

    public function specie(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function ong(): BelongsTo
    {
        return $this->belongsTo(Ong::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function pen(): BelongsTo
    {
        return $this->belongsTo(Pen::class);
    }

    public function sanitaryStates(): HasMany
    {
        return $this->hasMany(SanitaryState::class);
    }

    public function reproductions(): HasMany
    {
        return $this->hasMany(Reproduction::class);
    }

    public function relocation(): HasMany
    {
        return $this->hasMany(Relocation::class);
    }

    public function getAgeAttribute()
    {
        $age = ceil(now()->diffInYears($this->birthdate));
        return abs($age) . ' ans';
    }

    public function getSiteNameAttribute()
    {
        return $this->site->name;
    }

    public function getSpecieNameAttribute()
    {
        return $this->specie->french_name;
    }

    public function getPenNumberAttribute()
    {
        return $this->pen !== null ? $this->pen->number : 'Non défini';
    }

    public function getParentAttribute()
    {
        $parent = $this->parent_id !== null ? Animal::findOrFail($this->animal_id)->name : 'Non défini';
        return $parent;
    }

    public function getFormatedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getOngNameAttribute()
    {
        return $this->ong->name;
    }
}
