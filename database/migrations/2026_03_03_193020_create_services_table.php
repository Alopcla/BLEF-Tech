<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            // Campo 'id' de los servicios del Zoo
            $table->id();
            // Campo 'zona_id' que conecta con la tabla Zonas.
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            // Campo
            $table->string('employee_dni');
            $table->foreign('employee_dni')->references('dni')->on('employees')->onDelete('cascade');
            
            $table->string('name');
            $table->string('type');
            $table->text('description')->nullable();
            $table->boolean('availability');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
