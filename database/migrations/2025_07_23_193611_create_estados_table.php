<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre', 50);
            $table->string('descripcion', 100)->nullable();
            $table->timestamps();
        });


        DB::table('estados')->insert([
    ['nombre' => 'NUEVO', 'descripcion' => 'En perfecto estado, sin uso', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'BUENO', 'descripcion' => 'Funciona correctamente, con poco uso', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'REGULAR', 'descripcion' => 'Con uso moderado, algunas señales de desgaste', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'MALO', 'descripcion' => 'Dañado, con fallas, requiere reparación', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'OBSOLETO', 'descripcion' => 'No se recomienda uso, tecnología antigua', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'FUERA DE SERVICIO', 'descripcion' => 'No operativo, en espera de baja o reparación', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
