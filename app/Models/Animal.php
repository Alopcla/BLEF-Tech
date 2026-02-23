<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{

    use HasFactory;

    // Definiremos los campos en los cuales el usuario puede introducir datos.
    protected $fillable = ['species', 'location', 'curiosity', 'imagen'];

    /**
     * Summary of hidden: Propiedad de Visibilidad (Salida de datos).
     * Se controla que columnas NO se muestran cuando conviertes el modelo a JSON
     * o en un Array (uso de APIS).
     * En este caso, no se mostraran dichas columnas.
     * @var array
     */
    protected $hidden = [
        /** Estas dos columnas son creadas mediante... $table->timestamps()
         * en la Migracion.
         */
        'created_at',
        'updated_at'
    ];
}
