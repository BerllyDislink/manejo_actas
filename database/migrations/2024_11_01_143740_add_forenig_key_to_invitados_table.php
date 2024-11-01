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
        Schema::table('invitados', function (Blueprint $table) {
            $table->foreignId('user_id')->after('CARGO');
            $table->unique('user_id');
            $table->foreign('user_id', 'fk_invitados_users')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitados', function (Blueprint $table) {
            $table->dropForeign('fk_invitados_user');
            $table->dropColumn('user_id');
        });
    }
};
