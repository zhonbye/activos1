<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id('id_inventario');
            $table->string('numero_documento')->unique();
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

       DB::table('inventarios')->insert([
    [
        'numero_documento' => '001',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 1,
        'id_servicio' => 1,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '002',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 2,
        'id_servicio' => 2,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '003',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 3,
        'id_servicio' => 3,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '004',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 4,
        'id_servicio' => 4,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '005',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 5,
        'id_servicio' => 5,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '006',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 6,
        'id_servicio' => 6,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '007',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 7,
        'id_servicio' => 7,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '008',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 8,
        'id_servicio' => 8,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '009',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 9,
        'id_servicio' => 9,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '010',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 10,
        'id_servicio' => 10,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '011',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 11,
        'id_servicio' => 11,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '012',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 12,
        'id_servicio' => 12,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '013',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 13,
        'id_servicio' => 13,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '014',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 14,
        'id_servicio' => 14,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '015',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 15,
        'id_servicio' => 15,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '016',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 16,
        'id_servicio' => 16,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '017',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 17,
        'id_servicio' => 17,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '018',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 18,
        'id_servicio' => 18,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '019',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 19,
        'id_servicio' => 19,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
    [
        'numero_documento' => '020',
        'gestion' => 2025,
        'fecha' => '2025-01-01 00:00:00',
        'id_usuario' => 1,
        'id_responsable' => 20,
        'id_servicio' => 20,
        'observaciones' => 'Inventario inicial generado automáticamente',
        'estado' => 'vigente',
        'url' => '',
        'created_at' => '2025-01-01 00:00:00',
        'updated_at' => '2025-01-01 00:00:00',
    ],
]);

        
    }

    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
