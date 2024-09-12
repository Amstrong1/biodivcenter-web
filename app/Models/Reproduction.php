<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reproduction extends Model
{
    use HasFactory;

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
