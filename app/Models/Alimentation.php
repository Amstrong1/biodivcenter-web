<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alimentation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['specie_name'];

    public function site() : BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function specie() : BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSpecieNameAttribute()
    {
        return $this->specie->french_name;
    }
}
