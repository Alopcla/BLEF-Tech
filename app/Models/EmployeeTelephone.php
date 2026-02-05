<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTelephone extends Model
{
    use HasFactory;
    /**
     * Summary of fillable: Propiedad de asignacion masiva (Seguridad).
     * De la misma forma con Employee, decidimos de que los campos
     * a modificar sean el id del empleado y el numero de telefono.
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'number',
        'order'
    ];

    /**
     * Summary of employee: Relacion del Modelo.
     * Establecemos la conexion con la tabla Employee, como se menciono en el
     * archivo Employee.php. Recordemos que dicha relacion entre ambos es 1:N.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Employee, EmployeeTelephone>
     */
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Summary of booted: Metodo que Laravel se ejecuta una sola vez cuando el modelo
     * es cargado en memoria durante la ejecucion de la aplicacion. Registrar comportamientos
     * que deben aplicarse a todas las instancias de dicho modelo.
     * Resumidas cuentas, este evento ocurre DESPUES de rellenar los datos pero ANTES
     * de que se ejecute el INSERT.
     * Una vez definido aqui, el modelo se encarga de realizar dicha funcion.
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        /** Evento el cual escuchamos y "esta creandose".
         *  Ocurre antes de que los datos se guarden en la base de datos.
         * En este caso ocurrira un autoincremento de la columna 'order'.
        */
        static::creating(function($telephone) {
            /**
             * @var mixed: Miramos quien es el dueño de este telefono ($telephone->employee_id)
             * Y miramos cual es la orden de telefono mas alta.
             */
            $ultimoOrden = self::where('employee_id', $telephone->employee_id)->max('order');

            /** Operador de Coalescencia Nula:
             * Si el resultado de la izquierda es nulo, se asigna el resultado de la derecha.
             * Manera mas resumida en vez de un if/else.
             */
            $telephone->order = ($ultimoOrden ?? 0) + 1;

            /** Si devuelve null, es porque es el primer telefono */
            // if($ultimoOrden === null) {
                // $telephone->order = 1;
            // } else {
                // Si ya tenia alguna orden, es que ya tenia telefonos. Se le suma un telefono mas.
                // $telephone->order = $ultimoOrden + 1;
            // }

        });
    }
}
