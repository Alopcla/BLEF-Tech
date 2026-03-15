<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'name',
        'description',
        'duration_min',
        'price',
        'max_capacity',
        'ability'
    ];

    // Relación N:1 -> Una experiencia pertenece a una zona
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
