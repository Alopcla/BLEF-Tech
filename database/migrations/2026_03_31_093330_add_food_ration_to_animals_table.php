<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations. Migracion para incluir el campo de cantidad de comida del animal.
     * Nos servira para la informacion de cada animal para checar si ha comido dicha cantidad.
     */
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->string('food_ration')->nullable(); // Ej: "5kg carne", "200g semillas"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            //
        });
    }
};
