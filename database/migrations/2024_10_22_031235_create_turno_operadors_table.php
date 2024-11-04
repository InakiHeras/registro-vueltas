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
        Schema::create('turnos_operadores', function (Blueprint $table) {
            $table->id('IdTurnoOperador');
            $table->integer('ClaveOperador');
            $table->string('Operador');
            $table->string('Turno');
            $table->integer('Ruta');
            $table->string('Zona');
            $table->dateTime('FechaInicio');
            $table->dateTime('FechaFinalizado')->nullable(); 
            $table->boolean('Estatus');
            $table->timestamps(); 
            $table->string('CreatedBy');
            $table->string('UpdatedBy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos_operadores');
    }
};
