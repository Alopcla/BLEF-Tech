<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecosistemas', function (Blueprint $table) {
            $table->id();
            $table->string('clima');
            $table->string('region');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecosistemas');
    }
};