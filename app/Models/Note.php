<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'resident_id',
        'type',
        'note'
    ];
    // Relations
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
