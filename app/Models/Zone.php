<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecosystem_id',
        'type',
        'dimensions_m2',
        'description'
    ];

    // Relación N:1 -> Una zona pertenece a un ecosistema
    public function ecosystem()
    {
        return $this->belongsTo(Ecosystem::class);
    }

    // Relación 1:N -> Una zona tiene muchos animales
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    // Relación 1:N -> Una zona tiene muchos servicios
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Relación 1:N -> Una zona tiene muchas experiencias
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
