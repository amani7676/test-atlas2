<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'resident_id',
        'type',
        'note'
    ];
    protected $dates = ['deleted_at'];

    // Relations
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
