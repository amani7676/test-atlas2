<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'desc',
        'note'
    ];

     // Relations
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'key_room');
    }
}
