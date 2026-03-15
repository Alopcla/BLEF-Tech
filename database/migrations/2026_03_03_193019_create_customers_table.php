<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            // PK es el DNI (string), no un id autoincremental
            $table->string('dni')->primary();
            
            $table->string('user_name')->unique();
            $table->string('name');
            $table->string('surnames');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('category');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
