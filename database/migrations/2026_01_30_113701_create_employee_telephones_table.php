<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_telephones', function (Blueprint $table) {
            /** Columna id(). Es mejor ya que es autoincremental y junto
             * a la id del empleado, no se repetira nunca cada registro de un telefono.
             */
            $table->id();
            /** Columna de la clave foranea del id del empleado. */
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            /** Columna del numero de telefono. Se declara String debido a que puede
             * incluir un signo + por los prefijos de los telefonos. Si fuera Integer
             * (que seria lo logico), el signo + y el numero 0 no seria posible contabilizarlo
             * si dicho numero seria el primero en introducirse
             * Ejemplo: El numero 094532189 si fuera Integer seria 94532189.
             */
            $table->string('number');
            $table->integer('order');
            /** Candado de seguridad. Evita que se repita el orden para el mismo empleado.
             * Esto nos servira para el Modelo de Telephone.php con una funcion,
             * la cual servira para autoincrementar el numero de orden para cada empleado.
            */
            $table->unique(['employee_id', 'order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_telephones');
    }
};
