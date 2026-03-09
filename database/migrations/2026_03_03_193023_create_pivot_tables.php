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
            $table->foreignId('zone_id')
                  ->constrained('zones')
                  ->onDelete('cascade');
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->primary(['zone_id', 'employee_id']);
        });

        // ----------------------------------
        // GESTIONA — Empleado gestiona Servicio
        // ----------------------------------
        Schema::create('gestiona', function (Blueprint $table) {
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->primary(['service_id', 'employee_id']);
        });

        // ----------------------------------
        // UBICADO EN — Servicio ubicado en Zona
        // ----------------------------------
        Schema::create('ubicado_en', function (Blueprint $table) {
            $table->foreignId('zone_id')
                  ->constrained('zones')
                  ->onDelete('cascade');
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');
            $table->primary(['zone_id', 'service_id']);
        });

        // ----------------------------------
        // TRABAJA — Empleado trabaja con Producto
        // ----------------------------------
        Schema::create('trabaja', function (Blueprint $table) {
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            $table->primary(['employee_id', 'product_id']);
        });

        // ----------------------------------
        // VENDE — Empleado vende Entrada
        // ----------------------------------
        Schema::create('vende', function (Blueprint $table) {
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
            $table->foreignId('ticket_id')
                  ->constrained('tickets')
                  ->onDelete('cascade');
            $table->primary(['employee_id', 'ticket_id']);
        });

        // ----------------------------------
        // COMPRA — Cliente compra Entrada
        // ----------------------------------
        Schema::create('compra', function (Blueprint $table) {
            $table->string('customer_dni', 20);
            $table->foreignId('ticket_id')
                  ->constrained('tickets')
                  ->onDelete('cascade');
            $table->primary(['customer_dni', 'ticket_id']);
            $table->foreign('customer_dni')
                  ->references('dni')
                  ->on('customers')
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
