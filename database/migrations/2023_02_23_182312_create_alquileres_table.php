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
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();
            $table->char('correlativo',10)->unique();
            $table->date('fecha_reserva');
            $table->date('fecha_alquiler');
            $table->date('fecha_devolucion')->nullable();
            $table->decimal('deposito',8,2)->nullable();
            $table->decimal('total',8,2);
            $table->char('estado',1)->default('R');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquileres');
    }
};
