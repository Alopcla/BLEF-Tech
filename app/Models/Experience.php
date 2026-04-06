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

    // Este "escudo" se ejecuta automáticamente cada vez que intentas crear o actualizar una experiencia
    protected static function booted()
    {
        static::saving(function ($experience) {
            // Si están intentando asignar un guía (el campo guide_dni no está vacío)
            if ($experience->guide_dni) {
                // Buscamos a ese empleado en la base de datos
                $employee = Employee::find($experience->guide_dni);

                // Si el empleado no existe o NO es Guía, cancelamos la operación lanzando un error
                if (!$employee || $employee->position !== 'Guía') {
                    throw new \Exception('Error de Asignación: El empleado seleccionado no tiene el cargo de Guía.');
                }
            }
        });
    }

    // La relación que pusimos antes sigue siendo necesaria
    public function guide()
    {
        return $this->belongsTo(Employee::class, 'guide_dni', 'dni');
    }
}
