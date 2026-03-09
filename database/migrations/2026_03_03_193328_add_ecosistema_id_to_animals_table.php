<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            // Añadimos la FK a ecosistemas después de la columna 'imagen'
            $table->foreignId('ecosystem_id')
                  ->nullable()
                  ->after('imagen')
                  ->constrained('ecosystems')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign(['ecosystem_id']);
            $table->dropColumn('ecosystem_id');
        });
    }
};
