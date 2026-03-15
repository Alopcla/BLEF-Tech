<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTelephone extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_dni',
        'telephone',
        'order'
    ];

    /**
     * Evento Booted: Autoincremento de la columna 'order'
     */
    protected static function booted()
    {
        parent::booted();

        static::creating(function($telephone) {
            // Buscamos el orden más alto para este cliente en concreto
            $maxOrder = self::where('customer_dni', $telephone->customer_dni)->max('order');

            // Asignamos el siguiente número (si es el primero, será 1)
            $telephone->order = ($maxOrder ?? 0) + 1;
        });
    }

    // Relación N:1 -> Este teléfono pertenece a un cliente
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_dni', 'dni');
    }
}
