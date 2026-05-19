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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donacion_id')->constrained('donaciones')->onDelete('cascade');
            $table->foreignId('organizacion_id')->constrained('organizaciones')->onDelete('cascade');
            $table->dateTime('fecha_reserva');
            $table->enum('estado', ['activa', 'completada', 'cancelada', 'vencida'])->default('activa');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
