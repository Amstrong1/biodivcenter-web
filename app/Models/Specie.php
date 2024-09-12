<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specie extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $append = [
        'animals_count',
        'order_name',
        'classification_name',
        'family_name',
        'genus_name',
        'reign_name',
        'branch_name',
        'site_name'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function genus(): BelongsTo
    {
        return $this->belongsTo(Genus::class);
    }

    public function reign(): BelongsTo
    {
        return $this->belongsTo(Reign::class);
    }

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
        return $this->belongsToMany(Specie::class)->withPivot('latitude', 'longitude');
    }

    public function getAnimalCountAttribute()
    {
        $animals_count = Animal::where('specie_id', $this->id)
            ->where('state', 'present')
            ->where('deleted_at', null)
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
}
