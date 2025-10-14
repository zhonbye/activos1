<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_inventarios', function (Blueprint $table) {
            $table->id('id_detalle_inventario');
            $table->unsignedBigInteger('id_inventario');
            $table->unsignedBigInteger('id_activo');
            $table->string('estado_actual');
            $table->integer('cantidad')->default(1);
           $table->string('observaciones', 100)->nullable();

            $table->timestamps();

            $table->foreign('id_inventario')->references('id_inventario')->on('inventarios')->onDelete('cascade');
            $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('cascade');
        });

        DB::table('detalle_inventarios')->insert([
            'id_inventario' => 1,
            'id_activo' => 1,
            'estado_actual' => 'nuevo',
            'cantidad' => 1,
            'observaciones' => 'Detalle inventario inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_inventarios');
    }
};
