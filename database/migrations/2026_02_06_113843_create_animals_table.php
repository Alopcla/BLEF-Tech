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
            // Atributo 'especies', el cual seria leon, jirafa, etc...
            $table->string('species');
            // Atributo 'ubicacion', donde se ubica el animal... Pais, por ejemplo.
            $table->string('location');
            // Atributo 'curiosidad'... Informacion relevante del animal.
            $table->string('curiosity');
            // Atributo 'imagen'... Ruta o URL de la imagen que se mostrara.
            $table->string('imagen');
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
