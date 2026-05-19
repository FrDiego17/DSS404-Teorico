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
        Schema::create('impactos', function (Blueprint $table) {
        $table->id();
        // FK que une a la publicación con su respectiva ONG
        $table->foreignId('organizacion_id')->constrained('organizaciones')->onDelete('cascade');
        $table->string('titulo');
        $table->text('descripcion');
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impactos');
    }
};
