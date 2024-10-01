<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reproduction extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    protected $append = ['animal_name'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function getAnimalNameAttribute() {
        return $this->animal->name;
    }
}
