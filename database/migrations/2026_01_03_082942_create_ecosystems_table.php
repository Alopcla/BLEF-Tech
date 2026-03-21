<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecosystems', function (Blueprint $table) {
            // Campo 'id' del ecosistema
            $table->id();
            // Campo 'nombre' del ecosistema
            $table->string('name');
            // Campo 'clima'. Ejemplo: Arido, Subtropical...
            $table->string('climate');
            // Campo 'region'. Ejemplo: Africa, Sudafrica...
            $table->string('region');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecosystems');
    }
};
