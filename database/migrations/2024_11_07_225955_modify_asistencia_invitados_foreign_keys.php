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
            $table->dropForeign('fk_asistencia_invitado_invitados');
            $table->dropForeign('fk_asistencia_invitado_sesion');

            $table->dropColumn('INIVITADO_IDINVITADO');
            $table->dropColumn('SESION_IDSESION');

            $table->integer("INIVITADO_IDINVITADO");
            $table->integer("SESION_IDSESION")->after("INIVITADO_IDINVITADO");

            $table->foreign('INIVITADO_IDINVITADO', 'fk_invitados_in_asistencia_invitado')->references('IDINVITADOS')->on('invitados')->onDelete('restrict');
            $table->foreign('SESION_IDSESION', 'fk_sesion_in_asistencia_invitado')->references('IDSESION')->on('sesion')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia_invitado', function (Blueprint $table) {
            $table->dropForeign('fk_invitados_in_asistencia_invitado');
            $table->dropForeign('fk_sesion_in_asistencia_invitado');

            $table->dropColumn('INIVITADO_IDINVITADO');
            $table->dropColumn('SESION_IDSESION');

            $table->increments('INIVITADO_IDINVITADO');
            $table->increments('SESION_IDSESION')->after('INIVITADO_IDINVITADO');

            $table->foreign('INIVITADO_IDINVITADO', 'fk_invitados_in_asistencia_invitado')->references('IDINVITADOS')->on('invitados')->onDelete('restrict');
            $table->foreign('SESION_IDSESION', 'fk_sesion_in_asistencia_invitado')->references('IDSESION')->on('sesion')->onDelete('restrict');
        });
    }
};
