<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id('id_activo');
            $table->string('codigo');
            $table->string('nombre');
            $table->text('detalle')->nullable();
            $table->integer('cantidad')->default(1);
            $table->string('estado_situacional')->default('activo');
            // Definir columnas FK como unsignedBigInteger porque las PK referenciadas lo son
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_estado');
            $table->unsignedBigInteger('id_adquisicion');

            // Relaciones FK explícitas con nombres de columnas PK correspondientes
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_estado')->references('id_estado')->on('estados')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_adquisicion')->references('id_adquisicion')->on('adquisiciones')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });

        DB::table('activos')->insert([
            [
                'codigo' => 'A-001',
                'nombre' => 'Laptop Dell',
                'detalle' => 'Laptop para oficina',
                'cantidad' => 1,
                'estado_situacional' => 'activo',
                'id_categoria' => 1,
                'id_unidad' => 1,
                'id_estado' => 1,
                'id_adquisicion' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};
