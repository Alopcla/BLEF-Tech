<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla de Pago_Entrada

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_payments', function (Blueprint $table) {
            $table->id(); // ID_Pago

            // 1. Columnas de Claves Foráneas (Manuales)
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('payment_card_id');
            $table->unsignedBigInteger('billing_address_id');

            // 2. Datos del pago
            $table->date('visit_day'); // Dia_Visita
            $table->decimal('total_amount', 8, 2); // Importe_Total
            $table->date('payment_date'); // Fecha_Pago
            $table->string('status'); // Estado (Ej: Pagado, Pendiente, Cancelado)

            $table->timestamps();

            // 3. Declaración de las relaciones
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('payment_card_id')->references('id')->on('payment_cards')->onDelete('cascade');
            $table->foreign('billing_address_id')->references('id')->on('billing_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_payments');
    }
};
