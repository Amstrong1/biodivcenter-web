<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupervisorRight extends Model
{
    use HasFactory, HasUlids;
    protected $guarded = [];
}
