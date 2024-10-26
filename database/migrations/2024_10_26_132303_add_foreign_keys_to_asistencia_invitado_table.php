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
        Schema::table('asistencia_invitado', function (Blueprint $table) {
            $table->foreign(['INIVITADO_IDINVITADO'], 'fk_asistencia_invitado_invitados')->references(['IDINVITADOS'])->on('invitados')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['SESION_IDSESION'], 'fk_asistencia_invitado_sesion')->references(['IDSESION'])->on('sesion')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia_invitado', function (Blueprint $table) {
            $table->dropForeign('fk_asistencia_invitado_invitados');
            $table->dropForeign('fk_asistencia_invitado_sesion');
        });
    }
};
