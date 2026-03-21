<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Estructura de la tabla Animal para la base de datos.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            // Cada animal tendrá un ID único.
            $table->id();
            // Campo Clave Foranea de la tabla Zona
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            // Campo 'nombre', nombre que se le llamara al animal
            $table->string('common_name');
            // Campo 'especies', el cual seria leon, jirafa, etc...
            $table->string('species');
            // Campo 'fecha de nacimiento' del animal
            $table->date('birth_date')->nullable();
            // Campo 'imagen'... Ruta o URL de la imagen que se mostrara.
            $table->string('image')->nullable();
            // Campo 'curiosidad'... Informacion relevante del animal.
            $table->string('curiosity')->nullable();
            // Campo 'dieta'... Ejemplo: Carnivoro - 5kg/dia
            $table->string('diet')->nullable();

            // Crea dos columnas, fecha de creacion y fecha de actualizacion.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Funcion para eliminar la tabla.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
