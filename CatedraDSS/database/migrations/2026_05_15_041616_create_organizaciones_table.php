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
    Schema::create('organizaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('nombre_oficial');
        $table->string('numero_registro')->unique(); // Registro de ONG en El Salvador
        $table->string('representante_legal');
        $table->text('mision')->nullable();
        $table->string('telefono_contacto');
        $table->string('direccion');
        $table->enum('estado_verificacion', ['pendiente', 'verificada', 'rechazada'])->default('pendiente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizaciones');
    }
};
