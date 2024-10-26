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
        Schema::create('orden_sesion', function (Blueprint $table) {
            $table->integer('ID_ORDEN_SESION', true);
            $table->string('TEMA', 50);
            $table->string('DESCRIPCION', 200);
            $table->integer('SESION_IDSESION')->index('idx_sesion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_sesion');
    }
};
