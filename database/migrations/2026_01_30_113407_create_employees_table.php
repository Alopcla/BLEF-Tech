<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crear la estructura (tablas) en la base de datos
     */
    public function up(): void
    {
        Schema::create('employees', function(Blueprint $table) {
            /** Creacion de tabla de 'empleados' con los atributos...
             * id, nombre, apellidos, edad, email (no se repite, unique), direccion y provincia
             */
            $table->id();
            $table->string('DNI')->unique();
            $table->string('name');
            $table->string('surname');
            /** Columna para la fecha de nacimiento. Mas adelante en el Modelo,
             * podemos calcular la edad con una funcion especifica.
             */
            $table->date('birth_date');
            $table->string('email')->unique();
            /** Columna que almacena la fecha y hora exacta en que un usuario
             * verifica su correo electronico, permite que el campo este vacio (NULL)
             *  $table->timestamp('email_verified_at')->nullable(); */
            $table->string('address');
            $table->string('province');
            /** Columna que guarda un token para la funcionalidad 'Recuerdame'.
             * Permite al usuario mantener su sesion iniciada incluso si cierra el navegador
            * Metodo -----> $table->rememberToken(); <-----*/

            /** Metodo que se utiliza para crear automaticamente dos columnas,
             * created_at (fecha de creacion)
             * updated_at (fecha de actualizacion)
             */ $table->timestamps();

        });

        // Creacion de la tabla 'peticiones temporales' para cambios de contraseñas
        Schema::create('password_reset_tokens_employees', function(Blueprint $table) {
            $table->string('email')->primary();
            /** Columna de token unico. Se guarda el codigo de seguridad (token) que se
             * envia al empleado por correo. Sirve para cuando el empleado haga clic
             * en el enlace de recuperacion, Laravel busca dicho token en la tabla
             * para validar que la peticion es legitima.
             */
            $table->string('token');

            /** Columna para registrar la fecha y hora exacta en la que se genero el token
             * Puede que este vacio o no.
             */
            $table->string('created_at')->nullable();
        });

        /** Creacion de la tabla de 'sesiones', permitiendo un control para saber quien
        * esta conectado */
        Schema::create('sessions_employees', function(Blueprint $table) {
            $table->string('id')->primary();

            /** Clave foranea del ID del empleado. Con constrained() se asegura
             * crear un indice automaticamente, asi que no haria falta añadir el
             * metodo index(). El metodo onDelete('cascade') refuerza la relacion.
             * En caso de que se elimine dicho empleado, se eliminara todos sus
             * registros.
             */
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            /** Columna para guardar la direccion IP del dispositivo del usuario.
             * El tamaño 45 es para ser compatible tanto en el formato IPv4 como
             * con el nuevo IPv6.
             */
            $table->string('ip_address', 45)->nullable();
            /** Columna para guardar la información del navegador donde se conecta el empleado
             * Por ejemplo, Chrome, Safari, Edge, etc...
            */
            $table->text('user_agent')->nullable();
            /** Columna para guardar un bloque de texto grande, donde se guarda
             * informacion de la sesion serializada. Como variables de sesion,
             * mensajes flash, datos temporales del carrito, etc.
            */
            $table->longText('payload');
            /** Columna para guardar una "marca de tiempo" (Unix timestap),
             * del momento exacto de la ultima interaccion del usuario.
             */
            $table->integer('last_activity')->index();
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
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens_employees');
        Schema::dropIfExists('employees');
    }
};
