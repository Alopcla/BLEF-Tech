<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ----------------------------------
        // CUIDA DE — Empleado cuida Animal
        // ----------------------------------
        Schema::create('cuida_de', function (Blueprint $table) {
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->foreignId('animal_id')
                  ->constrained('animals')
                  ->onDelete('cascade');
            $table->primary(['employee_id', 'animal_id']);
        });

        // ----------------------------------
        // MANTIENE — Empleado mantiene Zona
        // ----------------------------------
        Schema::create('mantiene', function (Blueprint $table) {
            $table->foreignId('zona_id')
                  ->constrained('zonas')
                  ->onDelete('cascade');
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->primary(['zona_id', 'employee_id']);
        });

        // ----------------------------------
        // GESTIONA — Empleado gestiona Servicio
        // ----------------------------------
        Schema::create('gestiona', function (Blueprint $table) {
            $table->foreignId('servicio_id')
                  ->constrained('servicios')
                  ->onDelete('cascade');
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->primary(['servicio_id', 'employee_id']);
        });

        // ----------------------------------
        // UBICADO EN — Servicio ubicado en Zona
        // ----------------------------------
        Schema::create('ubicado_en', function (Blueprint $table) {
            $table->foreignId('zona_id')
                  ->constrained('zonas')
                  ->onDelete('cascade');
            $table->foreignId('servicio_id')
                  ->constrained('servicios')
                  ->onDelete('cascade');
            $table->primary(['zona_id', 'servicio_id']);
        });

        // ----------------------------------
        // TRABAJA — Empleado trabaja con Producto
        // ----------------------------------
        Schema::create('trabaja', function (Blueprint $table) {
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->onDelete('cascade');
            $table->primary(['employee_id', 'producto_id']);
        });

        // ----------------------------------
        // VENDE — Empleado vende Entrada
        // ----------------------------------
        Schema::create('vende', function (Blueprint $table) {
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->foreignId('entrada_id')
                  ->constrained('entradas')
                  ->onDelete('cascade');
            $table->primary(['employee_id', 'entrada_id']);
        });

        // ----------------------------------
        // COMPRA — Cliente compra Entrada
        // ----------------------------------
        Schema::create('compra', function (Blueprint $table) {
            $table->string('cliente_dni', 20);
            $table->foreignId('entrada_id')
                  ->constrained('entradas')
                  ->onDelete('cascade');
            $table->primary(['cliente_dni', 'entrada_id']);
            $table->foreign('cliente_dni')
                  ->references('dni')
                  ->on('clientes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra');
        Schema::dropIfExists('vende');
        Schema::dropIfExists('trabaja');
        Schema::dropIfExists('ubicado_en');
        Schema::dropIfExists('gestiona');
        Schema::dropIfExists('mantiene');
        Schema::dropIfExists('cuida_de');
    }
};