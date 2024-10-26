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
        Schema::create('sesion', function (Blueprint $table) {
            $table->integer('IDSESION', true);
            $table->string('LUGAR', 50);
            $table->date('FECHA');
            $table->time('HORARIO_INICIO')->useCurrent();
            $table->time('HORARIO_FINAL')->nullable();
            $table->string('PRESIDENTE', 40);
            $table->string('SECRETARIO', 40);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion');
    }
};
