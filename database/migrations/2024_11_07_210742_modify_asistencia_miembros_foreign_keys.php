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
           /*  $table->dropForeign('fk_asistencia_miembros_sesion');
            $table->dropForeign('fk_asistencia_miembros_miembros');

            $table->dropColumn('SESSION_IDSESION');
            $table->dropColumn('MIEMBRO_IDMIEMBRO');
            
            $table->integer('SESSION_IDSESION');
            $table->integer('MIEMBRO_IDMIEMBRO')->after('SESSION_IDSESION');
            */
            
            $table->foreign('SESSION_IDSESION', 'fk_sesion_in_asistencia_miembros')->references('IDSESION')->on('sesion')->onDelete('restrict');
            $table->foreign('MIEMBRO_IDMIEMBRO', 'fk_miembro_in_asistencia_miembros')->references('IDMIEMBRO')->on('miembros')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia_miembros', function (Blueprint $table) {
            $table->dropForeign('fk_sesion_in_asistencia_miembros');
            $table->dropForeign('fk_miembro_in_asistencia_miembros');

            $table->dropColumn('SESSION_IDSESION');
            $table->dropColumn('MIEMBRO_IDMIEMBRO');

            $table->increments('SESSION_IDSESION');
            $table->increments('MIEMBRO_IDMIEMBRO')->after('SESSION_IDSESION');

            $table->foreign('SESSION_IDSESION', 'fk_sesion_in_asistencia_miembros')->references('IDSESION')->on('sesion')->onDelete('restrict');
            $table->foreign('MIEMBRO_IDMIEMBRO', 'fk_miembro_in_asistencia_miembros')->references('IDMIEMBRO')->on('miembros')->onDelete('restrict');

        });
    }
};
