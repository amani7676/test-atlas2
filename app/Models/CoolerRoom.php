<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoolerRoom extends Model
{
    use HasFactory;

    protected $table = 'cooler_room';

    protected $fillable = [
        'cooler_id',
        'room_id',
        'connection_type',
        'connected_at',
        'notes',
    ];

    protected $casts = [
        'connection_type' => 'string',
        'connected_at' => 'date',
    ];

    public function cooler()
    {
        return $this->belongsTo(Cooler::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
