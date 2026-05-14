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
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comercio_id')->constrained('comercios')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('cantidad');
            $table->decimal('peso_estimado_kg', 8, 2);
            $table->dateTime('fecha_limite');
            $table->enum('estado', ['publicada', 'reservada', 'entregada', 'vencida', 'cancelada'])->default('publicada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaciones');
    }
};
