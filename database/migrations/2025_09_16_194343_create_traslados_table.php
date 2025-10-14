<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traslados', function (Blueprint $table) {
            $table->id('id_traslado');
            $table->string('numero_documento')->unique();
            $table->integer('gestion');
            $table->date('fecha');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_servicio_origen');
            $table->unsignedBigInteger('id_servicio_destino');
            $table->string('observaciones', 100)->nullable();

              $table->string('estado', 20)->default('pendiente');
            $table->string('url', 300)->nullable();

            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_servicio_origen')->references('id_servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('id_servicio_destino')->references('id_servicio')->on('servicios')->onDelete('cascade');
        });

        DB::table('traslados')->insert([
            'numero_documento' => '001',
            'gestion' => 2025,
            'fecha' => now(),
            'id_usuario' => 1,
            'id_servicio_origen' => 1,
            'id_servicio_destino' => 2,
            'observaciones' => 'Traslado inicial de prueba',
             'estado' => 'pendiente',
            'url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('traslados');
    }
};
