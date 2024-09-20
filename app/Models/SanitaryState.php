<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryState extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $append = ['animal_name', 'formated_date'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAnimalNameAttribute() {
        return $this->animal->name;
    }

    public function getFormatedDateAttribute() {
        return $this->created_at->format('Y-m-d');
    }
}
