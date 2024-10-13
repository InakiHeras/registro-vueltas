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
        Schema::create('unidades_codes', function (Blueprint $table) {
            $table->id('IdCode');
            $table->integer('Unidad');
            $table->string('CodeQ');
            $table->dateTime('CreatedAt');
            $table->string('CreatedBy');
            $table->dateTime('UpdatedAt')->nullable();
            $table->string('UpdatedBy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_codes');
    }
};
