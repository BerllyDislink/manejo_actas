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
        Schema::create('encargados_tareas', function (Blueprint $table) {
            $table->string('ESTADO', 20);
            $table->integer('MIEMBROS_IDMIEMBROS');
            $table->integer('TAREAS_IDTAREAS')->index('idx_tareas');

            $table->primary(['MIEMBROS_IDMIEMBROS', 'TAREAS_IDTAREAS']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encargados_tareas');
    }
};
