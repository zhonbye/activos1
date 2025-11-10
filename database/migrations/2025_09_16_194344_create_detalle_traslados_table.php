<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_traslados', function (Blueprint $table) {
            $table->id('id_detalle_traslado');
            $table->unsignedBigInteger('id_traslado');
            $table->unsignedBigInteger('id_activo');
$table->string('observaciones', 100)->nullable();
            $table->timestamps();

            $table->foreign('id_traslado')->references('id_traslado')->on('traslados')->onDelete('cascade');
            $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('cascade');
        });

        DB::table('detalle_traslados')->insert([
            'id_traslado' => 1,
            'id_activo' => 1,
            'observaciones' => 'Detalle traslado inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_traslados');
    }
};
