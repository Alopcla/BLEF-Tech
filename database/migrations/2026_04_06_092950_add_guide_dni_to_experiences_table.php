<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            // 1. Añadimos la columna DNI del guía (nullable por si se crea una experiencia sin guía inicial)
            // La ponemos 'after' de la id para que quede ordenada en la base de datos
            $table->string('guide_dni')->nullable()->after('id');

            // 2. Creamos la relación foránea
            $table->foreign('guide_dni')
                  ->references('dni')
                  ->on('employees')
                  ->onDelete('set null'); // Si un guía es despedido/borrado, la exp. se queda sin guía (no se borra)
        });
    }

    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            // Pasos inversos por si nos arrepentimos y queremos deshacer la migración
            $table->dropForeign(['guide_dni']);
            $table->dropColumn('guide_dni');
        });
    }
};
