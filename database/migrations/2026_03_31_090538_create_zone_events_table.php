<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zone_events', function (Blueprint $table) {
            $table->id();

            // Relación con el 'type' de tu tabla zones
            $table->string('zone_type');

            $table->string('title'); // Ej: "Obras de mejora"
            $table->text('message'); // Ej: "Estamos renovando el suelo..."

            // Los tres niveles que pediste
            $table->enum('level', ['aviso', 'alerta', 'peligro'])->default('aviso');

            $table->boolean('active')->default(true);
            $table->timestamps();

            // Opcional: Integridad referencial si quieres que Laravel vigile los cambios
            // $table->foreign('zone_type')->references('type')->on('zones')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zone_events');
    }
};
