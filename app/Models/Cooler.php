<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooler extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'room_id',
        'desc',
        'note'
    ];


    // Relations
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    
}
