<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id('id_devolucion');
            $table->string('numero_documento');
            $table->integer('gestion');
            $table->date('fecha');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_responsable');
            $table->unsignedBigInteger('id_servicio');
            $table->string('observaciones', 100)->nullable();

            $table->string('estado', 20)->default('pendiente');
            $table->string('url', 300)->nullable();

            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('cascade');
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        });

        // DB::table('devoluciones')->insert([
        //     'numero_documento' => '001',
        //     'gestion' => 2025,
        //     'fecha' => now(),
        //     'id_usuario' => 1,
        //     'id_responsable' => 1,
        //     'id_servicio' => 1,
        //     'observaciones' => 'Devolución inicial de prueba',
        //      'estado' => 'pendiente',
        //     'url' => null,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
