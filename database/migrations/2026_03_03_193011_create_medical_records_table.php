<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            // Campo 'id' del historial medico del animal
            $table->id();
            // Campo 'animal_id' que conecta con la tabla Animales
            $table->unsignedBigInteger('animal_id');
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            // Campo 'empleado_id' que conecta con la tabla Empleados
            // Al ser una clave foranea compuesta por numero y letras (DNI), tenemos que especificar en esta tabla
            // que el dato es de tipo STRING
            $table->string('employee_dni');
            $table->foreign('employee_dni')->references('dni')->on('employees')->onDelete('cascade');
            // Campo 'fecha'. Fecha la cual comenzo el historial del animal con dicho empleado.
            $table->date('date');
            $table->text('diagnosis');
            $table->text('treatment');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
