<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ong extends Model
{
    use HasFactory, SoftDeletes, HasUlids;

    protected $guarded = [];

    protected $appends = ['formated_mdt_membership'];

    public function sites() : HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function ongAgreements() : HasMany
    {
        return $this->hasMany(OngAgreement::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getFormatedMdtMembershipAttribute(): string
    {
        return $this->mdt_membership == 1 ? 'Oui' : 'Non';
    }
}
