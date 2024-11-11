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
        Schema::table('turnos_asistentes', function (Blueprint $table) {
            Schema::table('turnos_asistentes', function (Blueprint $table) {
                $table->string('ruta')->nullable()->after('Zona');
                $table->string('turno')->nullable()->after('ruta');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turnos_asistentes', function (Blueprint $table) {
            Schema::table('turnos_asistentes', function (Blueprint $table) {
                $table->dropColumn(['ruta', 'turno']);
            });
        });
    }
};
