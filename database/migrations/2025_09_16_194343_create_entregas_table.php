<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id('id_entrega');
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
            // $table->unsignedBigInteger('id_responsable');
            $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('cascade');
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        });

        DB::table('entregas')->insert([
           [
    'numero_documento' => '001',
    'gestion' => 2025,
    'fecha' => '2025-02-01',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-01 08:00:00',
    'updated_at' => '2025-02-01 08:00:00',
],
[
    'numero_documento' => '002',
    'gestion' => 2025,
    'fecha' => '2025-02-02',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-02 08:00:00',
    'updated_at' => '2025-02-02 08:00:00',
],
[
    'numero_documento' => '003',
    'gestion' => 2025,
    'fecha' => '2025-02-03',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-03 08:00:00',
    'updated_at' => '2025-02-03 08:00:00',
],
[
    'numero_documento' => '004',
    'gestion' => 2025,
    'fecha' => '2025-02-04',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-04 08:00:00',
    'updated_at' => '2025-02-04 08:00:00',
],
[
    'numero_documento' => '005',
    'gestion' => 2025,
    'fecha' => '2025-02-05',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-05 08:00:00',
    'updated_at' => '2025-02-05 08:00:00',
],
[
    'numero_documento' => '006',
    'gestion' => 2025,
    'fecha' => '2025-02-06',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-06 08:00:00',
    'updated_at' => '2025-02-06 08:00:00',
],
[
    'numero_documento' => '007',
    'gestion' => 2025,
    'fecha' => '2025-02-07',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-07 08:00:00',
    'updated_at' => '2025-02-07 08:00:00',
],
[
    'numero_documento' => '008',
    'gestion' => 2025,
    'fecha' => '2025-02-08',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-08 08:00:00',
    'updated_at' => '2025-02-08 08:00:00',
],
[
    'numero_documento' => '009',
    'gestion' => 2025,
    'fecha' => '2025-02-09',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-09 08:00:00',
    'updated_at' => '2025-02-09 08:00:00',
],
[
    'numero_documento' => '010',
    'gestion' => 2025,
    'fecha' => '2025-02-10',
    'id_usuario' => 1,
    'id_responsable' => 3,
    'id_servicio' => 3,
    'observaciones' => null,
    'estado' => 'pendiente',
    'url' => null,
    'created_at' => '2025-02-10 08:00:00',
    'updated_at' => '2025-02-10 08:00:00',
],

        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
