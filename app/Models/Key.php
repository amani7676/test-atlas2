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
        return $this->belongsToMany(Room::class, 'key_room')
            ->withPivot(['assigned_at', 'expires_at', 'notes'])
            ->withTimestamps();
    }

    // بررسی دسترسی به اتاق خاص
    public function hasAccessToRoom($roomId)
    {
        return $this->rooms()->where('room_id', $roomId)->exists();
    }
}
