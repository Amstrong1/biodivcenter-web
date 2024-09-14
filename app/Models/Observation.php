<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $append = ['formated_date', 'site_name'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getSiteNameAttribute()
    {
        return $this->site->name;
    }

    public function getFormatedDateAttribute()
    {
        return date('Y-m-d', strtotime($this->created_at));
    }
}
