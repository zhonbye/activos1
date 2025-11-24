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

        DB::table('devoluciones')->insert([
          [
        'numero_documento' => '001',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:01:00',
        'updated_at' => '2025-02-04 00:01:00',
    ],
    [
        'numero_documento' => '002',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:02:00',
        'updated_at' => '2025-02-04 00:02:00',
    ],
    [
        'numero_documento' => '003',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:03:00',
        'updated_at' => '2025-02-04 00:03:00',
    ],
    [
        'numero_documento' => '004',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:04:00',
        'updated_at' => '2025-02-04 00:04:00',
    ],
    [
        'numero_documento' => '005',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:05:00',
        'updated_at' => '2025-02-04 00:05:00',
    ],
    [
        'numero_documento' => '006',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:06:00',
        'updated_at' => '2025-02-04 00:06:00',
    ],
    [
        'numero_documento' => '007',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:07:00',
        'updated_at' => '2025-02-04 00:07:00',
    ],
    [
        'numero_documento' => '008',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:08:00',
        'updated_at' => '2025-02-04 00:08:00',
    ],
    [
        'numero_documento' => '009',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:09:00',
        'updated_at' => '2025-02-04 00:09:00',
    ],
    [
        'numero_documento' => '010',
        'gestion' => 2025,
        'fecha' => '2025-02-04',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => '',
        'estado' => 'pendiente',
        'url' => null,
        'created_at' => '2025-02-04 00:10:00',
        'updated_at' => '2025-02-04 00:10:00',
    ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
