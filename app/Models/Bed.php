<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'room_id',
        'state_ratio_resident',
        'state',
        'desc'
    ];

    // Relations
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function rezerves()
    {
        return $this->hasMany(Rezerve::class);
    }
}
