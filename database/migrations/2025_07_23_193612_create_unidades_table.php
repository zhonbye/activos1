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
        Schema::create('unidades', function (Blueprint $table) {
            $table->id('id_unidad');
            $table->string('nombre', 50);
            $table->string('abreviatura', 10);
            $table->timestamps();
        });

     DB::table('unidades')->insert([
    ['nombre' => 'Unidad', 'abreviatura' => 'u.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Pieza', 'abreviatura' => 'pza.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Caja', 'abreviatura' => 'cj.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Par', 'abreviatura' => 'par', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Set', 'abreviatura' => 'set', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Equipo', 'abreviatura' => 'eq.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Juego', 'abreviatura' => 'jgo.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidads');
    }
};
