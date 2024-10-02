<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanitaryState extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    protected $append = ['animal_name', 'formated_date', 'user_name'];

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

    public function getUserNameAttribute() {
        return $this->user->name;
    }
}
