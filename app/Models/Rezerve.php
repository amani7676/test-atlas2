<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezerve extends Model
{
    use HasFactory;
     protected $fillable = [
        'full_name',
        'phone',
        'bed_id',
        'note',
        'priority'
    ];

    // Relations
    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}
