<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

      protected $fillable = [
        'full_name',
        'phone',
        'age',
        'job',
        'referral_source',
        'form',
        'rent',
        'trust'
    ];

    protected $casts = [
        'form' => 'boolean',
        'rent' => 'boolean',
        'trust' => 'boolean'
    ];

    // Relations
    public function contracts()
    {
        return $this->hasOne(Contract::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
