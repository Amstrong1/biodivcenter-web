<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relocation extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $append = [
        'ong_origin_name', 
        'ong_destination_name', 
        'site_origin_name', 
        'site_destination_name',
        'user_name',
        'animal_name',
        'formated_date_transfert',
    ];

    public function ong_origin()
    {
        return $this->belongsTo(Ong::class, 'ong_origin_id');
    }

    public function ong_destination()
    {
        return $this->belongsTo(Ong::class, 'ong_destination_id');
    }

    public function site_origin()
    {
        return $this->belongsTo(Site::class, 'site_origin_id');
    }

    public function site_destination()
    {
        return $this->belongsTo(Site::class, 'site_destination_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function getFormatedDateTransfertAttribute()
    {
        return date('d/m/Y', strtotime($this->date_transfert));
    }

    public function getOngOriginNameAttribute()
    {
        return $this->ong_origin->name;
    }

    public function getOngDestinationNameAttribute()
    {
        return $this->ong_destination->name;
    }

    public function getSiteOriginNameAttribute()
    {
        return $this->site_origin->name;
    }

    public function getSiteDestinationNameAttribute()
    {
        return $this->site_destination->name;
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getAnimalNameAttribute()
    {
        return $this->animal->name;
    }
}
