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
        Schema::create('detalle_alquileres', function (Blueprint $table) {
            $table->id();
            $table->integer('km_salida')->nullable();
            $table->integer('km_entrada')->nullable();
            $table->date('fecha_devolucion')->nullable();
            $table->integer('dias_alquiler');
            $table->text('observacion')->nullable();
            $table->unsignedBigInteger('auto_id');
            $table->foreign('auto_id')->references('id')->on('autos');
            $table->unsignedBigInteger('alquiler_id');
            $table->foreign('alquiler_id')->references('id')->on('alquileres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_alquileres');
    }
};
