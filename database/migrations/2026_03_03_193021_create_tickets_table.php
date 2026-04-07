<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email');

            $table->string('cod_ticket')->unique();
            
            // Datos de la Visita
            $table->date('visit_day');
            $table->decimal('price', 8, 2);

            $table->string('stripe_session_id')->nullable();
            $table->decimal('total_order_amount', 8, 2);

            $table->string('status')->default('paid');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
