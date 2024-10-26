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
        Schema::create('descripcion', function (Blueprint $table) {
            $table->integer('ID_DESCRIPCION', true);
            $table->string('ESTU_IMPLICADOS', 200);
            $table->integer('NUM_ESTU_IMPLICADOS');
            $table->string('DOCEN_IMPLICADOS', 200);
            $table->integer('NUM_DOCEN_IMPLICADOS');
            $table->string('CIUDAD_IMPLICADA', 50);
            $table->string('PAIS_IMPLICADO', 30);
            $table->string('EVENTO', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descripcion');
    }
};
