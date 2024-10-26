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
        Schema::table('encargados_tareas', function (Blueprint $table) {
            $table->foreign(['MIEMBROS_IDMIEMBROS'], 'fk_encargados_tareas_miembros')->references(['IDMIEMBRO'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['TAREAS_IDTAREAS'], 'fk_encargados_tareas_tareas')->references(['IDTAREAS'])->on('tareas')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encargados_tareas', function (Blueprint $table) {
            $table->dropForeign('fk_encargados_tareas_miembros');
            $table->dropForeign('fk_encargados_tareas_tareas');
        });
    }
};
