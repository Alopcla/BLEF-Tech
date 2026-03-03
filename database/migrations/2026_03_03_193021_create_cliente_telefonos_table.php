<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_telefonos', function (Blueprint $table) {
            // PK compuesta: dni del cliente + orden
            $table->string('cliente_dni', 20);
            $table->integer('orden');
            $table->string('telefono', 20)->unique();
            $table->timestamps();

            $table->primary(['cliente_dni', 'orden']);
            $table->foreign('cliente_dni')
                  ->references('dni')
                  ->on('clientes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_telefonos');
    }
};