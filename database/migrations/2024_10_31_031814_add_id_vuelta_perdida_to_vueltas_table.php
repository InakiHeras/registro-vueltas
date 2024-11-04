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
        Schema::table('vueltas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_vuelta_perdida')->nullable()->after('IdTurnoAsistente');
            $table->foreign('id_vuelta_perdida')->references('id')->on('vueltas_perdidas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vueltas', function (Blueprint $table) {
            $table->dropForeign(['id_vuelta_perdida']);
            $table->dropColumn('id_vuelta_perdida');
        });
    }
};
