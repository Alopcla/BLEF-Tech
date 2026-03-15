<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Configuración para usar DNI como Clave Primaria
    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dni',
        'user_name',
        'name',
        'surnames',
        'email',
        'address',
        'category'
    ];

    // Relación 1:N -> Un cliente tiene muchos teléfonos
    public function telephones()
    {
        return $this->hasMany(CustomerTelephone::class, 'customer_dni', 'dni')->orderBy('order');
    }
}
