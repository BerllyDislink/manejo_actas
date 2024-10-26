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
        Schema::table('proposiciones', function (Blueprint $table) {
            $table->foreign(['MIEMBRO_IDMIEMBRO'], 'fk_proposiciones_miembros')->references(['IDMIEMBRO'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['SESION_IDSESION'], 'fk_proposiciones_sesion')->references(['IDSESION'])->on('sesion')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposiciones', function (Blueprint $table) {
            $table->dropForeign('fk_proposiciones_miembros');
            $table->dropForeign('fk_proposiciones_sesion');
        });
    }
};
