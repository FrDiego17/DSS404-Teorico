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
        Schema::create('reportes_impacto', function (Blueprint $table) {
            $table->id();
            $table->string('periodo', 50);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('total_donaciones')->default(0);
            $table->decimal('total_kg_salvados', 10, 2)->default(0);
            $table->integer('total_comidas_generadas')->default(0);
            $table->decimal('total_co2_evitado', 10, 2)->default(0);
            $table->integer('total_comercios_activos')->default(0);
            $table->integer('total_organizaciones_activas')->default(0);
            $table->integer('total_entregas_exitosas')->default(0);
            $table->datetime('fecha_generacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_impacto');
    }
};
