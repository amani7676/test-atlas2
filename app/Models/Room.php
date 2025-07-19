<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'unit_id',
        'bed_count',
        'desc'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    public function coolers()
    {
        return $this->hasMany(Cooler::class);
    }

    public function keys()
    {
        return $this->hasMany(Key::class);
    }
}
