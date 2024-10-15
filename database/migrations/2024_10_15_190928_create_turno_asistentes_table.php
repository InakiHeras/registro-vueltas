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
        Schema::create('turnos_asistentes', function (Blueprint $table) {
            $table->id('IdTurnoAsistente');
            $table->integer('ClaveAsistente');
            $table->string('Nombre');
            $table->string('Zona');
            $table->unsignedBigInteger('IdUsuario');
            $table->dateTime('FechaInicio');
            $table->dateTime('FechaFinalizado')->nullable();
            $table->boolean('Estatus')->default(1);
            $table->timestamps();
            $table->string('CreatedBy')->nullable();
            $table->string('UpdatedBy')->nullable();

            $table->foreign('IdUsuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos_asistentes');
    }
};
