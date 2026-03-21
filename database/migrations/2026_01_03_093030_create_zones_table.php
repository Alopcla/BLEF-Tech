<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            // Campo 'id' de la zona
            $table->id();
            // Campo 'id_ecosistema' que conecta con la tabla Ecosistema
            $table->foreignId('ecosystem_id')->constrained('ecosystems')->onDelete('cascade');
            // Campo 'tipo'. Ejemplo: Acuario, Interior, Exterior, etc
            $table->string('type');
            // Campo 'dimensiones_m2'. Ejemplo: Dimensiones en metros cuadrados
            $table->string('dimensions_m2');
            // Campo 'descripcion'. Breve descripcion de la zona del zoologico.
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
