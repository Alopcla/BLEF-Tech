<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** Necesario este import de abajo, para poder conectar Modelo con Factory. */
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    /** Siempre se introduce dentro de la clase del modelo. */
    use HasFactory;
    /**
     * Summary of fillable: Propiedad de asignacion masiva (Seguridad). Mediante $fillable,
     * le decimos a Laravel que los campos que esten asignados dentro del array,
     * se pueden MODIFICAR (por ejemplo, en un formulario).
     * @var array
     */
    protected $fillable = [
        'DNI',
        'name',
        'surname',
        'email',
        'birth_date',
        'address',
        'province'
    ];

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

    /**
     * Summary of casts: Propiedad para transformar la fecha de String a objeto Date.
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Summary of telephones: Relacion del Modelo.
     * Establecemos la conexion con la tabla Employee con la tabla EmployeeTelephone,
     * mediante relacion 1:N.
     * Un empleado tiene muchos telefonos, un telefono es tenido solo por un empleado.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<EmployeeTelephone, Employee>
     */
    public function telephones() {
        return $this->hasMany(EmployeeTelephone::class)->orderBy('order');
    }
}
