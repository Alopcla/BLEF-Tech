<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedor_telefonos', function (Blueprint $table) {
            $table->foreignId('proveedor_id')
                  ->constrained('proveedores')
                  ->onDelete('cascade');
            $table->integer('orden');
            $table->string('telefono', 20)->unique();
            $table->timestamps();

            $table->primary(['proveedor_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor_telefonos');
    }
};