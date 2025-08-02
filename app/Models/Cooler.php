<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooler extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'number',
        'desc',
        'status',
        'model',
        'serial_number',
        'installation_date'
    ];

    protected $casts = [
        'installation_date' => 'date'
    ];

    /**
     * Get all rooms connected to this cooler
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'cooler_room')
            ->withPivot(['connection_type', 'connected_at', 'notes', 'id'])
            ->withTimestamps();
    }

    /**
     * Get connection details for a specific room
     */
    public function getConnectionDetails($roomId)
    {
        return $this->rooms()->where('room_id', $roomId)->first()?->pivot;
    }

    /**
     * Check if cooler is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'فعال',
            'inactive' => 'غیرفعال',
            'maintenance' => 'تعمیرات',
            default => 'نامشخص'
        };
    }

    /**
     * Scope for active coolers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get connection type options
     */
    public static function getConnectionTypes()
    {
        return [
            'direct' => 'مستقیم',
            'duct' => 'کانالی',
            'central' => 'مرکزی'
        ];
    }


}
