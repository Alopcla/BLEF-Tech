<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_telephones', function (Blueprint $table) {
            // PK compuesta: dni del cliente + orden
            $table->string('customer_dni', 20);
            $table->integer('order');
            $table->string('telephone', 20)->unique();
            $table->timestamps();

            $table->primary(['customer_dni', 'order']);
            $table->foreign('customer_dni')
                  ->references('dni')
                  ->on('customers')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_telephones');
    }
};
