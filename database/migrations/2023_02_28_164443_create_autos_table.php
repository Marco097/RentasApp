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
        Schema::create('autos', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 15)->unique();
            $table->string('tipo', 1);
            $table->integer('anio');
            $table->decimal('precio_alquiler', 8, 2);
            $table->string('imagen', 100);
            $table->string('estado', 1)->default('D');
            /*llave foranea para relacionar con la tabla marcas */
            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
            /*llave foranea para relacionar con la tabla modelos */
            $table->unsignedBigInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('modelos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
