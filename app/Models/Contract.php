<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
      protected $fillable = [
        'resident_id',
        'payment_date',
        'bed_id',
        'state',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // Relations
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}
