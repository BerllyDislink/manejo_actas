<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->integer('ID_ACTA')->after('NUM_ACTA');
            // Aquí podrías copiar los datos si es necesario
            $table->dropColumn('NUM_ACTA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->integer('NUM_ACTA')->after('ID_ACTA');
            // Aquí podrías copiar los datos si es necesario
            $table->dropColumn('ID_ACTA');
        });

    }
};
