<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_telephones', function (Blueprint $table) {
            $table->id();

            $table->string('customer_dni');
            $table->foreign('customer_dni')->references('dni')->on('customers')->onDelete('cascade');

            $table->integer('order');
            $table->string('telephone', 20)->unique();
            $table->timestamps();

            $table->unique(['customer_dni', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_telephones');
    }
};
