<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_entregas', function (Blueprint $table) {
            $table->id('id_detalle_entrega');
            $table->unsignedBigInteger('id_entrega');
            $table->unsignedBigInteger('id_activo');
            $table->integer('cantidad')->default(1);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_entrega')->references('id_entrega')->on('entregas')->onDelete('cascade');
            $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('cascade');
        });

        DB::table('detalle_entregas')->insert([
            'id_entrega' => 1,
            'id_activo' => 1,
            'cantidad' => 2,
            'observaciones' => 'Detalle entrega inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_entregas');
    }
};
