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
        Schema::table('solicitud', function (Blueprint $table) {
            $table->foreign(['DESCRIPCION_IDDESCRIPCION'], 'fk_solicitud_descripcion')->references(['ID_DESCRIPCION'])->on('descripcion')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['SESION_IDSESION'], 'fk_solicitud_sesion')->references(['IDSESION'])->on('sesion')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['SOLICITANTE_IDSOLICITANTE'], 'fk_solicitud_solicitantes')->references(['ID_SOLICITANTE'])->on('solicitantes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->dropForeign('fk_solicitud_descripcion');
            $table->dropForeign('fk_solicitud_sesion');
            $table->dropForeign('fk_solicitud_solicitantes');
        });
    }
};
