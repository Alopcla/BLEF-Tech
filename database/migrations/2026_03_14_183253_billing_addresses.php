<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla de Direccion_Facturacion

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billing_addresses', function (Blueprint $table) {
            $table->id(); // ID_Direccion

            // Clave foránea al cliente
            $table->string('customer_dni');

            // Datos de facturación
            $table->string('owner_name'); // Nombre_Titular
            $table->string('owner_surnames'); // Apellidos_Titular
            $table->string('address'); // Direccion
            $table->string('postal_code'); // Codigo_Postal

            $table->timestamps();

            $table->foreign('customer_dni')->references('dni')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_addresses');
    }
};
