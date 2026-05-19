<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->foreignId('voluntario_id')->nullable()->constrained('voluntarios')->onDelete('set null')->after('organizacion_id');
            $table->string('codigo_verificacion', 4)->nullable()->after('voluntario_id');
            $table->boolean('codigo_usado')->default(false)->after('codigo_verificacion');
        });
    }

    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['voluntario_id']);
            $table->dropColumn(['voluntario_id', 'codigo_verificacion', 'codigo_usado']);
        });
    }
};
