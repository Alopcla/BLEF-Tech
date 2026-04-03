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
        Schema::create('experiences', function (Blueprint $table){
            // Campo 'id_experiencia', id principal
            $table->id();
            // Campo foraneo del 'zona_id', que conecta con la tabla Zonas
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            // Campo 'nombre', siendo el nombre de la experiencia
            $table->string('name');
            // Campo 'slug', una versión amigable del nombre para URLs (ej: "nado-con-delfines")
            $table->string('slug')->unique();
            // Campo ''descripcion', breve descripcion de la experiencia del zoo
            $table->string('description')->nullable();
            // Información EXTENSA para la página de detalle
            $table->text('details')->nullable();
            // Campo 'duracion', siendo en minutos lo que dura la experiencia
            $table->integer('duration_min');
            // Campo 'precio', conteniendo el precio numeros decimalos. Ejemplo: 10,20 euros
            $table->decimal('price');
            // Campo 'capacidad', numero de personas puede ocupar dicha experiencia
            $table->integer('capacity');
            // Campo 'Imagen', contiene la imagen de la experiencia
            $table->string('image')->nullable(); // Permite null si no hay imagen
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
