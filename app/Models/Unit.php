<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'code',
        'desc'
    ];

    // Relations
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }


}
