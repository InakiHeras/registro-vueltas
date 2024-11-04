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
        Schema::create('vueltas', function (Blueprint $table) {
            $table->id('IdVuelta');
            $table->unsignedBigInteger('IdTurnoAsistente');
            $table->unsignedBigInteger('IdTurnoOperador');
            $table->integer('IdCode');
            $table->dateTime('HoraSalida');
            $table->decimal('KilometrajeInicial', 8, 2);
            $table->dateTime('HoraLlegada')->nullable();
            $table->decimal('KilometrajeFinal', 8, 2)->nullable();
            $table->integer('BoletosVendidos');
            $table->string('Estado');
            
            $table->foreign('IdTurnoOperador')->references('IdTurnoOperador')->on('turnos_operadores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vueltas');
    }
};
