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
        Schema::create('solicitud', function (Blueprint $table) {
            $table->integer('ID_SOLICITUD', true);
            $table->string('DEPENDENCIA', 50);
            $table->string('ASUNTO', 50);
            $table->string('DESICION', 50);
            $table->date('FECHA_DE_SOLICITUD');
            $table->integer('SOLICITANTE_IDSOLICITANTE')->index('idx_solicitante');
            $table->integer('SESION_IDSESION')->index('idx_sesion');
            $table->integer('DESCRIPCION_IDDESCRIPCION')->index('idx_descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud');
    }
};
