<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'phone',
        'age',
        'job',
        'referral_source',
        'form',
        'rent',
        'trust',
        'document',
    ];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'form' => 'boolean',
        'rent' => 'boolean',
        'trust' => 'boolean',
        'document' => 'boolean',
    ];

    // Relations
    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function getFormattedPhoneAttribute()
    {
        return preg_replace('/^(\d{4})(\d{3})(\d{4})$/', '$1-$2-$3', $this->phone);
    }

}
