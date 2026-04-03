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
        'slug',
        'description',
        'details',
        'duration_min',
        'price',
        'capacity',
        'image'
    ];

    // Relación N:1 -> Una experiencia pertenece a una zona
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    // Relación: una experiencia tiene muchas reservas
    public function reservations()
    {
        return $this->hasMany(ReserveExperience::class);
    }

    // DISPONIBILIDAD DINÁMICA
    public function getAvailableSpotsAttribute()
    {
        $reserved = $this->reservations()
            ->where('status', 'paid')
            ->count();

        return max(0, $this->capacity - $reserved);
    }


    /** OBTENER EXPERIENCIA MAS POPULAR */
    public function scopePopular($query)
    {
        return $query->withCount(['reservations' => function ($q) {
            $q->where('status', 'paid');
        }])->orderByDesc('reservations_count');
    }
}
