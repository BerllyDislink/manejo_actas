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
        Schema::create('asistencia_invitado', function (Blueprint $table) {
            $table->integer('INIVITADO_IDINVITADO');
            $table->integer('SESION_IDSESION')->index('idx_sesion');
            $table->string('ESTADO_ASISTENCIA', 10);

            $table->primary(['INIVITADO_IDINVITADO', 'SESION_IDSESION']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_invitado');
    }
};
