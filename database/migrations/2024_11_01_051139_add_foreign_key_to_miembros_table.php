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
        Schema::table('miembros', function (Blueprint $table) {
            $table->foreignId('user_id')->after('CARGO');
            $table->unique('user_id');
            $table->foreign('user_id', 'fk_miembros_users')->references("id")->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->dropForeign('fk_miembros_users');
            $table->dropColumn('user_id');
        });
    }
};
