<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'feedbacks';
    protected $guarded = [];
    protected $append = ['user_name', 'formated_date'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getFormatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
