<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_bajas', function (Blueprint $table) {
            $table->id('id_detalle_baja');
            $table->unsignedBigInteger('id_baja');
            $table->unsignedBigInteger('id_activo');
            $table->integer('cantidad')->default(1);
            $table->string('observaciones', 100)->nullable();

            $table->timestamps();

            $table->foreign('id_baja')->references('id_baja')->on('bajas')->onDelete('cascade');
            $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('cascade');
        });

        DB::table('detalle_bajas')->insert([
            'id_baja' => 1,
            'id_activo' => 1,
            'cantidad' => 1,
            'observaciones' => 'Detalle baja inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_bajas');
    }
};
