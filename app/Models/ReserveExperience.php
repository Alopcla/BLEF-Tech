<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveExperience extends Model
{
    use HasFactory;

    // Aunque es una tabla pivote, como le pusimos id(), Laravel la trata como modelo normal
    protected $fillable = [
        'customer_dni',
        'experience_id',
        'employee_guide_dni',
        'reservation_date',
        'status'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'status' => 'boolean', // Convierte el estado a true/false
    ];

    // Relación N:1 -> La reserva la hace un cliente
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_dni', 'dni');
    }

    // Relación N:1 -> La reserva es de una experiencia
    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

    // Relación N:1 -> La reserva la guía un empleado
    public function guide()
    {
        return $this->belongsTo(Employee::class, 'employee_guide_dni', 'dni');
    }
}
