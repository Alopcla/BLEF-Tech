<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'employee_dni',
        'date',
        'diagnosis',
        'treatment'
    ];

    // Cast para transformar el campo en un tipo de dato especifico, siendo un cast de fecha con horas y minutos.
    protected $casts = [
        'date' => 'datetime',
    ];

    // Relación N:1 -> El registro pertenece a un animal
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    // Relación N:1 -> El registro pertenece a un empleado
    // (Avisamos a Laravel de que usamos 'dni' en lugar de 'id')
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_dni', 'dni');
    }
}
