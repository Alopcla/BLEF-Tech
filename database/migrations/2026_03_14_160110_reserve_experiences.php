<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('reserve_experiences');

        Schema::create('reserve_experiences', function (Blueprint $table) {
            $table->id();

            // Relación con experiencia
            $table->unsignedBigInteger('experience_id');

            // Datos de Stripe / usuario
            $table->string('email');
            $table->date('reservation_date')->nullable();
            $table->decimal('price', 8, 2);

            // Stripe tracking (MUY IMPORTANTE)
            $table->string('stripe_session_id')->unique();

            // Estado de la reserva
            $table->string('status')->default('pending');

            $table->timestamps();

            // Foreign key
            $table->foreign('experience_id')
                  ->references('id')
                  ->on('experiences')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserve_experiences');
    }
};