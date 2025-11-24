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
            $table->string('numero_documento');
            $table->integer('gestion');
            $table->date('fecha');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_servicio_origen');

            $table->unsignedBigInteger('id_responsable_origen');
            $table->unsignedBigInteger('id_responsable_destino');
            $table->unsignedBigInteger('id_servicio_destino');
            $table->string('observaciones', 100)->nullable();

            $table->string('estado', 20)->default('pendiente');
            $table->string('url', 300)->nullable();

            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_servicio_origen')->references('id_servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('id_servicio_destino')->references('id_servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('id_responsable_origen')->references('id_responsable')->on('responsables')->onDelete('cascade');
            $table->foreign('id_responsable_destino')->references('id_responsable')->on('responsables')->onDelete('cascade');
        });

        DB::table('traslados')->insert([
            [
    'numero_documento' => '001',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:00:00',
    'updated_at' => '2025-02-03 08:00:00',
],
[
    'numero_documento' => '002',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:01:00',
    'updated_at' => '2025-02-03 08:01:00',
],
[
    'numero_documento' => '003',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:02:00',
    'updated_at' => '2025-02-03 08:02:00',
],
[
    'numero_documento' => '004',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:03:00',
    'updated_at' => '2025-02-03 08:03:00',
],
[
    'numero_documento' => '005',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:04:00',
    'updated_at' => '2025-02-03 08:04:00',
],
[
    'numero_documento' => '006',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:05:00',
    'updated_at' => '2025-02-03 08:05:00',
],
[
    'numero_documento' => '007',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:06:00',
    'updated_at' => '2025-02-03 08:06:00',
],
[
    'numero_documento' => '008',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:07:00',
    'updated_at' => '2025-02-03 08:07:00',
],
[
    'numero_documento' => '009',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:08:00',
    'updated_at' => '2025-02-03 08:08:00',
],
[
    'numero_documento' => '010',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_servicio_origen' => 4,
    'id_responsable_origen' => 4,
    'id_responsable_destino' => 5,
    'id_servicio_destino' => 5,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:09:00',
    'updated_at' => '2025-02-03 08:09:00',
],

        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('traslados');
    }
};
