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

            $table->string('customer_dni');

            $table->date('date');
            $table->decimal('price', 8, 2);
            $table->string('type')->nullable(); // Ej: adulto, niño, familia...

            $table->foreign('customer_dni')->references('dni')->on('customers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
