<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla de Tarjeta_Pago

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_cards', function (Blueprint $table) {

            $table->id();

            $table->string('customer_dni');

            // Tipo de tarjeta, Visa, Mastercard...
            $table->string('card_type');
            // Campo de numero de tarjeta, siendo STRING porque el numero es demasiado largo
            $table->string('card_number');
            // Campo de fecha de expiracion de tarjeta... EJ: 12/29
            $table->string('expiration_date');
            $table->string('cvv');

            $table->timestamps();

            $table->foreign('customer_dni')->references('dni')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_cards');
    }
};
