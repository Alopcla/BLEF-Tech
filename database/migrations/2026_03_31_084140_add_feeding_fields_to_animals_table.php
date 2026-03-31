<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations. Dicha migracion sirve para incorporar dos campos
     * a la tabla Animals para poder realizar la funcionalidad en el Dashboard
     * de Cuidadores.
     */
    public function up(): void
    {
        // Añadimos los dos campos nuevos.
        // Fecha en la que se alimenta el animal
        // Ultima persona que alimento a dicho animal
        Schema::table('animals', function (Blueprint $table) {
            $table->date('last_fed_date')->nullable();
            $table->string('last_fed_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn(['last_fed_date', 'last_fed_by']);
        });
    }
};
