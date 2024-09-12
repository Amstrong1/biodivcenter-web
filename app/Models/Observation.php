<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $append = ['formated_date'];

    public function getFormatedDateAttribute()
    {
        return date('d/m/Y', strtotime($this->created_at));
    }
}
