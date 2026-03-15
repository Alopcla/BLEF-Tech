<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecosystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'climate',
        'region'
    ];

    // Relación 1:N -> Un ecosistema tiene muchas zonas
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
