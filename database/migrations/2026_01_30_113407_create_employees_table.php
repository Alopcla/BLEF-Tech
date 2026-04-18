<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Crear la estructura (tablas) en la base de datos
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            /** Creacion de tabla de 'empleados' con los atributos...
             * dni, nombre, apellidos, edad, email (no se repite, unique), direccion, provincia y cargo del empleado.
             */
            $table->string('dni')->primary();
            // Campo 'zona_id' donde el empleado trabaja en una zona especifica.
            $table->foreignId('zone_id')->constrained('zones')->onDelete('restrict');
            $table->string('name');
            $table->string('surname');
            /** Columna para la fecha de nacimiento. Mas adelante en el Modelo,
             * podemos calcular la edad con una funcion especifica.
             */
            $table->date('birth_date');
            // Campo 'correo'. Siendo unico cada correo
            $table->string('email')->unique();
            // Campo 'direccion'. Direccion donde vive el empleado
            $table->string('address');
            // Campo 'provincia'. Provincia donde reside el empleado
            $table->string('province');
            // Campo 'cargo'. El cargo que ocupa el empleado.
            $table->string('position');
            // Campo de contraseña, sea la contrasela DNI para cuando se cree un empleado o la contrasela de Admin
            $table->string('password');

            $table->string('verification_code')->nullable();
            $table->timestamp('verification_code_expires_at')->nullable();
            
            // Campo para la funcion 'Recuerdame'
            $table->rememberToken();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     * Elimina las tablas de la base de datos.
     */
    public function down(): void
    {
        /** A la hora de eliminar, es primordial borrar antes la tabla sessions.
         * Ya que contiene una clave foranea del employees (id), teniendo constrained().
         * Si pusieramos el borrado de employees primero, causaria un error.
         */
        /** Schema::dropIfExists('sessions_employees');*/
        /**  Schema::dropIfExists('password_reset_tokens_employees'); */
        Schema::dropIfExists('employees');
    }
};
