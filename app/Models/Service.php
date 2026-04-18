<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'employee_dni',
        'name',
        'type',
        'description',
        'availability'
    ];

    protected $casts = [
        'availability' => 'boolean', // Convierte automáticamente el 0/1 de la BD a true/false
    ];

    // Relación N:1 -> Un servicio pertenece a una zona
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    // Relación N:1 -> Un servicio está a cargo de un empleado (Avisamos de que usamos 'dni')
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_dni', 'dni');
    }
}
