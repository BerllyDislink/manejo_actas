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
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->integer('ID_SOLICITANTE', true);
            $table->string('NOMBRE', 20);
            $table->string('TIPO_DE_SOLICITANTE', 20);
            $table->string('EMAIL', 50);
            $table->string('CELULAR', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitantes');
    }
};
