<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('reserve_experiences', function (Blueprint $table) {
            // Campo 'id' principal de la reserva
            $table->id();

            // 1. Columnas de las Claves Foráneas
            $table->string('customer_dni');
            $table->unsignedBigInteger('experience_id'); // Cambiado a convención de Laravel
            $table->string('employee_guide_dni');

            // 2. Datos de la reserva
            $table->date('reservation_date');
            $table->boolean('status')->default(true); // Sin comillas
            $table->timestamps();

            // 3. Declaración MANUAL de las 3 Claves Foráneas
            $table->foreign('customer_dni')->references('dni')->on('customers')->onDelete('cascade');
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->foreign('employee_guide_dni')->references('dni')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserve_experiences');
    }
};
