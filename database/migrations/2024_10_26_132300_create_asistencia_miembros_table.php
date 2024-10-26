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
        Schema::create('asistencia_miembros', function (Blueprint $table) {
            $table->integer('SESSION_IDSESION');
            $table->integer('MIEMBRO_IDMIEMBRO')->index('idx_miembro');
            $table->text('ESTADO_ASISTENCIA')->nullable();

            $table->primary(['SESSION_IDSESION', 'MIEMBRO_IDMIEMBRO']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_miembros');
    }
};
