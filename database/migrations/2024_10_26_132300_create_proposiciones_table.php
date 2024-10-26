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
        Schema::create('proposiciones', function (Blueprint $table) {
            $table->integer('ID_PROPOSICIONES', true);
            $table->string('DESCRIPCION', 200);
            $table->string('DESICION', 50);
            $table->integer('MIEMBRO_IDMIEMBRO')->index('idx_miembro');
            $table->integer('SESION_IDSESION')->index('idx_sesion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposiciones');
    }
};
