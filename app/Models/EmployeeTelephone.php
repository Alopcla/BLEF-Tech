<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTelephone extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_dni',
        'telephone',
        'order'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_dni', 'dni');
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($telefono) {
            
            $ultimoOrden = self::where('employee_dni', $telefono->employee_dni)->max('order');

            $telefono->order = ($ultimoOrden ?? 0) + 1;
        });
    }
}
