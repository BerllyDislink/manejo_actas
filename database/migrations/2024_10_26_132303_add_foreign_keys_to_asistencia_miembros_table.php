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
        Schema::table('asistencia_miembros', function (Blueprint $table) {
            $table->foreign(['MIEMBRO_IDMIEMBRO'], 'fk_asistencia_miembros_miembros')->references(['IDMIEMBRO'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['SESSION_IDSESION'], 'fk_asistencia_miembros_sesion')->references(['IDSESION'])->on('sesion')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia_miembros', function (Blueprint $table) {
            $table->dropForeign('fk_asistencia_miembros_miembros');
            $table->dropForeign('fk_asistencia_miembros_sesion');
        });
    }
};
