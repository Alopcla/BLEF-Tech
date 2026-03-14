<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_telephones', function (Blueprint $table) {
            $table->foreignId('supplier_id')
                  ->constrained('suppliers')
                  ->onDelete('cascade');
            $table->integer('order');
            $table->string('telephone', 20)->unique();
            $table->timestamps();

            $table->primary(['supplier_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_telephones');
    }
};
